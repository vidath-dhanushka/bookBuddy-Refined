<?php

class Admin extends Controller
{

    public function index()
    {
        $book = new Book();
        $user = new User();
        $courier = new Courier();

        $data = [];

        $book_count = $book->getTotalBooksCount();
        $member_count = $user->getTotalMemberCount();
        $librarian_count = $user->getTotalLibrarianCount();
        $courier_count = $courier->getTotalCourierCount();

        $data = [
            'book_count' => $book_count,
            'member_count' => $member_count,
            'librarian_count' => $librarian_count,
            'courier_count' => $courier_count,
            ] ;
        $this->view('admin/dashboard', $data);
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
                        redirect('admin/profile');
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
       
        $courier = new Courier();
        $courierdata = $courier->getAllCourier();
        $data = [
            'courier' => $courierdata,

        ];
        
        $this->view('admin/couriers',$data);
    }

    public function addCourier()
    {
        if (Auth::logged_in()) {
            
            $courier = new Courier();
            $user = new User();


            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // show($_POST);
                // die;
                $data = [];
                $data['first_name'] = $_POST['company_name'];
                $data['last_name'] = 'Company';
                $data['username'] = $_POST['company_name'];
                $data['email'] = $_POST['email'];
                $data['phone'] = $_POST['phone'];
                $data['address_line1'] = $_POST['address_line1'];
                $data['address_city'] = $_POST['address_city'];
                $data['address_district'] = $_POST['address_district'];
                $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $data['role'] = 'courier';

                // $_POST['estimate_days' ] = 14;


               
                    $courier_id = $courier->insert($_POST); 
                    // show($courier_id);
                    // die;
                    
                    $data['courier']= $courier_id;
                    // show($data);
                    // die;
                    $user->insert($data); 
                    $response = [
                        'success' => true
                    ];
               
                    // $response = [
                    //     'success' => false,
                    //     'error' => $e->getMessage()
                    // ];
                
                    echo json_encode($response);
                
                
                redirect('admin/couriers');
            }

            $this->view("admin/addCourier");
        } else {
            $this->view('_404');
        }
    }

    // public function deleteCourier($id)
    // {
    //     if (Auth::logged_in()) {
    //         $courier = new Courier();
    //         try {
               
    //             $courier->delete($id);
    //         } catch (Exception $e) {
    //             message("Failed to remove the courier try again" . $e);
    //             //     return json_encode($e);
    //         }
    //         redirect('admin/couriers');
    //     } else {
    //         $this->view('_404');
    //     }
    // }
   
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

// public function deleteLibrarian($id)
// {
//     if (Auth::logged_in()) {
//         $librarian = new User();
//         try {
           
//             $librarian->delete($id);
//         } catch (Exception $e) {
//             message("Failed to remove the librarian try again" . $e);
//             //     return json_encode($e);
//         }
//         redirect('admin/librarian');
//     } else {
//         $this->view('_404');
//     }
// }

public function deleteLibrarian($user_id){
    $librarian = new User();
    try {
        $librarian-> removeLibrarian($user_id);
        $response = [
            'success' => true
        ];
    } catch (Exception $e) {
        $response = [
            'success' => false
        ];
    }
    echo json_encode($response);
}

public function deleteCourier($courier_id){
    $courier = new Courier();
    try {
        $courier-> removeCourier($courier_id);
        $response = [
            'success' => true
        ];
    } catch (Exception $e) {
        $response = [
            'success' => false
        ];
    }
    echo json_encode($response);
}
   
}

