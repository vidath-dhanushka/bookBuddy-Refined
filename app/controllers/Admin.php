<?php

class Admin extends Controller
{

    public function index()
    {
        $this->view('admin/dashboard');
    }
    public function profile()
    {
        $user = new User();
        $data = [];
        $id = Auth::getuser_Id();

        $data['user_data'] = $user->first(['user_id' => $id]);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            if ($user->edit_validate($_POST, $id)) {
                $user->update($id, $_POST);
                $_SESSION['USER_DATA'] =  $data['user_data'] = $user->first(['user_id' => $id]);
            }
        }
        $data['errors'] = $user->errors;
        $this->view('admin/profile', $data);
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
                        redirect('member/profile');
                    } else {
                        error("new password and confirm Password is not matching");
                    }
                } else {
                    error("entered current Password is incorrect");
                }
            }
        }
        $this->view('admin/changePassword');
    }
    public function courier()
    {
        $this->view('admin/couriers');
    }
    public function addCourier()
    {
        $this->view('admin/addCourier');
    }
   
    public function librarian()
    {
        $librarian = new User();
        $librariandata = $librarian->getAllLibrarian();
        $data = [
            'librarian' => $librariandata,

        ];

        $this->view('admin/librarians',$data);
    }
    public function addLibrarian()
    {
        $data['errors'] = []; // To store errors and pass them to the view
        $user = new User(); // User model instance
    
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Debug the POST data for troubleshooting (remove in production)
            // show($_POST);
            
            // Validate user inputs
            if ($user->validate($_POST)) {
                // Set the role as 'librarian' and hash the password
                $_POST['role'] = 'librarian';
                $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
                try {
                    // Insert the new librarian into the database
                    $user->insert($_POST);
    
                    // Display a success message
                    message("Your account was created successfully.");
    
                    // Redirect to the librarian management page
                    redirect('admin/librarian');
                } catch (Exception $e) {
                    // Log and store the error for debugging
                    error_log("Insert Error: " . $e->getMessage());
                    $data['errors'][] = "There was an error adding the librarian. Please try again later.";
                }
            } else {
                // If validation fails, store errors from the validate method
                $data['errors'] = $user->errors;
            }
        }
    
        // Load the view with errors (if any)
        $this->view("admin/addLibrarian", $data);
    }
}
