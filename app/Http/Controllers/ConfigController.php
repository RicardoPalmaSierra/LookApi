<?php

namespace App\Http\Controllers;

use App\Enum\ECodeStatus;
use App\Helpers\Helpers;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConfigController extends Controller
{
    //

    public function countries()
    {
        try {
            $countries = DB::select('SELECT * FROM paises');

            return Helpers::response(ECodeStatus::Ok, $countries, "Informacio encontrada");
        } catch (Exception $ex) {
            return Helpers::response(ECodeStatus::InternalServerError, null, "Error: " . $ex->getMessage());
        }
    }

    public function cities($country)
    {
        try {
            $cities = DB::select('SELECT * FROM ciudades WHERE paises_id = ? ', [$country]);

            if ($cities) {
                return Helpers::response(ECodeStatus::Ok, $cities, "Informacio encontrada");
            } else {
                return Helpers::response(ECodeStatus::NoContent, [], "No se encontraron resultados");
            }
        } catch (Exception $ex) {
            return Helpers::response(ECodeStatus::InternalServerError, null, "Error: " . $ex->getMessage());
        }
    }
}
