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
                $_SESSION['USER_DATA'] = $data['user_data'] = $user->first(['user_id' => $id]);
                // show($row);
            }
            // die;
        }
        $data['errors'] = $user->errors;
        // show($data);
        // die;
        $this->view('librarian/profile', $data);
    }
}
