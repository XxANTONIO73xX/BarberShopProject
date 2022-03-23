<?php 
namespace App\Models;
use CodeIgniter\Model;

class BarberoModel extends Model{
    protected $table = "barbero";
    protected $primaryKey = "id";

    protected $allowedFields = [
        "id",
        "nombre",
        "apodo",
        "apellidos",
        "correo",
        "telefono",
        "password",
        "idBarberia"
    ];
}
?>