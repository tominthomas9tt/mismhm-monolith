<?php

namespace App\Models;

use CodeIgniter\Model;

class HotlierModel extends Model
{

    // protected $table      = 'mpropertyusers';
    // protected $primaryKey = 'id';

    // protected $useAutoIncrement = true;

    // protected $returnType     = 'array';
    // protected $useSoftDeletes = true;

    // protected $allowedFields = ['name', 'designation', 'state', 'phone', 'email'];

    // protected $useTimestamps = true;
    // protected $dateFormat = 'datetime';
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    // protected $validationRules    = [];
    // protected $validationMessages = [];
    // protected $skipValidation     = false;


    protected $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    public function getUserproperties($userId)
    {
        $selectQuery = 'SELECT mpropertyusers.id, mproperties.name AS propertyName, mpropertyroles.name AS roleName, mpropertyusers.is_default AS isDefault, mpropertyusers.status AS status FROM mpropertyusers LEFT JOIN mproperties ON mproperties.id = mpropertyusers.mproperty_id LEFT JOIN mpropertyroles ON mpropertyroles.id = mpropertyusers.mpropertyrole_id WHERE mpropertyroles.status = 2 AND mpropertyroles.astatus = 2 AND mproperties.status = 2 AND mproperties.astatus = 2 AND mpropertyusers.status = 2 AND mpropertyusers.astatus = 2 AND mpropertyusers.muser_id = ' . $userId;
        $query = $this->db->query($selectQuery);
        if ($query) {
            return $query->getResult();
        }
        return false;
    }

    public function insertData($data = array())
    {
        $this->db->table($this->table)->insert($data);
        return $this->db->insertID();
    }

    public function updateData($id, $data = array())
    {
        $this->db->table($this->table)->update($data, array(
            "id" => $id,
        ));
        return $this->db->affectedRows();
    }

    public function deleteData($id)
    {
        return $this->db->table($this->table)->delete(array(
            "id" => $id,
        ));
    }

    public function getUserWhere($where)
    {
        $query = $this->db->table($this->table)->getWhere($where);
        $result = $query->getResult();
        if (count($result) > 0) {
            return $result;
        } else {
            return false;
        }
    }

    public function getUserDetailsFromPhone($phone)
    {
        $select = "SELECT * FROM " . $this->table . " WHERE phone like '%" . $phone . "%'";
        $query = $this->db->query($select);
        $result = $query->getResult();
        if (count($result) == 1) {
            return $result;
        } else {
            return false;
        }
    }

    public function countData()
    {
        $query = $this->db->query('SELECT count(id) as participants FROM ' . $this->table);
        $result = $query->getResult();
        if (count($result) > 0) {
            return $result;
        } else {
            return false;
        }
    }


    public function getAllData()
    {
        $query = $this->db->query('SELECT * FROM ' . $this->table);
        $result = $query->getResult();
        if (count($result) > 0) {
            return $result;
        } else {
            return false;
        }
    }
}
