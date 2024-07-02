<?php

class User extends Model
{
    protected $table = "user";
    public $errors = [];

    protected $allowedColumns = [
        'first_name',
        'last_name',
        'username',
        'email',
        'phone',
        'address_district',
        'password',
        'role',
        'address_line_1',
        'address_line_2',
        'address_city',
        'zip_code',
    ];

    public function validate($data)
    {
        $this->errors = [];

        if (empty($data['first_name'])) {
            $this->errors['first_name'] = "Please enter the first name";
        } else
        if (!preg_match("/^[a-zA-Z ]+$/", $data['first_name'])) {
            $this->errors['first_name'] = "first name can only have letters";
        }
        if (empty($data['last_name'])) {
            $this->errors['last_name'] = "Please enter the last name";
        } else
        if (!preg_match("/^[a-zA-Z]+$/", $data['last_name'])) {
            $this->errors['last_name'] = "last name can only have letters without spaces";
        }
        if (empty($data['username'])) {
            $this->errors['username'] = "Please enter the username";
        }

        if (!filter_var($data['email'],  FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = "Please enter A valid email";
        } elseif ($this->where(['email' => $data['email']])) {
            $this->errors['email'] = "email already exists";
        }
        if (empty($data['phone'])) {
            $this->errors['phone'] = "Please enter the phone number";
        } else
        if (!preg_match('/^\+[0-9]{11}$/', $data['phone'])) {
            $this->errors['phone'] = "please enter the number in international standards";
        }
        if (empty($data['address_district'])) {
            $this->errors['address_district'] = "Please select the district you belongs to";
        }
        if (empty($data['password'])) {
            $this->errors['password'] = "Please enter the password";
        }
        if (empty($data['confirm_password'])) {
            $this->errors['confirm_password'] = "Please re enter password";
        }
        if ($data['password'] !== $data['confirm_password']) {
            $this->errors['confirm_password'] = "passwords
             do not match";
        }

        if (empty($this->errors)) {
            return true;
        }

        return false;
    }

    public function edit_validate($data, $id)
    {
        $this->errors = [];

        if (empty($data['first_name'])) {
            $this->errors['first_name'] = "Please enter the first name";
        } else
        if (!preg_match("/^[a-zA-Z ]+$/", $data['first_name'])) {
            $this->errors['first_name'] = "first name can only have letters";
        }
        if (empty($data['last_name'])) {
            $this->errors['last_name'] = "Please enter the last name";
        } else
        if (!preg_match("/^[a-zA-Z]+$/", $data['last_name'])) {
            $this->errors['last_name'] = "last name can only have letters without spaces";
        }
        if (empty($data['phone'])) {
            $this->errors['phone'] = "Please enter the phone number";
        } else
        if (!preg_match('/^\+[0-9]{11}$/', $data['phone'])) {
            $this->errors['phone'] = "please enter the number in international standards";
        }
        if (empty($data['address_district'])) {
            $this->errors['address_district'] = "Please select a district";
        }
        if (!empty($data['zip_code']) && strlen($data['zip_code']) != 5) {
            $this->errors['zip_code'] = "Please enter a valid zip code";
        }


        if (empty($this->errors)) {
            return true;
        }


        return false;
    }
}
