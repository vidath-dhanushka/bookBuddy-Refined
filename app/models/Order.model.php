<?php

class Order extends Model
{
    protected $table = "`order`";
    protected $allowedColumns = [
        'user',
        'amount',
        'weight',
        'charge',
        'courier'
    ];
}
