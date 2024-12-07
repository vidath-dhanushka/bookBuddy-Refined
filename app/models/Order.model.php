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

    public function getOngoingOrders($id)
    {
        return $this->query("SELECT o.*, u.first_name, u.last_name, u.phone, u.address_line1, u.address_line2, u.address_city, u.address_district FROM `order` o LEFT JOIN user u ON o.user = u.user_id WHERE o.courier=:courier AND o.status = 'pending';", ["courier" => $id]);
    }

    public function getCompletedOrders($id)
    {
        return $this->query("SELECT * FROM `order` WHERE courier=:courier AND status = 'completed';", ["courier" => $id]);
    }

    public function updateStatus($id)
    {
        return $this->query("UPDATE `order` SET `status`='completed' WHERE order_id = :id", ['id' => $id]);
    }
}
