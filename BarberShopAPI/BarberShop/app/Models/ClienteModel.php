<?php 
namespace App\Models;
use CodeIgniter\Model;

class ClienteModel extends Model{
    protected $table = "clientes";
    protected $primaryKey = "id";

    protected $allowedFields = [
        "id",
        "nombre",
        "apellidos",
        "correo",
        "telefono",
        "pasword"
    ];

    public function login($usuario, $password){
        $usuario = $this->db->escape($usuario);
        $password = $this->db->escape($password);
        $result = $this->asArray()
        ->where("telefono = {$usuario} AND pasword = {$password} OR correo = {$usuario} AND pasword = {$password}")->first();

        return $result;
    }
}
?>