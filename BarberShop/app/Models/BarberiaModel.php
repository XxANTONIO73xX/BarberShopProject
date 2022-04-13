<?php 
namespace App\Models;
use CodeIgniter\Model;

class BarberiaModel extends Model{
    protected $table = "barberias";
    protected $primaryKey = "id";

    protected $allowedFields = [
        "id",
        "nombre",
        "direccion",
        "telefono",
        "correo",
        "horario",
        "estado"
    ];
}
?>