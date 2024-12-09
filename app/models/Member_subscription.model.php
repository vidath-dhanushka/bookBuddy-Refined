<?php

class Member_subscription extends Model
{
    protected $table = "member_subscription";
    public $errors = [];

    protected $allowedColumns = [
        "member_id",
        "subscription_id",
        'start_date',
        "end_date"

    ];

    public function view_member_details($data)
    {


        $keys = array_keys($data);

        $query = "SELECT t1.*, t2.*, t3.cityName, t4.provinceName 
        FROM users AS t1
        LEFT JOIN members AS t2 ON t1.id = t2.userID
        LEFT JOIN cities AS t3 ON t2.city = t3.id
        LEFT JOIN provinces AS t4 ON t2.province = t4.id
        WHERE t1.id = :id
        ORDER BY t2.id DESC LIMIT 1;
        
        
        ";

        // echo "<br>".$query."<br>";
        // print_r($data);
        // echo "<br>";
        // die;
        $res = $this->query($query, $data);

        if (is_array($res)) {
            // print_r($res[0]);
            return $res[0];
        }

        return false;
    }

    public function getSubscription($data)
    {
        $query = "SELECT {$this->table}.*, subscription.*
                  FROM {$this->table} 
                  INNER JOIN subscription ON {$this->table}.subscription_id = subscription.subscription_id
                  WHERE {$this->table}.user_id = :id";



        $res =  $this->query($query, ['id' => $data]);

        if (empty($res)) {
            $query = "SELECT * FROM subscription WHERE subscription_id = 1";
            $res = $this->query($query);
        }

        return $res[0];
    }


    public function getsubscriptions()
    {
        $query = "SELECT {$this->table}.*, subscription.*
                  FROM {$this->table} 
                  LEFT JOIN subscription ON {$this->table}.subscription_id = subscription.id
                 ";


        $res =  $this->query($query);

        // If a user subscription is not found, return the default subscription


        return $res;
    }

    public function getDefaultSubscription()
    {
        $query = "SELECT * FROM subscription WHERE id = 1";
        $res = $this->query($query);

        if (!empty($res)) {
            return $res[0];
        }

        return false;
    }

    public function getCountBySubscription()
    {
        $query = "SELECT s.name, s.price, DATE_FORMAT(ms.start_date, '%b') as month, COUNT(ms.id) as member_count
                  FROM member_subscription AS ms
                  RIGHT JOIN subscription AS s ON ms.subscription_id = s.id
                  GROUP BY s.name, month";

        $res = $this->query($query);

        if (is_array($res)) {
            return $res;
        }

        return false;
    }



    public function assignDefaultSubscription($member_id)
    {
        // Check if the member already has a subscription
        $query = "SELECT * FROM {$this->table} WHERE member_id = :member_id";
        $res = $this->query($query, ['member_id' => $member_id]);

        // If the member does not have a subscription, assign the default subscription
        if (empty($res)) {
            $defaultSubscription = $this->getDefaultSubscription();
            if ($defaultSubscription) {
                $query = "INSERT INTO {$this->table} (member_id, subscription_id, start_date, end_date) 
                      VALUES (:member_id, :subscription_id, NOW(), DATE_ADD(NOW(), INTERVAL 1 MONTH))";
                $params = [
                    'member_id' => $member_id,
                    'subscription_id' => $defaultSubscription->id
                ];
                $this->query($query, $params);
            }
        }
    }


    public function updateExpiredsubscription($data)
    {


        $query = "UPDATE {$this->table}
              SET subscription_id = 1 
              WHERE end_date < :now";
        $this->query($query, $data);
    }
}
