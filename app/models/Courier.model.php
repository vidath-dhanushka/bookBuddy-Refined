<?php

class Courier extends Model
{
    protected $table = 'courier';

    public function getAllCourier()
    {
        return $this->query("SELECT * FROM courier");
    }
}
