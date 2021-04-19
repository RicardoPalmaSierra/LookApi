<?php

namespace App\Http\Controllers;

use App\Enum\ECodeStatus;
use App\Helpers\Helpers;
use App\Helpers\JwtAuth;
use App\Models\Client;
use App\Models\Professional;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    //

    public function logIn(Request $request)
    {

        if (!isset($request->email)) {
            return Helpers::response(ECodeStatus::Ok, null, "Usuario es requerido");
        }

        $jwt = new JwtAuth();

        return $jwt->logIn($request->email, $request->password);
    }

    public function profile()
    {
        return "";
    }

    public function register(Request $request)
    {

        try {

            DB::beginTransaction();

            if (!isset($request->email)) {
                return Helpers::response(ECodeStatus::BadRequest, null, "Correo electronico es requerido");
            }

            if (!isset($request->password)) {
                return Helpers::response(ECodeStatus::BadRequest, null, "Correo electronico es requerido");
            }

            if (!isset($request->names)) {
                return Helpers::response(ECodeStatus::BadRequest, null, "Nombre es requerido");
            }

            if (!isset($request->lastname)) {
                return Helpers::response(ECodeStatus::BadRequest, null, "Apellidos es requerido");
            }

            if (!isset($request->country)) {
                return Helpers::response(ECodeStatus::BadRequest, null, "Pais es requerido");
            }

            if (!isset($request->city)) {
                return Helpers::response(ECodeStatus::BadRequest, null, "Ciudad es requerida");
            }

            if (!isset($request->address)) {
                return Helpers::response(ECodeStatus::BadRequest, null, "Dirección es requerida");
            }

            if (!isset($request->phone)) {
                return Helpers::response(ECodeStatus::BadRequest, null, "Teléfono es requerido");
            }

            $user = new User();

            $user->email = $request->email;
            $user->password = password_hash($request->password, PASSWORD_BCRYPT);
            $user->estado = 1;

            switch ($request->type) {
                case 1:
                    // Profesional

                    $user->tipousuario = 1;

                    if ($user->save()) {

                        $profesional = new Professional();

                        $profesional->identification = 0;
                        $profesional->nombres = $request->names;
                        $profesional->apellidos = $request->lastname;
                        $profesional->pais_reside = $request->country;
                        $profesional->ciudad_reside = $request->city;
                        $profesional->dir_reside = $request->address;
                        $profesional->celular = $request->phone;
                        $profesional->usuarios_id = $user->id;

                        if ($profesional->save()) {
                            DB::commit();
                            return Helpers::response(ECodeStatus::Ok, null, "Usuario registrado exitosamente");
                        }
                    }

                    break;
                case 2:
                    // Cliente

                    $user->tipousuario = 2;

                    if ($user->save()) {

                        $client = new Client();

                        $client->identificacion = 0;
                        $client->nombres = $request->names;
                        $client->apellidos = $request->lastname;
                        $client->pais_reside = $request->country;
                        $client->ciudad_reside = $request->city;
                        $client->dir_reside = $request->address;
                        $client->celular = $request->phone;
                        $client->usuarios_id = $user->id;
                        if ($client->save()) {
                            DB::commit();
                            return Helpers::response(ECodeStatus::Ok, null, "Usuario registrado exitosamente");
                        }
                    }

                    break;
                default:
                    return Helpers::response(ECodeStatus::BadRequest, null, "Tipo de perfil no existe");
                    break;
            }
        } catch (Exception $ex) {
            DB::rollBack();
            return Helpers::response(ECodeStatus::InternalServerError, null, "Error: " . $ex->getMessage());
        }
    }

    public function update(Request $request)
    {
        try {
            $idUser = Helpers::getIdUserByToken($request);


            return $idUser;
        } catch (Exception $ex) {
            return Helpers::response(ECodeStatus::InternalServerError, null, "Error: " . $ex->getMessage());
        }
    }
}
