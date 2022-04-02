<?php 
namespace App\Models;
use CodeIgniter\Model;

class CitaModel extends Model{
    protected $table = "citas";
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

    public function obtenerPorCliente($id){
        $result = $this->asArray()->where(["idCliente" => $id])->findAll();
        return $result;
    }

    public function obtenerPorBarbero($id){
        $result = $this->asArray()->where(["idBarbero" => $id])->findAll();
        return $result;
    }
}
?>