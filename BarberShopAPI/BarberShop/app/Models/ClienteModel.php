<?php 
namespace App\Models;
use CodeIgniter\Model;

class ClienteModel extends Model{
    protected $table = "cliente";
    protected $primaryKey = "id";

    protected $allowedFields = [
        "id",
        "nombre",
        "apellidos",
        "correo",
        "telefono",
        "password"
    ];
}
?>