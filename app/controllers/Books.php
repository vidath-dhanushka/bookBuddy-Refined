<?php

class Books extends Controller
{

    public function index()
    {

        $this->view('books');
    }

    public function details($id)
    {
        $data = [];
        $data['id'] = $id;

        $this->view('bookDetails', $data);
    }
}
