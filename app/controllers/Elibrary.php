<?php

class Elibrary extends Controller
{
    public function index()
    {
        $elibrary = new Ebook();
        $data['recent_ebooks'] = $elibrary->getRecentEBooks();

        if (Auth::logged_in()) {
            $user_borrowing = new Borrowed_ebook();
            $member_sub = new Member_subscription();
            $notification = new Notification();
            $id = Auth::getuser_Id();
            $borrowing = $user_borrowing->userCurrentBorrowing(["user_id" => $id]);

            if (!empty($borrowing)) {

                foreach ($borrowing as  $borrow) {
                    // Get subscription details

                    $sub = $member_sub->getSubscription($id);

                    if ($sub) {

                        $borrowDate = new DateTime($borrow->borrow_date);
                        $numDays = $sub->borrowing_period;
                        $interval = new DateInterval('P' . $numDays . 'D');
                        $dueDate = $borrowDate->add($interval);


                        $currentDate = new DateTime();
                        if ($currentDate > $dueDate) {
                            $notification->addNotification($id, "The book '$borrow->title' has been auto-returned today. Thank you!");
                            $user_borrowing->returnBorrowedEbook(["id" => $borrow->id]);
                        }
                    }
                }
            }
        }

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



    public function subscription()
    {
        $data = [];
        $subscription = new Subscription();
        $member_subscription = new Member_subscription();
        $data['subscriptions'] = $subscription->get_all_subscriptions();
        if (Auth::logged_in()) {
            $user_id = Auth::getuser_Id();
            $data['member_subscription'] = $sub = $member_subscription->getSubscription($user_id);
        }

        $this->view('member/subscription', $data);
    }

    public function borrowing()
    {
        $data = [];
        $borrowing = new Borrowed_ebook;
        $member_subscription = new Member_subscription();

        if (Auth::logged_in()) {
            $user_id = Auth::getuser_Id();
            $data['borrowed_ebooks'] = $borrowing->userBorrowing(["user_id" => $user_id]);
            $data['user_subscription'] = $member_subscription->getSubscription($user_id);
        }

        $this->view('member/ebookBorrowing', $data);
    }

    public function ebook($id = null)
    {
        $elibrary = new Ebook();
        $favourite = new Favourite();
        $subscription = new Subscription();
        $review = new Ebook_review();
        $copyright = new Copyright();
        $member_borrowing = new Borrowed_ebook();
        $member_subscription = new Member_subscription();

        if (empty($id)) {
            redirect('elibrary/search');
        }
        $data['favourite'] = 0;

        $data['ebook'] = $elibrary->getEbookDetails($id);

        if (Auth::logged_in()) {
            $user_id = Auth::getuser_Id();
            $data['favourite'] = $favourite->isFavourite($user_id, $id);
            $data['reviews']['user_review'] = $review->get_user_review(["ebook_id" => $id, "user_id" => $user_id]);
            $data['username'] =  Auth::getUsername();
            $data['user_subscription']  = $member_subscription->getSubscription($user_id);
            $data['copyright'] = $copyright->getCopyright(["ebook_id" => $id]);

            $data['isborrowed'] = $member_borrowing->hasUserBorrowed(["ebook_id" => $id, "user_id" => $user_id]);
            $data['isEverborrowed'] = $member_borrowing->hasUserEverBorrowed(["ebook_id" => $id, "user_id" => $user_id]);
            if (empty($data['copyright'])) {
                $data['book_subscription'][0] =  $subscription->get_subscription_by_id(1);
            } else {
                $data['book_subscription'] =   $copyright->getSubscriptionsByEbookId(["ebook_id" => $id]);
            }
        }
        $data['reviews']['all'] = $review->get_review(["ebook_id" => $id]);
        $data['reviews']['average_rating'] = number_format($review->get_average_rating(["ebook_id" => $id]), 1);
        $data['reviews']['count'] = $review->get_review_count(["ebook_id" => $id]);
        $data['reviews']['rating_count'] = $review->get_rating_counts(["ebook_id" => $id]);



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
        $borrowed_ebook = new Borrowed_ebook;
        if (Auth::logged_in()) {

            $user_id = Auth::getuser_Id();
            if ($action === "delete") {
                $review->deleteUserReview(["ebook_id" => $id, "user_id" => $user_id]);
            } elseif ($action === "add") {
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $_POST["ebook_id"] = $id;
                    $_POST["user_id"] = $user_id;

                    if ($review->verify_review($_POST)) {
                        if (isset($_POST["submit"])) {
                            unset($_POST["submit"]);
                        }

                        $isBorrowed = $borrowed_ebook->hasUserEverBorrowed(["user_id" => $_POST["user_id"], "ebook_id" => $id]);

                        if ($isBorrowed) {
                            $review->addReview($_POST);
                            $_SESSION['message_class'] = 'alert-success';
                            message("Review added.");
                        } else {
                            $_SESSION['message_class'] = 'alert';
                            message("You must have borrowed the ebook at least once before you can add a review.");
                        }

                        redirect('elibrary/ebook/' . $id);
                    }
                    if (!empty($review->errors)) {
                        $_SESSION['review_errors'] = $review->errors;
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

    public function borrow_ebook($id = null)
    {


        $elibrary = new Ebook;
        $subscription = new Subscription();
        $member_subscription = new Member_subscription();
        $copyright = new Copyright();
        $borrowed_ebook = new Borrowed_ebook();

        if (Auth::logged_in()) {
            $row = $_SESSION['USER_DATA'];

            if ($row->role !== 'member') {
                message("To access all the features and benefits, please sign in as a member.");
                redirect('login');
            }

            $data['user_subscription'] = $user_sub = $member_subscription->getSubscription($row->user_id);
            $user_borrowing = ($borrowed_ebook->countUserBorrowedBooks(["user_id" => $row->user_id]))->user_borrowed_books;
            $borrowing_book_count = ($borrowed_ebook->countBorrowedCopies(["ebook_id" => $id]))->borrowed_copies;
            $data['copyright'] = $right = $copyright->getCopyright(["ebook_id" => $id]);
            $data['subscriptions'] = $sub = $copyright->getSubscriptionsByEbookId(['ebook_id' => $id]);
            $data['ebook']  = $elibrary->getEbookDetails($id);
            $isborrowed = $borrowed_ebook->hasUserBorrowed(["user_id" => $row->user_id, "ebook_id" => $id]);
            if ($sub) {
                $notExists = empty(array_filter($sub, function ($subscription) use ($user_sub) {
                    return $subscription->subscription_id == $user_sub->subscription_id;
                }));
            }
            if (!$isborrowed) {

                if ($user_borrowing >= $user_sub->max_books) {
                    message("You have exceeded your borrowing limit, please upgrade your account.");
                    redirect('elibrary/ebook/' . $id);
                } else if ($notExists) {
                    message("This eBook is not available for your current subscription plan.");
                    redirect('elibrary/ebook/' . $id);
                } else if (!empty($right) && ($right->licensed_copies >= $borrowing_book_count)) {
                    message("All available copies of this eBook are currently borrowed. Please try again later.");
                    redirect('elibrary/ebook/' . $id);
                } else {
                    $borrowed_ebook->insert(["user_id" => $row->user_id, "ebook_id" => $id]);
                }
            } else {

                $borrowing = $borrowed_ebook->borrowedEbookDetails(["user_id" => $row->user_id, "ebook_id" => $id]);
                $date = new DateTime($borrowing->borrow_date);

                $numDays = $data['user_subscription']->borrowing_period;
                $interval =  new DateInterval('P' . $numDays . 'D');
                $due_date = $date->add($interval);
                $due_date = $date->format('l, F j, Y');

                $data['due_date'] = $due_date;
                $this->view('elibrary/ebook_reader', $data);
            }
        }
    }


    public function return_book($id = null)
    {
        $borrowed_ebook = new Borrowed_ebook;
        $member_subscription = new Member_subscription;
        $row = $_SESSION['USER_DATA'];
        $data['user_subscription'] = $user_sub = $member_subscription->getSubscription($row->user_id);
        $data['isborrowed'] = $borrowed_ebook->hasUserBorrowed(["user_id" => $row->user_id, "ebook_id" => $id]);
        if (isset($data['isborrowed']) && $data['isborrowed']) {
            $borrowing = $borrowed_ebook->borrowedEbookDetails(["user_id" => $row->user_id, "ebook_id" => $id]);
            $borrowed_ebook->returnBorrowedEbook(['id' => $borrowing->id]);
            redirect('elibrary/ebook/' . $id);
        }
    }

    public function get_favorite_count_endpoint()
    {
        $favourite = new Favourite();
        $userId = $_SESSION['USER_DATA']->user_id;
        $favoriteCount = $favourite->get_favourite_count($userId);

        header('Content-Type: application/json');

        echo json_encode(['favorite_count' => $favoriteCount]);
    }


    public function my_message($id)
    {
        message("You must have borrowed the ebook at least once before you can add a review.");
        redirect('elibrary/ebook/' . $id);
    }

    public function ebook_url($id = null)
    {
        $ebook = new Ebook;
        $pdfUrl = $ebook->get_file(["book_id" => $id])->file;
        $pdfUrl = ROOT . '/' . $pdfUrl;


        // Output the PDF URL as JavaScript code
        echo "var pdfUrl = '$pdfUrl';";
    }
}
