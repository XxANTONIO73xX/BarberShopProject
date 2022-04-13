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
        "password"
    ];

    public function login($usuario, $password){
        $result = $this->asArray()->where([
            "telefono" => $usuario,
            "password" => $password
        ])->orWhere([
            "correo" => $usuario,
            "password" => $password
        ])->first();

        return $result;
    }
}
?>