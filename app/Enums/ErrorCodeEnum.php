<?php

namespace App\Enums;

use App\Enums\Traits\EnumTrait;

enum ErrorCodeEnum: string
{
    use EnumTrait;

    /**
     * 400 Bad Request
     */
    case VALIDATION_FAILED = 'validation_failed';
    case INVALID_DATA_ENCRYPT = 'invalid_data_encrypt';
    case REQUEST_IN_PROGRESS = 'request_in_progress';
    case CONCURRENT_LIMIT = 'concurrent_limit';
    case INVALID_OLD_PASSWORD = 'invalid_old_password';
    case WRONG_CREDENTIALS = 'wrong_credentials';
    case DB_UNIQUE_CONSTRAINT_VIOLATION_EXCEPTION = 'db_unique_constraint_violation_exception';
    case OUTBOX_DIFF_STATUS = 'outbox_diff_status';
    case OUTBOX_ALREADY_PROCESSED = 'outbox_already_processed';

    /**
     * 404 Not Found
     */
    case USER_NOT_FOUND = 'user_not_found';
    case PARENT_NOT_FOUND = 'parent_not_found';
    case SERVICE_NOT_FOUND = 'service_not_found';

    /**
     * 401 Unauthenticated
     */

    case UNAUTHENTICATED = 'unauthenticated';

    /**
     * 403 Forbidden
     */
    case TRANSACTION_FORBIDDEN = 'transaction_forbidden';
    case COMPANY_TRANSACTION_FORBIDDEN = 'company_transaction_forbidden';
    case AGENT_TRANSACTION_FORBIDDEN = 'agent_transaction_forbidden';
    case SELF_TRANSACTION_FORBIDDEN = 'self_transaction_forbidden';
    case FORBIDDEN = 'forbidden';
    case USER_DISABLED = 'user_disabled';

    /**
     * 408 Request Timeout
     */
    case TIMEOUT_SOFT_LOCK = 'timeout_soft_lock';
    case TIMEOUT_LOCK_DB = 'timeout_lock_db';
    case PLATFORM_REQUEST_TIMEOUT = 'platform_request_timeout';

    public static function enumToStatusCode($enum)
    {
        return match ($enum) {
            self::VALIDATION_FAILED->value,
            self::INVALID_DATA_ENCRYPT->value,
            self::DB_UNIQUE_CONSTRAINT_VIOLATION_EXCEPTION->value,
            self::REQUEST_IN_PROGRESS->value,
            self::CONCURRENT_LIMIT->value,
            self::WRONG_CREDENTIALS->value,
            self::OUTBOX_DIFF_STATUS->value,
            self::OUTBOX_ALREADY_PROCESSED->value,
            self::INVALID_OLD_PASSWORD->value => 400,

            self::USER_NOT_FOUND->value,
            self::PARENT_NOT_FOUND->value,
            self::SERVICE_NOT_FOUND->value => 404,
    
            self::UNAUTHENTICATED->value => 401,

            self::FORBIDDEN->value => 403,

            self::TIMEOUT_SOFT_LOCK->value,
            self::TIMEOUT_LOCK_DB->value,
            self::PLATFORM_REQUEST_TIMEOUT->value => 408,

            default => 400
        };
    }

    /**
     * Use for ResultJob, CancelJob, ChangeResultJob only
     */
    public static function batchRetryCode()
    {
        return [
            self::REQUEST_IN_PROGRESS->value
        ];
    }
}
