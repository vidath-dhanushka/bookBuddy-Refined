<?php

class _404 extends Controller
{
    public function index()
    {
        $data['title'] = '404';
        $this->view('_404', $data);
    }
}
