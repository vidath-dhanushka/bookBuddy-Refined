<?php

class Elibrary extends Controller
{
    public function index()
    {
        $elibrary = new Ebook(); 
        $data['recent_ebooks'] = $elibrary->getRecentEBooks();

   
        $data['title'] = 'Home';
        $this->view('elibrary/library_home', $data);
    }
}

