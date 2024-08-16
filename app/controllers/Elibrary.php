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
        $review = new Ebook_review();
        if (empty($id)) {
            redirect('elibrary/search');
        }
        $data['favourite'] = 0;


        if (Auth::logged_in()) {
            $user_id = Auth::getuser_Id();
            $data['favourite'] = $favourite->isFavourite($user_id, $id);
            $data['reviews']['user_review'] = $review->get_user_review(["ebook_id" => $id, "user_id" => $user_id]);
            $data['username'] =  Auth::getUsername();
        }
        $data['reviews']['all'] = $review->get_review(["ebook_id" => $id]);
        $data['reviews']['average_rating'] = number_format($review->get_average_rating(["ebook_id" => $id]), 1);
        $data['reviews']['count'] = $review->get_review_count(["ebook_id" => $id]);
        $data['reviews']['rating_count'] = $review->get_rating_counts(["ebook_id" => $id]);
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

    public function remove_favourite($id = null)
    {
        $elibrary = new Ebook();
        $favourite = new Favourite();
        if (Auth::logged_in()) {
            $user_id = Auth::getuser_Id();
            $data['favourite'] = $favourite->removeFavourite($user_id, $id);
            redirect('elibrary/favourite_list');
        } else {
            redirect('login');
        }
    }

    public function review($id = null, $action = null)
    {
        $elibrary = new Ebook();
        $review = new Ebook_review();
        if (Auth::logged_in()) {

            $user_id = Auth::getuser_Id();
            if ($action === "delete") {
                $review->deleteUserReview(["ebook_id" => $id, "user_id" => $user_id]);
            } elseif ($action === "add") {
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $_POST["ebook_id"] = $id;
                    $_POST["user_id"] = $user_id;

                    $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
                    $rating = filter_var($_POST['rating'], FILTER_SANITIZE_STRING);

                    if ($review->verify_review(["ebook_id" => $_POST["ebook_id"], "user_id" => $user_id])) {
                        if (isset($_POST["submit"])) {
                            unset($_POST["submit"]);
                        }
                        $review->addReview($_POST);
                        // $isBorrowed = $elibrary->hasUserEverBorrowed(["user_id" => $_POST["user_id"], "ebook_id" => $id]);

                        // if ($isBorrowed) {
                        //     $member->addReview($_POST);
                        //     $_SESSION['message_class'] = 'alert-success';
                        //     message("Review added.");
                        // } else {
                        //     $_SESSION['message_class'] = 'alert';
                        //     message("You must have borrowed the ebook at least once before you can add a review.");
                        // }

                        redirect('elibrary/ebook/' . $id);
                    }
                }
            }
            redirect('elibrary/ebook/' . $id);
        } else {
            redirect('login');
        }
    }

    public function favourite_list()
    {
        $elibrary = new Ebook();
        $favourite = new Favourite();
        $data = [];
        if (Auth::logged_in()) {
            $user_id = Auth::getuser_Id();
            $data['favourite_list'] = $favourite->get_favourite_list($user_id);
            $this->view('elibrary/favourite', $data);
        } else {
            redirect('login');
        }
    }
}
