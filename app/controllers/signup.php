<?php

class Signup extends Controller
{

    public function index()
    {

        $data['errors'] = [];

        $user = new User();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // show($_POST);
            // die;
            if (($user->validate($_POST))) {
                // echo "Hello";
                $_POST['role'] = 'member';
                $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);

                $user->insert($_POST);

                message("your account created successfully");
                redirect('login');
            } else {
                echo "failed";
            }
        }


        $data['errors'] = $user->errors;

        $data['title'] = 'Signup';
        $this->view('signup', $data);
    }
}
