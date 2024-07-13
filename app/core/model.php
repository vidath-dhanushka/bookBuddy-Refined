<?php

class Model extends Database
{

    public function insert($data)
    {
        if (!empty($this->allowedColumns)) {
            foreach ($data as $key => $value) {
                if (!in_array($key, $this->allowedColumns)) {
                    unset($data[$key]);
                }
            }
        }

        // echo $this->table;
        $keys = array_keys($data);

        $query = "insert into " . $this->table;
        $query .= " (" . implode(",", $keys) . ") values (:" . implode(",:", $keys) . ")";
        // echo $query;
        // print_r($data);
        // show($query);
        // die;
        $statement =  $this->query($query, $data);
        return $statement;
    }

    public function update($id, $data)
    {
        if (!empty($this->allowedColumns)) {
            foreach ($data as $key => $value) {
                if (!in_array($key, $this->allowedColumns)) {
                    unset($data[$key]);
                }
            }
        }

        // echo $this->table;
        $keys = array_keys($data);

        $query = "update " . $this->table . " set ";
        foreach ($keys as $key) {
            $query .= $key . "=:" . $key . ",";
        }
        $query = trim($query, ",");
        $query .= " where " . $this->table . "_id = :id";
        // echo $query;
        // show($data);
        // die;
        $data['id'] = $id;
        // show($data);
        // die;
        $statement =  $this->query($query, $data);
        return $statement;
    }





    public function where($data)
    {

        $keys = array_keys($data);
        $query = "select * from " . $this->table . " where ";
        foreach ($keys as $key) {
            $query .= $key . "=:" . $key . " && ";
        }

        $query = trim($query, "&& ");
        $res = $this->query($query, $data);

        if (is_array($res)) {
            return $res;
        }

        return false;
    }
    public function first($data)
    {

        $keys = array_keys($data);
        $query = "select * from " . $this->table . " where ";
        foreach ($keys as $key) {
            $query .= $key . "=:" . $key . " && ";
        }

        $query = trim($query, "&& ");
        $query .= " order by " . $this->table . "_id desc limit 1";
        // print_r($query);
        // print_r($data);
        // die;
        $res = $this->query($query, $data);

        if (is_array($res)) {
            return $res[0];
        }

        return false;
    }

    public function like($data)
    {
        // $data['author_name'] = 'harry';
        $keys = array_keys($data);
        $query = "select * from " . $this->table . " where ";
        foreach ($keys as $key) {
            $query .= $key . " like :" . $key . " && ";
        }

        $query = trim($query, "&& ");
        $query .= " order by id desc limit 1";
        $res = $this->query($query, $data);
        // print_r($res);

        if (is_array($res)) {
            return $res[0];
        }

        return false;
    }

    public function delete($id)
    {
        $query = "delete from " . $this->table . " where " . $this->table . "_id=" . $id;
        $this->query($query);
    }
}
