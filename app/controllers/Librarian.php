<?php

class Librarian extends Controller
{

    public function index()
    {
        $user = new User();
        $data = [];
        $id = Auth::getuser_Id();
        // echo ($id);

        $data['user_data'] = $user->first(['user_id' => $id]);
        // show($data);
        // // show($_SESSION['USER_DATA']);
        // die;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // show($data);

            // show($_POST);
            // die;
            if ($user->edit_validate($_POST, $id)) {
                $user->update($id, $_POST);
                $_SESSION['USER_DATA'] =  $data['user_data'] = $user->first(['user_id' => $id]);
                // show($row);
            }
            // die;
        }
        $data['errors'] = $user->errors;
        // show($data);
        // die;
        $this->view('librarian/profile', $data);
    }


    public function changePassword()
    {
        if (Auth::logged_in()) {
            $user = new User();
            $id = Auth::getuser_Id();
            $currentUserData = $_SESSION['USER_DATA'];
            // show($currentUserData);
            // die;
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // show($_POST);
                // die;
                if (password_verify($_POST['password'], $currentUserData->password)) {
                    if ($_POST['new_password'] == $_POST['confirm_password']) {
                        $password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
                        $user->update($id, ['password' => $password]);
                        message("Password changed successfully");
                        redirect('librarian/profile');
                    } else {
                        error("new password and confirm Password is not matching");
                    }
                } else {
                    error("entered current Password is incorrect");
                }
            }
        }
        $this->view('librarian/changePassword');
    }

    public function ebooks($action = null, $ebook_id = null)
    {
        $user = new User();
        $data = [];
        $ebook = new Ebook();
        $id = Auth::getuser_Id();
        if ($action === "delete") {
            $ebook->delete($ebook_id);
            message("book deleted successfully");
            $_SESSION['message_class'] = 'alert-success';
            redirect('librarian/ebooks');
        }

        $data['user_data'] = $user->first(['user_id' => $id]);
        $data['ebooks'] = $ebook->getAllEBooks();
        $this->view('librarian/ebooks', $data);
    }



    public function addEbook()
    {
        if (Auth::logged_in()) {
            $id = Auth::getuser_Id();
            $category = new Category();
            $elibrary = new Ebook();

            $data['categories'] = $elibrary->getCategories();
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                $_POST['librarian_id'] = $id;
                $folderCover = "uploads/ebooks/cover/";
                if (!file_exists($folderCover)) {
                    mkdir($folderCover, 0777, true);
                    file_put_contents($folderCover . "index.php", "<?php //silence");
                    file_put_contents("uploads/index.php", "<?php //silence");
                }
                $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];

                if ($_FILES['book_cover']['name']) {
                    if ($_FILES['book_cover']['error'] == 0) {
                        if (in_array($_FILES['book_cover']['type'], $allowedTypes)) {
                            $destination = $folderCover . time() . $_FILES['book_cover']['name'];
                            move_uploaded_file($_FILES['book_cover']['tmp_name'], $destination);
                            $_POST['book_cover'] = $destination;
                            $_SESSION['temp_cover_path'] = $destination;
                        } else {
                            $elibrary->errors['book_cover'] = "Invalid file type";
                        }
                    } else {
                        $elibrary->errors['book_cover'] = "Could not upload the images";
                    }
                }
                $folder = "uploads/ebooks/file/";
                $allowed = [
                    'application/pdf',
                ];
                if (!file_exists($folder)) {
                    mkdir($folder, 0777, true);
                    file_put_contents($folder . "index.php", "<h2>Access denied!</h2>");
                    file_put_contents("uploads/index.php", "<h2>Access denied!</h2>");
                }


                if (!empty($_FILES['file']['name'])) {
                    if ($_FILES['file']['error'] == 0) {
                        $fileSize = $_FILES['file']['size'];
                        $maxSize = 5 * 1024 * 1024;
                        if ($fileSize > $maxSize) {
                            $elibrary->errors['file'] = "File is too large. Maximum file size is 5 MB.";
                        } else
                        if (in_array($_FILES['file']['type'], $allowed)) {
                            $destination = $folder . time() . $_FILES['file']['name'];
                            move_uploaded_file($_FILES['file']['tmp_name'], $destination);
                            $_SESSION['temp_file_path'] = $destination;
                            $_POST['file'] = $destination;
                        } else {
                            $elibrary->errors['file'] = "This file type is not allowed";
                        }
                    } else {
                        $elibrary->errors['file'] = "Could not upload file";
                    }
                }

                if (empty($_POST)) {
                    $_POST["isbn"] = null;
                }

                if ($elibrary->validate($_POST)) {

                    if (empty($elibrary->errors)) {
                        if ($_POST['license_type'] == "Public Domain") {
                            $_POST['copyright_status'] = 1;
                            $ebook_id = $elibrary->insert($_POST);
                        } else {
                            $_POST['copyright_status'] = 0;
                            $ebook_id =  $elibrary->insert($_POST);
                        }

                        $categories = $_POST['category'];

                        if ($categories) {

                            foreach ($categories as $cat) {
                                $book_categ_details = [];
                                $book_categ_details['ebook_id'] = $ebook_id;
                                $book_categ_details['category_id'] = $cat;

                                $category->insertEBookCategory($book_categ_details);
                            }

                            unset($_POST["category"]);
                        }
                        unset($_SESSION['temp_file_path']);
                        unset($_SESSION['temp_cover_path']);
                        message("book added successfully");
                        $_SESSION['message_class'] = 'alert-success';
                        redirect('librarian/ebooks');
                    }
                }
            }

            $data['errors'] = $elibrary->errors;
            $this->view("librarian/addEbook", $data);
        } else {
            $this->view('_404');
        }
    }

    public function updateEbook($ebook_id)
    {
        if (Auth::logged_in()) {
            $id = Auth::getuser_Id();
            $category = new Category();
            $elibrary = new Ebook();


            $data['ebook'] = $elibrary->getEbookDetailsForEdit($ebook_id);
            $data['categories'] = $elibrary->getCategories(); // Current categories for selection

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $_POST['librarian_id'] = $id;

                // Handle book cover
                $folderCover = "uploads/ebooks/cover/";
                if (!file_exists($folderCover)) {
                    mkdir($folderCover, 0777, true);
                    file_put_contents($folderCover . "index.php", "<?php //silence");
                    file_put_contents("uploads/index.php", "<?php //silence");
                }
                $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];

                if ($_FILES['book_cover']['name']) {
                    if ($_FILES['book_cover']['error'] == 0) {
                        if (in_array($_FILES['book_cover']['type'], $allowedTypes)) {
                            $destination = $folderCover . time() . $_FILES['book_cover']['name'];
                            move_uploaded_file($_FILES['book_cover']['tmp_name'], $destination);
                            $_POST['book_cover'] = $destination;
                            // Optionally delete the old cover file if needed
                            if (file_exists($data['ebook']['book_cover'])) {
                                unlink($data['ebook']['book_cover']);
                            }
                        } else {
                            $elibrary->errors['book_cover'] = "Invalid file type";
                        }
                    } else {
                        $elibrary->errors['book_cover'] = "Could not upload the images";
                    }
                } else {
                    // If no new cover is uploaded, use the current cover
                    $_POST['book_cover'] = $data['ebook']['book_cover'];
                }

                // Handle ebook file
                $folder = "uploads/ebooks/file/";
                $allowed = ['application/pdf'];
                if (!file_exists($folder)) {
                    mkdir($folder, 0777, true);
                    file_put_contents($folder . "index.php", "<h2>Access denied!</h2>");
                    file_put_contents("uploads/index.php", "<h2>Access denied!</h2>");
                }

                if (!empty($_FILES['file']['name'])) {
                    if ($_FILES['file']['error'] == 0) {
                        $fileSize = $_FILES['file']['size'];
                        $maxSize = 5 * 1024 * 1024;
                        if ($fileSize > $maxSize) {
                            $elibrary->errors['file'] = "File is too large. Maximum file size is 5 MB.";
                        } else if (in_array($_FILES['file']['type'], $allowed)) {
                            $destination = $folder . time() . $_FILES['file']['name'];
                            move_uploaded_file($_FILES['file']['tmp_name'], $destination);
                            $_POST['file'] = $destination;
                            // Optionally delete the old file if needed
                            if (file_exists($data['ebook']['file'])) {
                                unlink($data['ebook']['file']);
                            }
                        } else {
                            $elibrary->errors['file'] = "This file type is not allowed";
                        }
                    } else {
                        $elibrary->errors['file'] = "Could not upload file";
                    }
                } else {
                    // If no new file is uploaded, use the current file
                    $_POST['file'] = $data['ebook']['file'];
                }

                if ($elibrary->validate($_POST)) {
                    if (empty($elibrary->errors)) {
                        // Update ebook details
                        $elibrary->update($ebook_id, $_POST);

                        // Handle categories update
                        $categories = $_POST['category'];
                        if ($categories) {
                            // Remove old categories first
                            $category->deleteEBookCategories($ebook_id);

                            // Add new categories
                            foreach ($categories as $cat) {
                                $book_categ_details = [];
                                $book_categ_details['ebook_id'] = $ebook_id;
                                $book_categ_details['category_id'] = $cat;

                                $category->insertEBookCategory($book_categ_details);
                            }
                        }

                        // Clear temporary session paths
                        unset($_SESSION['temp_file_path']);
                        unset($_SESSION['temp_cover_path']);

                        message("Ebook updated successfully");
                        $_SESSION['message_class'] = 'alert-success';
                        redirect('librarian/ebooks');
                    }
                }
            }

            $data['errors'] = $elibrary->errors;
            $this->view("librarian/updateEbook", $data);
        } else {
            $this->view('_404');
        }
    }


    public function borrow_ebook($id = null)
    {

        $ebook = new Ebook;
        // $member = new Member_model();
        $member = new Member();
        $subscription = new Subscription();
        $member_subscription = new Member_subscription();
        $copyright = new Copyright();

        if (Auth::logged_in()) {

            $data['row'] = $row = $member_subscription->view_member_details(['id' => $_SESSION['USER_DATA']->id]);
            if ($row->role !== 'member') {
                message("To access all the features and benefits, please sign in as a member.");
                redirect('elibrary/view_ebook/' . $id);
            }
            $data['ebook']  = $ebook->getEbookDetails(['b.id' => $id]);
            $data['copyright'] = $copyright->getCopyright(["ebook_id" => $id]);
            $data['book_subscription'] = $sub = $subscription->get_subscription_by_id(["id" => $data['copyright']->subscription]);
            $data['user_subscription'] = $user_sub = $member_subscription->getSubscription(["id" => $data['row']->id]);
            if ($user_sub->price < $sub->price) {
                // add to cart
                redirect('elibrary/view_ebook/' . $id);
            } else {
                // show($row);
                // die;
                $borrowed_ebook = new Borrowed_ebook();
                $licensed_copies = $data['copyright']->licensed_copies;
                $borrowing_count = ($borrowed_ebook->countBorrowedCopies(["ebook_id" => $id]))->borrowed_copies;
                $user_borrowing = ($borrowed_ebook->countUserBorrowedBooks(["user_id" => $row->id]))->user_borrowed_books;

                $isborrowed = $borrowed_ebook->hasUserBorrowed(["user_id" => $row->userID, "ebook_id" => $id]);
                // show( $user_borrowing);
                // die;
                if ($licensed_copies > $borrowing_count && $user_sub->numberOfBooks >= $user_borrowing) {
                    if (!$isborrowed) {
                        // show($row);
                        $borrowed_ebook->insert(["user_id" => $row->userID, "ebook_id" => $id]);
                    }
                    $borrowing = $borrowed_ebook->borrowedEbookDetails(["user_id" => $row->userID, "ebook_id" => $id]);
                    $date = new DateTime($borrowing->borrow_date);
                    $numDays = $data['ebook']->borrowing_time;
                    $interval =  new DateInterval('P' . $numDays . 'D');
                    $due_date = $date->add($interval);
                    $due_date = $date->format('l, F j, Y g:i A');
                    $data['due_date'] = $due_date;

                    $this->view('elibrary/ebook_reader', $data);
                } else {
                    message("Book currently unavailable.");
                    redirect('elibrary/view_ebook/' . $id);
                }
            }
        }
    }

    public function subscriptionHome()
    {
        $data = [];
        $subscription = new Subscription();
        $member_subscription = new Member_subscription();
        $data['subscriptions'] = $subscription->get_all_subscriptions();
        if (Auth::logged_in()) {
            $user_id = Auth::getuser_Id();
            $data['member_subscription'] = $member_subscription->getSubscription($user_id);
        }

        $this->view('elibrary/subscription', $data);
    }

    public function subscription($action = null)
    {
        $data = [];
        $subscription = new Subscription();
        $data['subscriptions'] = $subscription->get_all_subscriptions();
        if (Auth::logged_in()) {
            if ($action === 'add') {

                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    if ($subscription->validate($_POST)) {
                        $subscription->insert($_POST);
                        $_SESSION['message_class'] = 'alert-success';
                        message("Subscription inserted successfully!");
                        redirect('librarian/subscription');
                    } else {
                        $data['errors'] = $subscription->errors;
                        $data['subscription'] = json_decode(json_encode($_POST));
                        $this->view('librarian/addSubscription', $data);
                    }
                } else {
                    $this->view('librarian/addSubscription', $data);
                }
            } else {
                $this->view('librarian/subscription', $data);
            }
        } else {
            $this->view('_404');
        }
    }

    public function editSubscription($id = null, $action = null)
    {
        $data = [];
        $subscription = new Subscription();
        if (Auth::logged_in()) {
            $data['subscriptions'] = $subscription->get_all_subscriptions();
            $data['subscription'] = $tmp = $subscription->get_subscription_by_id($id);

            if ($action === 'edit') {
                if (empty($id)) {
                    $this->view("librarians/subscription");
                } else {

                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        if ($subscription->validateUpdate($id, $_POST)) {
                            $subscription->update($id, $_POST);
                            $_SESSION['message_class'] = 'alert-success';
                            message("Subscription updated successfully!");
                            redirect('librarian/subscription');
                        } else {
                            $tmp->name = $_POST['name'];
                            $tmp->price = $_POST['price'];
                            $tmp->max_books = $_POST['max_books'];
                            $tmp->borrowing_period = $_POST['borrowing_period'];
                            $data['errors'] = $subscription->errors;

                            $this->view('librarian/editSubscription', $data);
                        }
                    } else {
                        $this->view('librarian/editSubscription', $data);
                    }
                }
            } elseif ($action === 'delete') {
                $subscription->delete_subscription_by_id($id);
                $_SESSION['message_class'] = 'alert-success';
                message('Subscription deleted successfully !');
                redirect('librarian/subscription');
            }
        } else {
            $this->view('_404');
        }
    }


    public function copyright($action = null, $id = null)
    {
        $data = [];
        $copyright = new Copyright();
        $subscription = new Subscription();
        $data['subscriptions'] = $subscription->get_all_subscriptions();

        $data['copyrights'] = $copyright->get_all_copyrights();
        if (!empty($id)) {
            $data['copyright'] = $tmp = $copyright->get_copyright_by_id($id);
        }
        if (Auth::logged_in()) {
            if ($action === 'add') {

                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    if ($copyright->validate($_POST)) {
                        $copyright->insert($_POST);
                        message("Subscription inserted successfully!");
                        redirect('librarian/subscription');
                    } else {
                        $data['errors'] = $copyright->errors;
                        $this->view('librarian/addSubscription', $data);
                    }
                } else {
                    $this->view('librarian/addSubscription', $data);
                }
            } elseif ($action === 'delete') {
                $copyright->delete_copyright_by_id($id);
                message("The copyright record has been successfully deleted.");
                redirect('librarian/copyright');
            } elseif ($action === 'edit') {

                if (empty($id)) {
                    redirect("librarians/copyright");
                } else {

                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        if ($copyright->validate($_POST)) {
                            $copyright->update($id, $_POST);
                            message("Subscription updated successfully!");
                            redirect('librarian/copyright/edit/' . $id);
                        } else {
                            $data['copyright'] = $tmp = $copyright->get_copyright_by_id($id);
                            $tmp->license_type = $_POST['license_type'];
                            $tmp->licensed_copies = $_POST['licensed_copies'];
                            $tmp->max_bookscopyright_fee = $_POST['copyright_fee'];
                            $tmp->license_start_date = $_POST['license_start_date'];
                            $tmp->license_end_date = $_POST['license_end_date'];

                            $data['errors'] = $copyright->errors;
                            $this->view('librarian/editCopyright', $data);
                        }
                    } else {

                        $this->view('librarian/editCopyright', $data);
                    }
                }
            } else {
                $this->view('librarian/copyrights', $data);
            }
        } else {
            $this->view('_404');
        }
    }
}
