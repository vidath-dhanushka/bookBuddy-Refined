<?php

class Courier extends Controller
{
    public function index()
    {
        // show($_SESSION['USER_DATA']);
        // die;
        $this->view('courier/dashboard');
    }

    public function profile() {}

    public function completedOrders()
    {
        $this->view('courier/completedOrders');
    }
}
