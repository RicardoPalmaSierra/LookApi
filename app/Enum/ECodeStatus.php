<?php

namespace App\Enum;

abstract class ECodeStatus
{
    const Ok = 200; //success
    const NoContent = 204; //info
    const Unauthorized = 401; // cuando el usuario no esta logueado
    const BadRequest = 400; //danger
    const Forbidden = 403; // el usuario no tiene permiso
    const InternalServerError = 500; //danger
}
