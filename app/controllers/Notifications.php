<?php

class Notifications extends Controller
{
    public function index()
    {


        $data = [];
        $notification = new Notification();
        $id = Auth::getuser_Id();
        if (isset($_POST['key']) && ($_POST['key'] == '123')) {

            $notifications = $notification->show_notifications($id);

            $n_number = $notification->active_notifications($id);

            $data['total'] = $n_number;
            $data['notifications'] = $notifications;


            echo json_encode(value: $data);
        }

        if (isset($_POST['key']) && ($_POST['key'] == '1234')) {
            $data[] = $notification->inactive_notifications();
        }

        if (!isset($_POST['key']) && empty($_POST['key'])) {
            echo 'API error';
        }
    }

    public function seenNotification()
    {
        // Get the user ID from the session or Auth
        $id = Auth::getuser_Id();

        // If the user is authenticated, proceed
        if ($id) {
            $notification = new Notification();

            // Call the model method to mark notifications as seen
            $notification->notificationSeen($id); // Pass the user ID to the model method
        } else {
            // Handle case where user is not authenticated (if needed)
            echo json_encode(['status' => 'error', 'message' => 'User not authenticated']);
        }
    }
}
