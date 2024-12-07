<?php

class Courier extends Controller
{
    public function index()
    {
        // show($_SESSION['USER_DATA']);
        // die;
        $this->view('courier/dashboard');
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
        $this->view('courier/profile', $data);
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
        $this->view('courier/changePassword');
    }

    public function completedOrders()
    {
        $this->view('courier/completedOrders');
    }

    public function ongoingOrders()
    {
        if (Auth::logged_in()) {
            // show($_SESSION['USER_DATA']);
            // die;
            $courier_id = $_SESSION['USER_DATA']->courier;
            $order = new Order();

            $data = $order->getOngoingOrders($courier_id);
            // show($data);
            // die;
            $this->view('courier/ongoingOrders', $data);
        } else {
            $this->view('_404');
        }
    }

    public function singleOrder($id)
    {
        $bookBorrow = new BookBorrow();
        $data = $bookBorrow->getOrderBooks($id);
        // show($data);
        // die;
        $this->view('courier/singleOrder', $data);
    }

    public function updateBookBorrowStatus()
    {
        $bookBorrow = new BookBorrow();
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $data['id'];
        $status = $data['status'];

        try {
            $bookBorrow->updateBookBorrowStatus($id, $status);
            $response = ['success' => true];
        } catch (Exception $e) {
            $error = $e->getMessage();
            $response = ['success' => false, 'error' => $error];
        }
        echo json_encode($response);
    }

    public function updateOrderStatus()
    {
        $order = new Order();
        $data = json_decode(file_get_contents('php://input'), true);
        // show($data);
        // die;
        $orderNo = $data['orderNo'];
        $status = $data['status'];

        try {
            $order->updateStatus($orderNo);

            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }
}
