<?php

namespace App\Enums;

use App\Enums\Traits\EnumTrait;

enum OnQueueEnum: string
{
    use EnumTrait;

    // php artisan queue:restart && php artisan queue:work --queue=high,default,low,trx_high,trx_default,trx_low,wh_high,wh_default,wh_low,pp_high,pp_default,pp_low

    // TRANSACTIONS
    case TRANSACTION_HIGH = 'trx_high';
    case TRANSACTION_DEFAULT = 'trx_default';
    case TRANSACTION_LOW = 'trx_low';


    // Outbox
    case OUTBOX_HIGH = 'o_high';
    case OUTBOX_DEFAULT = 'o_default';
    case OUTBOX_LOW = 'o_low';

    // WEBHOOKS
    case WEBHOOK_HIGH = 'wh_high';
    case WEBHOOK_DEFAULT = 'wh_default';
    case WEBHOOK_LOW = 'wh_low';

    case PARTNER_HIGH = 'pp_high';
    case PARTNER_DEFAULT = 'pp_default';
    case PARTNER_LOW = 'pp_low';

    case NEW_HIGH = 'n_high';
    case NEW_HIGH_2 = 'n_high_2';
    case NEW_DEFAULT = 'n_default';
    case NEW_LOW = 'n_low';
}
