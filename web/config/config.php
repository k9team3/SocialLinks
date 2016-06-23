<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 03.06.2016
 * Time: 09:21
 */

namespace mpoellath\sociallinks\config;
/*
 * Contains the Facebook access token
 */
class Config{


    var $facebookkey = "access_token=";
    var $googlekey = "";


    public function getAccessToken()
    {
        return $this->facebookkey;
    }

    public function getGooglekey()
    {
        return $this->googlekey;
    }
}
