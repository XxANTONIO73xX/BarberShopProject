<?php

namespace App\Models;
use CodeIgniter\Model;

class BarberosModel extends Model{

    protected $table      = 'barberos';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['nombre', 'apellidos','apodo', 'correo', 'telefono', 'password', 'idBarberia' ];

    //protected $useTimestamps = true;
   // protected $createdField  = 'fecha_alta';
   // protected $updatedField  = 'fecha_edit';
   // protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}

?>