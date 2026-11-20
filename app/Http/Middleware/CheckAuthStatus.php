<?php
namespace App\Http\Middleware;

use App\Enums\ErrorCodeEnum;
use App\Libraries\ExceptionLib;
use App\Models\User;
use App\Services\User\UserStatusChecker;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAuthStatus
{
    protected UserStatusChecker $checker;

    public function __construct(UserStatusChecker $checker)
    {
        $this->checker = $checker;
    }

    /**
     * $parameters can be: "allow_inactive"
     */
    public function handle(Request $request, Closure $next): Response
    {

        $user = $request->user();

        if (!$this->checker->isAllowed($user)) {
            ExceptionLib::throwCustomException(
                message: $this->checker->getErrorMessage($user),
                errorCode: ErrorCodeEnum::FORBIDDEN->value
            );
        }

        return $next($request);
    }
}