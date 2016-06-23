<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 03.06.2016
 * Time: 09:21
 */

/*
 * Contains the Facebook access token
 */
class Config{


    var $facebookkey = "access_token=1437323562960057|199c1b5b38abf9e5a075c4991153741e";
    var $googlekey = "AIzaSyBPESkU0hQUfM1Y9hCxF-lj27dOTDlW_l0";


    public function getAccessToken()
    {
        return $this->facebookkey;
    }

    public function getGooglekey()
    {
        return $this->googlekey;
    }
}