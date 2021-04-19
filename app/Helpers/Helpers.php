<?php

namespace App\Helpers;

class Helpers
{

    public static function response($status, $data, $message)
    {
        return ['status' => $status, 'data' => $data, 'message' => $message];
    }

    public static function getIdUserByToken($request)
    {
        $auth = new JwtAuth();
        $dataToken = $auth->checkToken($request->header("Authorization"), true);
        return  $dataToken->sub;
    }

    public static function getIdTypeUser($request)
    {
        $auth = new JwtAuth();
        $dataToken = $auth->checkToken($request->header("Authorization"), true);
        return  $dataToken->tu;
    }
}
