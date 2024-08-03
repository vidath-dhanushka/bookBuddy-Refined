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

    public function search($action = null, $id = null)
    {
        $elibrary = new Ebook();

        $data['categories'] = $elibrary->getCategories();
        if ($action) {
            $data['ebookList'] = $elibrary->getCategoryEBooks($id);
        } else {
            $data['ebookList'] = $elibrary->getRecentEBooks();
        }


        $data['title'] = 'Elibrary | Search';
        $this->view('elibrary/ebook_search', $data);
    }
    // public function category($id)
    // {
    //     $data = [];
    //     $ebooks = new EBook();

    //     $data['categories'] = $ebooks->getCategories();
    //     $this->view('elibrary/ebook_search', $data);
    // }
}
