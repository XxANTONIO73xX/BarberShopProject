<?php

namespace App\Models;
use CodeIgniter\Model;

class ClientesModel extends Model{

    protected $table      = 'clientes';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['nombre', 'apellidos', 'correo', 'telefono', 'password' ];

    //protected $useTimestamps = true;
   // protected $createdField  = 'fecha_alta';
   // protected $updatedField  = 'fecha_edit';
   // protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}

?>