<?php

namespace App\Models;

use CodeIgniter\Model;
use PHPUnit\Framework\Constraint\IsNull;

class MaterialModel extends Model
{
    protected $table = 'Material';
    protected $useTimestamps = true;
    protected $allowedFields = ['MaterialName', 'Price', 'CategoryId'];




    public function getMaterial($id = false)
    {
        if ($id == false) {
            return $this->findAll();
        }

        return $this->where(['Id' => $id])->first();
    }

    public function is_unique($MaterialName)
    {
        $found = $this->where(['MaterialName' => $MaterialName])->first();
        var_dump($found);
        if (is_null($found)) {
            return true;
        }
        return false;
    }
};
