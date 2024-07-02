<?php

class Login extends Controller{
    public function index(){

        $user = new User;
        $data['errors'] = [];

        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $row = $user->first([
                'email'=>$_POST['email']
            ]);

            if($row){

                if(password_verify($_POST['password'], $row->password) && $_POST['email']===$row->email){
                    Auth::authenticate($row);
                    
                    if(Auth::is_admin()){
                        redirect('admin');
                    }elseif(Auth::is_librarian()){
                        redirect('librarian');
                    }elseif(Auth::is_courier()){
                        redirect('courier');
                    }else{
                        redirect('home');
                    }
                }
    
            }
        
            $data['errors']['password'] = 'Wrong username or password';
        }
        $data['title'] = 'Login';
        $this->view('login', $data);
    }
}