<?php

namespace App\Helper;


use Illuminate\Support\Facades\DB;

class Helper
{

    //Call Api Check Key with this
//$tokenCheck = Helper::checkApiKey($key);
//if ($tokenCheck != null){
//return $tokenCheck;
//}

    public static function isAPI()
    {
        $url = url()->current();
        if (str_contains($url, 'api/')){
            return true;
        }else{
            return false;
        }
    }

    public static function checkApiKey($key)
    {
        $check = DB::table('api_key')
            ->where('key', '=', "$key")
            ->count();

        if ($check == 0) {
            return response()->json([
                'message' => "Unauthorized, Api Key Mismatch",
                'http_response' => 401,
                'status_code' => 0,
            ], 401);
        }
        return null;
    }

    public static function profileImgPath()
    {
        return "photo/profile";
    }

    public static function newsImgPath()
    {
        return "photo/news";
    }
    public static function reqSellImgPath()
    {
        return "photo/profile";
    }

}



