<?php 
namespace App\Models;
use CodeIgniter\Model;

class CorteModel extends Model{
    protected $table = "corte";
    protected $primaryKey = "id";

    protected $allowedFields = [
        "id",
        "nombre",
        "visualizacion",
        "idBarbero"
    ];
}
?>