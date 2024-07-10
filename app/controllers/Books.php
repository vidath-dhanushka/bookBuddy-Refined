<?php

class Books extends Controller
{

    public function index()
    {
        $data = [];
        $books = new Book();
        $data['bookList'] = $books->getAllBooks();

        $this->view('books', $data);
    }

    public function details($id)
    {
        $data = [];
        $data['id'] = $id;

        $this->view('bookDetails', $data);
    }
}
