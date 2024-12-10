<?php

class Notification extends Model
{
    protected $table = "notification";
    public $errors = [];

    protected $allowedColumns = [
        "notification_id",
        "user_id",
        "message",
        "date",
        "seen"

    ];

    public function active_notifications($user_id)
    {

        $query = "SELECT * FROM $this->table WHERE seen=0 AND user_id=:user_id order by notification_id desc";
        $res =  $this->query($query,  ['user_id' => $user_id]);

        if ($res) {
            $n_numbers = count($res);
            return $n_numbers;
        } else {
            return 0;
        }
    }

    public static function show_notifications($userId)
    {
        $table = "notification"; // Define the table name
        $db = new self(); // Create an instance of the class
        $query = "SELECT * FROM $table WHERE user_id = :user_id ORDER BY notification_id DESC LIMIT 10";

        $res = $db->query($query, ['user_id' => $userId]); // Use the instance to call the non-static method
        return $res;
    }

    public static function inactive_notifications()
    {
        $table = "notification"; // Define the table name
        $db = new self(); // Create an instance of the class

        $query = "UPDATE $table SET status='inactive' WHERE status='active'";
        $res =  $db->query($query); // Use the instance to call the non-static method

    }

    public static function notificationSeen($userId)
    {
        $table = "notification"; // Define the table name
        $db = new self(); // Create an instance of the class

        $query = "UPDATE $table SET seen = 1 WHERE user_id = :user_id AND seen = 0";
        $res = $db->query($query, ['user_id' => $userId]);
        return $res; // Use the instance to call the non-static method

    }

    public function addNotification($userId, $message)
    {
        $query = "INSERT INTO notification (user_id, message, date, seen) 
                  VALUES (:user_id, :message, NOW(), 0)";

        return $this->query($query, [
            'user_id' => $userId,
            'message' => $message,
        ]);
    }
}
