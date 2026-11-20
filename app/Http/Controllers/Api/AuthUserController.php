<?php

namespace App\Http\Controllers\Api;

use App\Enums\ErrorCodeEnum;
use App\Enums\UserStatusEnum;
use App\Helpers\SettingHelpers;
use App\Http\Controllers\Controller;
use App\Http\Exceptions\CustomHttpException;
use App\Http\Resources\User\AuthResource;
use App\Libraries\ExceptionLib;
use App\Libraries\ResponseLib;
use App\Models\User;
use App\Services\User\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthUserController extends Controller
{

    public function authorizeUser(Request $req)
    {
        $user = $req->user();
        // $wallet = UserWalletResource::collection($user->wallet);

        $userData = (new AuthResource($user))->resolve($req);

        return response()->json([
            "data" => [
                ...$userData,
            ]
        ]);
    }

    public function register(Request $req)
    {
        $req->validate([
            'name' => 'string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|confirmed|min:8',
            'phone_number' => 'required|digits_between:9,20'
        ]);

        try {
            if (! SettingHelpers::get('allow_register')) {
                ExceptionLib::throwCustomException(
                    'Registration is currently disabled.',
                    ErrorCodeEnum::FORBIDDEN->value
                );
            }

            $user = User::firstOrCreate([
                'username' => $req['username']
            ], [
                'name' => $req['name'],
                'password' => Hash::make($req['password']),
                'phone_number' => $req['phone_number'],
                'depth' => 1,
                'commission' => 0,
                'status' => UserStatusEnum::ACTIVE->value
            ]);
            $user->refresh();

            return ResponseLib::success(
                message: "Register Successfully.",
                status: Response::HTTP_OK,
                data: new AuthResource($user)
            );
        } catch (CustomHttpException $th) {
            ExceptionLib::throwCustomException(
                $th->getMessage(),
                $th->getErrorCode()
            );
        } catch (\Throwable $e) {
            logger()->error('Error in method: ' . __METHOD__, [
                'exception' => $e,
                'custom_data' => optional($req)->all(),
            ]);

            report($e);

            return ResponseLib::error(
                message: "Authentication failed.",
                status: Response::HTTP_INTERNAL_SERVER_ERROR,
                additional: ["success" => false]
            );
        }
    }

    public function login(Request $req)
    {
        $req->validate([
            'username' => 'required|string|max:255',
            'password' => 'required',
        ]);

        try {
            $user = AuthService::authenticate($req->username, $req->password);

            $res = $user->createToken('auth-token');

            return ResponseLib::success(
                message: "Login Successfully.",
                data: [
                    ...(new AuthResource($user))->resolve($req),
                ],
                additional: [
                    'token' => [
                        'accessToken' => $res->accessToken,
                        'expiresIn' => $res->expiresIn,
                        'tokenType' => $res->tokenType,
                    ],
                    "success" => true
                ]
            );
        } catch (CustomHttpException $th) {
            ExceptionLib::throwCustomException(
                $th->getMessage(),
                $th->getErrorCode()
            );
        } catch (\Throwable $e) {
            logger()->error('Error in method: ' . __METHOD__, [
                'exception' => $e,
                'custom_data' => optional($req)->all(),
            ]);

            report($e);

            return ResponseLib::error(
                message: "Authentication failed.",
                status: Response::HTTP_INTERNAL_SERVER_ERROR,
                additional: ["success" => false]
            );
        }
    }

    public function logout(Request $req)
    {
        try {
            $token = $req->user()->token();
            $token->revoke();

            return ResponseLib::success(message: 'Logout was successful.', additional: ["success" => true]);
        } catch (\Throwable $e) {
            return ResponseLib::error(message: 'Failed to logout.', additional: ["success" => false]);
        }
    }

    public function updatePassword(Request $req)
    {
        $req->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed|min:8',
        ]);

        try {
            if (! Hash::check($req->old_password, $req->user()->password)) {
                ExceptionLib::throwCustomException(
                    'Invalid old password.',
                    ErrorCodeEnum::INVALID_OLD_PASSWORD->value
                );
            }
            $user = $req->user();
            $user->password = Hash::make($req->new_password);
            $user->save();

            return ResponseLib::success(message: 'Updated successfully.', additional: ["success" => true]);
        } catch (CustomHttpException $th) {
            ExceptionLib::throwCustomException(
                $th->getMessage(),
                $th->getErrorCode()
            );
        } catch (\Throwable $e) {

            return ResponseLib::error(message: 'Failed to update password.', additional: ["success" => false]);
        }
    }

    public function updateAuthUser(Request $req)
    {
        $user = $req->user();

        $req->validate([
            'name'         => 'sometimes|string|max:255',
            'phone_number' => [
                'nullable',
                'digits_between:9,20'
            ],
            'new_password'  => 'nullable|confirmed|min:6',
            'auth_password' => 'required_with:new_password|string',
            // You can add validation for dynamic app keys here if needed
        ]);

        try {
            // 1. Handle Password Update (if provided)
            if ($req->filled('new_password')) {
                if (! Hash::check($req->auth_password, $user->password)) {
                    ExceptionLib::throwCustomException(
                        'Wrong credentials',
                        ErrorCodeEnum::WRONG_CREDENTIALS->value
                    );
                }

                $user->password = Hash::make($req->new_password);
            }

            // 2. Update Basic Info
            if ($req->has('name')) $user->name = $req->name;
            if ($req->has('phone_number')) $user->phone_number = $req->phone_number;

            $user->save();

            // 3. Notify partner platforms of the profile update

            return ResponseLib::success(
                message: 'Account updated successfully.',
                data: ["user" => new AuthResource($user)],
                additional: ["success" => true]
            );
        } catch (CustomHttpException $th) {
            // Re-throw to let your global handler deal with it
            throw $th;
        } catch (\Throwable $e) {
            return ResponseLib::error(
                message: 'Failed to update account: ' . $e->getMessage(),
                additional: ["success" => false]
            );
        }
    }

    /**
     * Build the optional permissions payload when requested via the `permission` flag.
     */
    private function getPermissionData(Request $req, User $user): array
    {
        if (! $req->boolean('permission')) {
            return [];
        }

        return [
            "permissions" => [
                "can_view_platform_transactions" => $user->canViewPlatformTransactions(),
                "can_view_partner_user_tracker" => $user->canViewPartnerUserTracker(),
                "can_view_agent_dashboard" => $user->canViewAgentDashboard(),
                "can_view_agent_transactions" => $user->canViewAgentTransactions(),
                "can_agent_deposit" => $user->canAgentDeposit(),
                "can_agent_withdraw" => $user->canAgentWithdraw(),
                "can_view_agent_users" => $user->canViewAgentUsers(),
                "can_block_agent_users" => $user->canBlockAgentUsers(),
                "can_create_agent_users" => $user->canCreateAgentUsers(),
                "can_create_auto_agent_users" => $user->canCreateAutoAgentUsers(),
                "can_edit_agent_users" => $user->canEditAgentUsers(),
                "can_view_agent_admins" => $user->canViewAgentAdmins(),
                "can_create_agent_admins" => $user->canCreateAgentAdmins(),
                "can_edit_agent_admins" => $user->canEditAgentAdmins(),
                "can_view_agent_total_report" => $user->canViewAgentTotalReport(),
                "can_view_agent_member_report" => $user->canViewAgentMemberReport(),
                "can_view_agent_last_balance" => $user->canViewAgentLastBalance(),
                "can_view_real_time_bets" => $user->canViewRealTimeBets(),
                
            ],
        ];
    }
}
