<?php 
namespace App\Models;
use CodeIgniter\Model;

class AdministradorModel extends Model{
    protected $table = "Administrador";
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