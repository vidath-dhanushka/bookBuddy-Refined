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

    public function ebook($id = null)
    {
        $elibrary = new Ebook();
        $favourite = new Favourite();
        if (empty($id)) {
            redirect('elibrary/search');
        }
        $data['favourite'] = 0;
        if (Auth::logged_in()) {
            $user_id = Auth::getuser_Id();
            $data['favourite'] = $favourite->isFavourite($user_id, $id);
        }

        $data['status'] = 1;
        $data['ebook'] = $elibrary->getEbookDetails($id);


        $data['title'] = 'Ebook | Details';
        $this->view('elibrary/ebook_details', $data);
    }

    public function favourite($id = null, $action = null)
    {
        $elibrary = new Ebook();
        $favourite = new Favourite();
        if (Auth::logged_in()) {

            $user_id = Auth::getuser_Id();
            if ($action === "add") {
                $data['favourite'] = $favourite->addFavourite($user_id, $id);
            } else {
                $data['favourite'] = $favourite->removeFavourite($user_id, $id);
            }
            redirect('elibrary/ebook/' . $id);
        } else {
            redirect('login');
        }
    }
}
