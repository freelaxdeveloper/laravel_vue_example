<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\{Transaction, Subscribers};
use Illuminate\Database\Eloquent\Model;

/**
 * Class Paykeeper
 * @package App\Models
 */
class Paykeeper extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'id', 'clientid', 'orderid', 'ps_id', 'service_name', 'client_email', 'batch_date',
        'client_phone', 'fop_receipt_key', 'bank_id', 'card_number', 'card_holder', 'card_expiry',
        'who_id', 'user_id'
    ];

    /**
     * @var array
     */
    protected $appends = ['payment_link'];

    /**
     * @return HasOne
     */
    public function order()
    {
        $class = '';
        switch ($this->service_name) {
            case 'subscription' : $class = Subscribers::class;
            break;
            case 'donate' : $class = Transaction::class;
            break;
        }
        if ($class) {
            return $this->hasOne($class, 'id', 'orderid');
        }
    }

    /**
     * @return string
     */
    public function getPaymentLinkAttribute()
    {
        return paykeeper()->link($this->id);
    }
}
