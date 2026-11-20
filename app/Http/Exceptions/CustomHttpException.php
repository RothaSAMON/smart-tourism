<?php

namespace App\Http\Exceptions;

use App\Enum\ErrorCodeEnum;
use Exception;
use Illuminate\Http\Request;
use App\Libraries\ResponseLib;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class CustomHttpException extends Exception
{
    protected $errorCode;
    protected $statusCode;
    protected $field;

    /**
     * @param string $message The human-readable description
     * @param string $errorCode The machine-readable code
     */
    public function __construct(string $message, string $errorCode, ?string $field = null)
    {
        parent::__construct($message);
        $this->errorCode = $errorCode;
        $this->field = $field;
        $this->statusCode = ErrorCodeEnum::enumToStatusCode($errorCode);
    }

    /**
     * Render the exception into an HTTP response.
     */
    public function render(Request $request): JsonResponse|RedirectResponse
    {
        $field = $this->field ?: 'message';
        if ($request->expectsJson()) {
            return ResponseLib::validateError([
                    $field => $this->getMessage(),
                    'code' => $this->errorCode,
            ], $this->statusCode);
        }

        return Redirect::back()
            ->withInput()
            ->withErrors([
                $field => $this->getMessage(),
                'code' => $this->errorCode
            ]);
    }

    public function getErrorCode(): string
    {
        return $this->errorCode;
    }
    
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getField(): ?string
    {
        return $this->field;
    }
}
