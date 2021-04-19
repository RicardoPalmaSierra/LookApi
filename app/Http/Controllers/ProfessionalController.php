<?php

namespace App\Http\Controllers;

use App\Enum\ECodeStatus;
use App\Helpers\Helpers;
use App\Models\Professional;
use Exception;
use Illuminate\Http\Request;

class ProfessionalController extends Controller
{
    //
    public function create(Request $request)
    {
    }

    public function search(Request $request)
    {
        try {
            $filtros = $request->all();



            return Helpers::response(ECodeStatus::Ok, [], "Profesionales encontrados");
        } catch (Exception $ex) {
            return Helpers::response(ECodeStatus::InternalServerError, null, "Error: " . $ex->getMessage());
        }
    }

    public function getProfessionalById($id)
    {
        try {
            if ($id) {
                $profile = Professional::find($id);
                if ($profile) {
                    return Helpers::response(ECodeStatus::Ok, $profile, "Perfil encontrado");
                } else {
                    return Helpers::response(ECodeStatus::NoContent, null, "No se encontro profesional");
                }
            } else {
                return Helpers::response(ECodeStatus::BadRequest, null, "Profesional es requerido");
            }
        } catch (Exception $ex) {
            return Helpers::response(ECodeStatus::InternalServerError, null, "Error: " . $ex->getMessage());
        }
    }
}
