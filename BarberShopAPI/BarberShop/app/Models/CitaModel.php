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

    public function isDateTimeValidate($fecha, $hora){
        $result = $this->asArray()->where(["fecha"=>$fecha, "hora"=>$hora])->findAll();
        if(empty($result)){
            return true;
        }
        return false;
    }

    public function CorteMasPedido(){
        $list = $this->db->query("SELECT idCorte, COUNT(idCorte) AS total FROM citas GROUP BY idCorte ORDER BY total DESC");
        return $list->getRow();
    }

    public function ConteoCortes(){
        $list = $this->db->query("SELECT idCorte, COUNT(idCorte) AS total FROM citas GROUP BY idCorte ORDER BY total DESC")->getResultArray();
        return $list;
    }

    public function BarberiaMasPedido(){
        $list = $this->db->query("SELECT idBarberia, COUNT(idBarberia) AS total FROM citas GROUP BY idBarberia ORDER BY total DESC");
        return $list->getRow();
    }

    public function ConteoBarberias(){
        $list = $this->db->query("SELECT idBarberia, COUNT(idBarberia) AS total FROM citas GROUP BY idBarberia ORDER BY total DESC")->getResultArray();
        return $list;
    }

    public function BarberoMasPedido(){
        $list = $this->db->query("SELECT idBarbero, COUNT(idBarbero) AS total FROM citas GROUP BY idBarbero ORDER BY total DESC");
        return $list->getRow();
    }

    public function ConteoBarberos(){
        $list = $this->db->query("SELECT idBarbero, COUNT(idBarbero) AS total FROM citas GROUP BY idBarbero ORDER BY total DESC")->getResultArray();
        return $list;
    }
}
?>