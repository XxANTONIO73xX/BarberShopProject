<?php
namespace App\Controllers;

use App\Models\AdministradorModel;
use App\Models\BarberoModel;
use App\Models\ClienteModel;
use CodeIgniter\Config\Services;
use CodeIgniter\RESTful\ResourceController;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Auth extends ResourceController{
    protected $format = 'json';
    protected $token;
    protected $barbero;
    protected $cliente;
    protected $administrador;
    protected $tipoUsuario;

    public function __construct()
    {
        
    }

    public function create(){
        $user = $this->request->getPost("user");
        $password = $this->request->getPost("password");
        $tipo = $this->request->getPost("tipo");

        if($tipo == "cliente"){
            $clienteModel = new ClienteModel();
            $this->cliente = $clienteModel->login($user, $password);
            if($this->cliente){
                $time = time();
                $key = Services::getSecretKey();
                $userId = $this->cliente["id"];
                $payload = [
                    'aud' => "http://kikosBarberShop.com",
                    'iat' => $time,
                    'nbf' => $time,
                    'exp' => $time+(60*60*24*7),
                    'data' => [
                        "user_id" => $userId,
                        "tipo" => $tipo
                    ]
                ];
                $jwt = JWT::encode($payload, $key, 'HS256');
                return $this->respond(["token" => $jwt, "user"=>$this->cliente, "tipo" => $tipo]);
            }else{
                return $this->respond(["error" => "Usuario y contraseña incorrectos"]);
            }
        }

        if($tipo == "barbero"){
            $barberoModel = new BarberoModel();
            $this->barbero = $barberoModel->login($user, $password);
            if($this->barbero){
                $time = time();
                $key = Services::getSecretKey();
                $userId = $this->barbero["id"];
                $payload = [
                    'aud' => "http://kikosBarberShop.com",
                    'iat' => $time,
                    'nbf' => $time,
                    'exp' => $time+(60*60*24*7),
                    'data' => [
                        "user_id" => $userId,
                        "tipo" => $tipo
                    ]
                ];
                $jwt = JWT::encode($payload, $key, 'HS256');
                return $this->respond(["token" => $jwt, "user"=>$this->barbero, "tipo" => $tipo]);
            }else{
                return $this->respond(["error" => "Usuario y contraseña incorrectos"]);
            }
        }

        if($tipo == "administrador"){
            $administradorModel = new AdministradorModel();
            $this->administrador = $administradorModel->login($user, $password);
            if($this->administrador){
                $time = time();
                $key = Services::getSecretKey();
                $userId = $this->administrador["id"];
                $payload = [
                    'aud' => "http://kikosBarberShop.com",
                    'iat' => $time,
                    'nbf' => $time,
                    'exp' => $time+(60*60*24*7),
                    'data' => [
                        "user_id" => $userId,
                        "tipo" => $tipo
                    ]
                ];
                $jwt = JWT::encode($payload, $key, 'HS256');
                return $this->respond(["token" => $jwt, "user"=>$this->administrador, "tipo" => $tipo]);
            }else{
                return $this->respond(["error" => "Usuario y contraseña incorrectos"]);
            }
        }
    }

    public function verifyToken(){
        $key = Services::getSecretKey();
        $token_str = $this->request->getHeader("token")->getValue();
        try{
            $token = JWT::decode($token_str, new Key($key, 'HS256'));
        }catch(\Throwable $th){
            $token = false;
        }

        if(!$token){
            return false;
        }else{
            if($token->data->tipo == "cliente"){
                $clienteModel = new ClienteModel();
                $this->cliente = $clienteModel->find($token->data->user_id);
                $this->tipoUsuario = "cliente";
            }else if($token->data->tipo == "barbero"){
                $barberoModel = new BarberoModel();
                $this->barbero = $barberoModel->find($token->data->user_id);
                $this->tipoUsuario = "barbero";
            }else if($token->data->tipo == "administrador"){
                $administradorModel = new AdministradorModel();
                $this->administrador = $administradorModel->find($token->data->user_id);
                $this->tipoUsuario = "administrador";
            }
            
        }
    }
}
?>