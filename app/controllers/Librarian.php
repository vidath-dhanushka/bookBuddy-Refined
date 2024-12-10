<?php

class Librarian extends Controller
{

    public function index()
    {
        $this->view("librarian/dashboard");
    }


    public function profile()
    {
        $user = new User();
        $data = [];
        $id = Auth::getuser_Id();

        $data['user_data'] = $user->first(['user_id' => $id]);
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($user->edit_validate_librarian($_POST)) {
                $user->update($id, $_POST);
                $_SESSION['USER_DATA'] =  $data['user_data'] = $user->first(['user_id' => $id]);
                $_SESSION['message_class'] = 'alert-success';
                message("Profile updated successfully");
            } else {
                message("Profile updated unsuccessfully");
                $data["user_data"]->first_name = $_POST["first_name"];
                $data["user_data"]->last_name = $_POST["last_name"];
                $data["user_data"]->phone = $_POST["phone"];
            }
        }
        $data['errors'] = $user->errors;
        $this->view('librarian/profile', $data);
    }


    public function changePassword()
    {
        if (Auth::logged_in()) {
            $user = new User();
            $data = [];
            $id = Auth::getuser_Id();

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                if ($user->librarian_password_validate($_POST)) {
                    $password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
                    $user->update($id, ['password' => $password]);
                    $_SESSION['message_class'] = 'alert-success';
                    message("Password changed successfully");
                    redirect('librarian/changePassword');
                } else {

                    message("Password updated unsuccessfully");
                    $data["user"] = new stdClass();
                    $data["user"]->password = $_POST["password"];
                    $data["user"]->new_password = $_POST["new_password"];
                    $data["user"]->confirm_password = $_POST["confirm_password"];
                }
            }
        }
        $data['errors'] = $user->errors;
        $this->view('librarian/changePassword', $data);
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

                if (empty($_POST["isbn"])) {
                    $_POST["isbn"] = null;
                }
                if (empty($_POST["edition"])) {
                    $_POST["edition"] = null;
                }

                if ($elibrary->validate($_POST)) {

                    if (empty($elibrary->errors)) {
                        $_POST['book_cover'] = $_SESSION['temp_cover_path'];
                        $_POST['file'] = $_SESSION['temp_file_path'];
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
                            $_SESSION['temp_file_path'] = $destination;
                            $_POST['file'] = $destination;
                        } else {
                            $elibrary->errors['file'] = "This file type is not allowed";
                        }
                    } else {
                        $elibrary->errors['file'] = "Could not upload file";
                    }
                }

                if (empty($_POST["isbn"])) {
                    $_POST["isbn"] = null;
                }
                if (empty($_POST["edition"])) {
                    $_POST["edition"] = null;
                }

                if ($elibrary->editValidate($_POST)) {

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
                } else {
                    foreach ($elibrary->errors as $key => $error) {
                        if (isset($_POST[$key])) {
                            $data['ebook']->$key = $_POST[$key];
                        }
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
            $data['book_subscription'] = $sub = $subscription->get_subscription_by_id($data['copyright']->subscription);
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

    public function deacivateSubscription($id = null)
    {
        $subscription = new Subscription();
        if (Auth::logged_in()) {
            $data['subscriptions'] = $subscription->get_all_subscriptions();

            $data['subscription']  = $subscription->get_subscription_by_id($id);

            $subscription->delete_subscription_by_id($id);
            $_SESSION['message_class'] = 'alert-success';
            message('Subscription deleted successfully !');
            redirect('librarian/subscription');
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
        // unset($_SESSION['agreement']);

        if (Auth::logged_in()) {
            if ($action === 'add') {
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                    $folder = "uploads/ebooks/agreement/";
                    $allowed = [
                        'application/pdf',
                    ];
                    if (!file_exists($folder)) {
                        mkdir($folder, 0777, true);
                        file_put_contents($folder . "index.php", "<h2>Access denied!</h2>");
                        file_put_contents("uploads/index.php", "<h2>Access denied!</h2>");
                    }
                    if (!empty($_FILES['agreement']['name'])) {

                        if ($_FILES['agreement']['error'] == 0) {
                            $fileSize = $_FILES['agreement']['size'];
                            $maxSize = 5 * 1024 * 1024;
                            if ($fileSize > $maxSize) {
                                $copyright->errors['agreement'] = "File is too large. Maximum file size is 5 MB.";
                            } else
                        if (in_array($_FILES['agreement']['type'], $allowed)) {
                                $originalFileName = $_FILES['agreement']['name'];

                                // Sanitize the filename to replace spaces and special characters
                                $safeFileName = preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $originalFileName); // Replace anything not alphanumeric, underscore, hyphen, or dot with an underscore
                                $safeFileName = time() . $safeFileName; // Prefix with a timestamp to ensure uniqueness

                                $destination = $folder . $safeFileName;
                                move_uploaded_file($_FILES['agreement']['tmp_name'], $destination);
                                $_SESSION['agreement'] = $destination;
                                $_POST['agreement'] = $destination;
                            } else {
                                $copyright->errors['agreement'] = "This file type is not allowed";
                            }
                        } else {

                            $copyright->errors['agreement'] = "Could not upload file";
                        }
                    }
                    if ($copyright->validate($_POST)) {
                        $_POST['agreement'] = $_SESSION['agreement'];
                        $_POST['ebook_id'] = $id;

                        $copyright->insert($_POST);
                        $copyright->updateStatus(['ebook_id' => $id, 'status' => 1]);
                        unset($_SESSION['agreement']);
                        $subscriptions = $_POST['subscriptions'];


                        if ($subscriptions) {

                            foreach ($subscriptions as $cat) {
                                $book_categ_details = [];
                                $book_categ_details['ebook_id'] = $id;
                                $book_categ_details['subscription_id'] = $cat;

                                $copyright->insertEBookCopyright($book_categ_details);
                            }

                            unset($_POST["subscriptions"]);
                        }
                        message("Copyright inserted successfully!");
                        $_SESSION['message_class'] = 'alert-success';
                        redirect('librarian/copyright');
                    } else {
                        $data['errors'] = $copyright->errors;
                        $this->view('librarian/addCopyright', $data);
                    }
                } else {
                    $this->view('librarian/addCopyright', $data);
                }
            } elseif ($action === 'delete') {
                $data['copyright'] = $tmp = $copyright->get_copyright_by_id($id);
                $copyright->delete_copyright_by_id($id);
                $copyright->deleteEbookCopyright(["ebook_id" => $tmp->ebook_id]);
                $copyright->updateStatus(['ebook_id' => $tmp->ebook_id, 'status' => 0]);
                $_SESSION['message_class'] = 'alert-success';
                message("The copyright record has been successfully deleted.");
                redirect('librarian/copyright');
            } elseif ($action === 'edit') {
                if (!empty($id)) {
                    $data['subscriptions'] = $subscription->get_all_subscriptions();
                    $data['copyright'] = $tmp = $copyright->get_copyright_by_id($id);

                    $data['subscription'] = $copyright->getSubscriptionsByEbookId(["ebook_id" => $tmp->ebook_id]);
                }

                if (empty($id)) {
                    redirect("librarians/copyright");
                } else {

                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        $allowed = [
                            'application/pdf',
                        ];
                        $folder = "uploads/ebooks/agreement/";
                        if (!empty($_FILES['agreement']['name'])) {

                            if ($_FILES['agreement']['error'] == 0) {
                                $fileSize = $_FILES['agreement']['size'];
                                $maxSize = 5 * 1024 * 1024;
                                if ($fileSize > $maxSize) {
                                    $copyright->errors['agreement'] = "File is too large. Maximum file size is 5 MB.";
                                } else
                            if (in_array($_FILES['agreement']['type'], $allowed)) {
                                    $originalFileName = $_FILES['agreement']['name'];

                                    // Sanitize the filename to replace spaces and special characters
                                    $safeFileName = preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $originalFileName); // Replace anything not alphanumeric, underscore, hyphen, or dot with an underscore
                                    $safeFileName = time() . $safeFileName; // Prefix with a timestamp to ensure uniqueness

                                    $destination = $folder . $safeFileName;
                                    move_uploaded_file($_FILES['agreement']['tmp_name'], $destination);
                                    $_SESSION['agreement'] = $destination;
                                    $_POST['agreement'] = $destination;
                                } else {
                                    $copyright->errors['agreement'] = "This file type is not allowed";
                                }
                            } else {

                                $copyright->errors['agreement'] = "Could not upload file";
                            }
                        }

                        if ($copyright->edit_validate($_POST)) {

                            $copyright->update($id, $_POST);

                            if (isset($_POST['subscription'])) {
                                $subscriptions = $_POST['subscription'];
                                $copyright->deleteEbookCopyright(["ebook_id" => $tmp->ebook_id]);
                                foreach ($subscriptions as $cat) {
                                    $book_categ_details = [];
                                    $book_categ_details['ebook_id'] = $tmp->ebook_id;
                                    $book_categ_details['subscription_id'] = $cat;

                                    $copyright->insertEBookCopyright($book_categ_details);
                                }

                                unset($_POST["subscriptions"]);
                            }

                            $_SESSION['message_class'] = 'alert-success';
                            message("Subscription updated successfully!");
                            redirect('librarian/copyright');
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

    public function my_message()
    {
        message("Copyright not required for public domain books.");
        redirect('librarian/ebooks');
    }
}
