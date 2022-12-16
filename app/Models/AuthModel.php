<?php

namespace App\Models;

use CodeIgniter\Model;

class AuthModel extends Model
{
    protected $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    public function authUserDetails($username, $password)
    {
        $selectQuery = 'SELECT * FROM musers WHERE musers.status = 2 AND musers.astatus = 2 AND musers.username = "' . $username . '" AND musers.password = "' . $password . '"';
        $query = $this->db->query($selectQuery);
        if ($query) {
            return $query->getResult();
        }
        return false;
    }

    public function checkUserExist($username)
    {
        $selectQuery = 'SELECT * FROM musers WHERE musers.status = 2 AND musers.astatus = 2 AND musers.username = "' . $username . '"';
        $query = $this->db->query($selectQuery);
        if ($query) {
            return $query->getResult();
        }
        return false;
    }


    public function getUserDefaultProperty($userId)
    {
        $selectQuery = 'SELECT * FROM mpropertyusers WHERE status = 2 AND astatus = 2 AND is_default=2 AND muser_id = ' . $userId;
        $query = $this->db->query($selectQuery);
        if ($query) {
            return $query->getResult();
        }
        return false;
    }

    public function createUser($userData)
    {
        return $this->insertData('musers', $userData);
    }

    private function insertData($table, $data)
    {
        $this->db->table($table)->insert($data);
        return $this->db->insertID();
    }

    // public function getUserDetails($userId){
    //     $selectQuery = 'SELECT * FROM musers WHERE musers.status = 2 AND musers.astatus = 2 AND musers.id = "'.$userId.'"';
    //     $query = $this->db->query($selectQuery);
    //     if($query){
    //         return $query->getResult();
    //     }
    //     return false;
    // }
}
