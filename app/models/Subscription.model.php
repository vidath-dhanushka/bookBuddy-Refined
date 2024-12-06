<?php

class Subscription extends Model
{
    protected $table = "subscription";
    public $errors = [];

    protected $allowedColumns = [
        'id',
        'name',
        'price',
        'max_books',
        'borrowing_period',
        'date_added',
        'modify_date'
    ];

    public function getPlanById($planId)
    {
        // Adjust the query based on your database setup
        $query = "SELECT name FROM " . $this->table . " WHERE subscription_id = :id";
        $result = $this->query($query, ['id' => $planId]);

        // Return the plan if found, else return null
        return !empty($result) ? $result[0] : null;
    }

    public function validateUpdate($planId, $planData)
    {
        // Fetch the current plan details
        $currentPlan = $this->getPlanById($planId);

        if ($currentPlan === null) {
            $this->errors['general'] = "Plan not found.";
            return false;
        }

        // Get the current name
        $currentPlanName = $currentPlan->name;

        // Validate 'name'
        if (empty($planData['name'])) {
            $this->errors['name'] = "Name is required.";
        } elseif (!is_string($planData['name'])) {
            $this->errors['name'] = "Name must be a string.";
        } elseif (!preg_match("/^[a-zA-Z\s]+$/", $planData['name'])) {
            $this->errors['name'] = "Name can only contain letters and spaces.";
        } else {
            // Only check uniqueness if the name has changed
            if ($planData['name'] !== $currentPlanName) {
                $existingPlan = $this->findPlanByName($planData['name']);
                if ($existingPlan) {
                    $this->errors['name'] = "The subscription name must be unique.";
                }
            }
        }

        // Validate 'price'
        if ($planData['price'] === '' || $planData['price'] === null) {
            $this->errors['price'] = "Price is required.";
        } elseif (!is_numeric($planData['price'])) {
            $this->errors['price'] = "Price must be a number.";
        } elseif ($planData['price'] <= 0) {
            $this->errors['price'] = "Price cannot be negative or zero.";
        }

        // Validate 'max_books'
        if ($planData['max_books'] === '' || $planData['max_books'] === null) {
            $this->errors['max_books'] = "Maximum books is required.";
        } elseif (!is_numeric($planData['max_books'])) {
            $this->errors['max_books'] = "Maximum books must be a number.";
        } elseif ($planData['max_books'] <= 0) {
            $this->errors['max_books'] = "Maximum books cannot be negative or zero.";
        }

        // Validate 'borrowing_period'
        if ($planData['borrowing_period'] === '' || $planData['borrowing_period'] === null) {
            $this->errors['borrowing_period'] = "Borrowing period is required.";
        } elseif (!is_numeric($planData['borrowing_period'])) {
            $this->errors['borrowing_period'] = "Borrowing period must be a number.";
        } elseif ($planData['borrowing_period'] <= 0) {
            $this->errors['borrowing_period'] = "Borrowing period cannot be negative or zero.";
        }

        // Return validation result
        return empty($this->errors);
    }

    function validate($plan)
    {

        if (empty($plan['name'])) {
            $this->errors['name'] = "Name is required.";
        } elseif (!is_string($plan['name'])) {
            $this->errors['name'] = "Name must be a string.";
        } elseif (!preg_match("/^[a-zA-Z\s]+$/", $plan['name'])) {
            $this->errors['name'] = "Name can only contain letters and spaces.";
        } else {

            $existingPlan = $this->findPlanByName($plan['name']);
            if ($existingPlan) {
                $this->errors['name'] = "The subscription name must be unique..";
            }
        }

        // Validate 'price'
        if ($plan['price'] === '' || $plan['price'] === null) {
            $this->errors['price'] = "Price is required.";
        } elseif (!is_numeric($plan['price'])) {
            $this->errors['price'] = "Price must be a number.";
        } elseif ($plan['price'] <= 0) {
            $this->errors['price'] = "Price cannot be negative or zero.";
        }

        // Validate 'max_books'
        if ($plan['max_books'] === '' || $plan['max_books'] === null) {
            $this->errors['max_books'] = "Maximum books is required.";
        } elseif (!is_numeric($plan['max_books'])) {
            $this->errors['max_books'] = "Maximum books must be a number.";
        } elseif ($plan['max_books'] <= 0) {
            $this->errors['max_books'] = "Maximum books cannot be negative or zero.";
        }

        // Validate 'borrowing_period'
        if ($plan['borrowing_period'] === '' || $plan['borrowing_period'] === null) {
            $this->errors['borrowing_period'] = "Borrowing period is required.";
        } elseif (!is_numeric($plan['borrowing_period'])) {
            $this->errors['borrowing_period'] = "Borrowing period must be a number.";
        } elseif ($plan['borrowing_period'] <= 0) {
            $this->errors['borrowing_period'] = "Borrowing period cannot be negative or zero.";
        }

        if (empty($this->errors)) {
            return true;
        }

        return false;
    }

    public function findPlanByName($name)
    {

        $query = "SELECT COUNT(*) as count 
                  FROM " . $this->table . " 
                  WHERE name = :name";

        $result = $this->query($query, ['name' => $name]);

        return !empty($result) && $result[0]->count > 0;
    }




    public function get_all_subscriptions()
    {
        $sql = "
        SELECT 
            s.* 
        FROM 
            " . $this->table . " s
        WHERE 
            s.status = 'active'
        ORDER BY 
            s.subscription_id
    ";

        return $this->query($sql);
    }



    public function get_subscription_by_id($id)
    {
        $sql = "
        SELECT 
            s.* 
        FROM 
            " . $this->table . " s
        WHERE 
            s.subscription_id = :id
        LIMIT 1
    ";

        $result = $this->query($sql, $id);
        if (isset($result) && count($result) > 0) {
            return $result[0];
        }

        return false;
    }

    public function delete_subscription_by_id($id)
    {
        // Validate the ID
        if (!filter_var($id, FILTER_VALIDATE_INT, array("options" => array("min_range" => 1)))) {
            $this->errors[] = "Invalid ID provided.";
            return false;
        }

        $sql = '
        UPDATE 
            ' . $this->table . '
        SET 
            status = "inactive"
        WHERE 
            subscription_id = :id
        LIMIT 1
    ';
        $result = $this->query($sql, ['id' => $id]);



        if ($result && $result->rowCount() > 0) {
            return true;
        } else {
            $this->errors[] = "Failed to delete the subscription or no changes made.";
            return false;
        }
    }
}
