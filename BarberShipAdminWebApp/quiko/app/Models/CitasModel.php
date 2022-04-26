<?php

namespace App\Models;
use CodeIgniter\Model;

class CitasModel extends Model{

    protected $table      = 'citas';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['fecha', 'hora', 'estado', 'idCliente', 'idCorte','idBarbero','idBarberia' ];

    //protected $useTimestamps = true;
   // protected $createdField  = 'fecha_alta';
   // protected $updatedField  = 'fecha_edit';
   // protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}

?>