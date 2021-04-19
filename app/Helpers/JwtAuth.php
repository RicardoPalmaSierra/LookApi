<?php

namespace App\Helpers;

use App\Enum\ECodeStatus;
use App\Models\Client;
use App\Models\Professional;
use App\Models\User;
use Exception;
use Faker\Extension\Helper;
use Firebase\JWT\JWT;

class JwtAuth
{

    //Buscar existencia de usuario con credenciales
    public function logIn($email, $password)
    {
        try {

            $user = User::where('email', $email)->first();

            if(!isset($user)){
                return Helpers::response(ECodeStatus::NoContent, null, "Usuario no encontrado");
            }

            if(password_verify($password, $user->password) != 1){
                return Helpers::response(ECodeStatus::BadRequest, null, "Contraseña incorrecta");
            }

            $dataUser = Professional::where('usuarios_id', $user->id)->first();

            if (!$dataUser) {
                $dataUser = Client::where('usuarios_id', $user->id)->first();
            }

            if ($user) {
                $infoToken = array(
                    'sub' => $user->id,
                    'email' => $user->email,
                    'name' => $dataUser->nombres,
                    'surname' => $dataUser->apellidos,
                    'iat' => time(),
                    'exp' => time() + (1 * 24 * 60 * 60)
                );

                $jwt = JWT::encode($infoToken, env("JWT_KEY"), 'HS256');


                return Helpers::response(ECodeStatus::Ok, ['token' => $jwt], "Sesion iniciada");
            } else {
                return Helpers::response(ECodeStatus::BadRequest, null, "Usuario no encontrado");
            }
        } catch (Exception $ex) {
            return Helpers::response(ECodeStatus::InternalServerError, null, "Error: " . $ex->getMessage());
        }
    }


    public function checkToken($token = null, $getData = false)
    {
        $auth = false;

        try {
            $dataToken = JWT::decode($token, env("JWT_KEY"), ["HS256"]);
        } catch (\UnexpectedValueException $th) {
            $auth = false;
        } catch (\DomainException $e) {
            $auth = false;
        }

        if (!empty($dataToken) && is_object($dataToken) && isset($dataToken->sub)) {
            $auth = true;
        } else {
            $auth = false;
        }

        if ($getData) {
            return $dataToken;
        }

        return $auth;
    }
}
