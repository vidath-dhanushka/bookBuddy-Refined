<?php

class Courier extends Model
{
    protected $table = 'courier';

    public $errors = [];

    protected $allowedColumns = [
        'courier_id',
        'company_name',
        'reg_no',
        'email',
        'phone',
        'rate_first_kg',
        'rate_extra_kg',
        'estimate_days',
        'reg_time',
        'mod_time',
    ];

    public function getAllCourier()
    {
        return $this->query("SELECT * FROM courier");
    }

    // public function getAllCourier()
    // {
    //     $query = "SELECT * FROM " . $this->table;
    //     return $this->query($query);
       
    // }

    public function getCourier($id)
    {
        return $this->query("SELECT * FROM courier WHERE courier_id = :courier_id" , ['courier_id' => $id]);
       
    }
}
