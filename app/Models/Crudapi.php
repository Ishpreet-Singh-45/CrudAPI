<?php

namespace App\Models;

use \CodeIgniter\Model;

class Crudapi extends Model
{
    protected $table = 'items';
    
    protected $primaryKey = 'Id';
    
    protected $allowedFields = [
        'Id', 'Name', 'Description', 'Stock', 'Price'
    ];

}






?>