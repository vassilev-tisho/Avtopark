<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    protected $table      = 'order_status';
    protected $primaryKey = 'id';
    const ORDER_STATUS_NEW = 'New';
    const ORDER_STATUS_PROCESSING = 'Processing';
    const ORDER_STATUS_SENT = 'Sent';
    const ORDER_STATUS_CLOSED = 'Closed';
    public function orders()
    {
        return $this->hasMany('App\Orders', 'order_status_id', 'id');
    }

}
