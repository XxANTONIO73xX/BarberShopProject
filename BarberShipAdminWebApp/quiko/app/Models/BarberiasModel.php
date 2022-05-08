<?php

namespace App\Models;
use CodeIgniter\Model;

class BarberiasModel extends Model{

    protected $table      = 'barberias';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['nombre', 'direccion','telefono', 'correo', 'horario', 'estado' ];

    //protected $useTimestamps = true;
   // protected $createdField  = 'fecha_alta';
   // protected $updatedField  = 'fecha_edit';
   // protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}

?>