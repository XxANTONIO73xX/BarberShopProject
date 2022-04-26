<?php

namespace App\Models;
use CodeIgniter\Model;

class CortesModel extends Model{

    protected $table      = 'cortes';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['nombre', 'visualización' ];

    //protected $useTimestamps = true;
   // protected $createdField  = 'fecha_alta';
   // protected $updatedField  = 'fecha_edit';
   // protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}

?>