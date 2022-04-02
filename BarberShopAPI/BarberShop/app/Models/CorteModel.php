<?php 
namespace App\Models;
use CodeIgniter\Model;

class CorteModel extends Model{
    protected $table = "cortes";
    protected $primaryKey = "id";

    protected $allowedFields = [
        "id",
        "nombre",
        "visualizacion",
        "idBarbero"
    ];
    
    public function obtenerPorBarbero($id){
        $result = $this->asArray()->where(["idBarbero" => $id])->findAll();
        return $result;
    }
}
?>