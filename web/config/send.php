<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 08.06.2016
 * Time: 13:49
 */

namespace mpoellath\sociallinks\config;
/*
 * Sends a Request to Facebook Api and returns the json
 */
class Send{




    public function response($link){

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_URL,$link);

        $json = json_decode(curl_exec($curl));
        curl_close($curl);
        return $json;
    }

}