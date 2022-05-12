<?php 
namespace App\Models;
use CodeIgniter\Model;

class BarberoModel extends Model{
    protected $table = "barberos";
    protected $primaryKey = "id";

    protected $allowedFields = [
        "id",
        "nombre",
        "apodo",
        "apellidos",
        "telefono",
        "idBarberia",
        "visualizacion"
    ];
    
    public function obtenerPorBarberia($id){
        $result = $this->asArray()->where(["idBarberia" => $id])->findAll();
        return $result;
    }

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