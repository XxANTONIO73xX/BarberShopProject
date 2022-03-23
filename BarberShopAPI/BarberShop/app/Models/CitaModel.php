<?php 
namespace App\Models;
use CodeIgniter\Model;

class CitaModel extends Model{
    protected $table = "cita";
    protected $primaryKey = "id";

    protected $allowedFields = [
        "id",
        "idCliente",
        "idBarbero",
        "idCorte",
        "idBarberia",
        "fecha",
        "hora",
        "estado"
    ];
}
?>