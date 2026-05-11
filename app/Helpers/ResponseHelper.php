<?php

namespace App\Helpers;

class ResponseHelper{
    static function success($message = "تمت العملية بنجاح" , $data=null , $code = 200){
        return [
            'success' => true,
            'message' => $message,
            'data' => $data,
            'code' => $code
        ];

    }
    static function fail($message = " فشلت العملية " , $data=null , $code = 400){
        return [
            'success' => false,
            'message' => $message,
            'data' => $data,
            'code' => $code
        ];
    }
}