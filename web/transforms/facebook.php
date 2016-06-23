<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 08.06.2016
 * Time: 13:46
 */

namespace mpoellath\sociallinks\transforms;

use Psr\Http\Message\ServerRequestInterface as Request;
use mpoellath\sociallinks\maltego\MaltegoTransformInput;
use mpoellath\sociallinks\config\Config;
/*
 *
 * Gets a Group from Input
 */
class Facebook{

    private $calls;
    private $input;
    private $config;

    public function __construct(Calls $calls, MaltegoTransformInput $input, Config $config)
    {
        $this->calls  = $calls;
        $this->input  = $input;
        $this->config = $config;

    }

    public function getGroup(Request $request,$response){


        //this works!
        if($this->input->getEntity($request->getParsedBody())) {


            $value = $this->input->transformFields['GroupPopUp'];
            if(!ctype_digit($value)) {
                error_log($value."what hte hell");
                return $this->calls->exception("Wrong Input, only Numerical String allowed");
            }
            else {

                return $this->calls->fgroup("https://graph.facebook.com/v2.6/" . $value . "?fields=cover,description,name,privacy,updated_time&" . $this->config->getAccessToken());
            }
        }
        else
        {
            return $this->calls->exception("NO correct Input");
        }
    }


    public function getEmailGroup(Request $request,$response){

        if($this->input->getEntity($request->getParsedBody())) {

            $value =$this->input->additionalFields;
            $id = $value['GroupID'];

            return  $this->calls->femail('https://graph.facebook.com/v2.6/'.$id.'?fields=email&'.$this->config->getAccessToken());
        }
        else {
            return $this->$this->calls->exception("NO correct Input");

        }
    }

    public function getFeed(Request $request,$response)
    {


        if ($this->input->getEntity($request->getParsedBody())) {

            $value = $this->input->additionalFields;
            $id = $value['GroupID'];
            $startpoint = $this->input->transformFields['FeedStartpoint'];
            $limit = $this->input->transformFields['FeedLimit'];


            if (!ctype_digit($startpoint) || !ctype_digit($limit)) {

                return $this->calls->exception("Wrong Input, only Numerical String allowed");

            } else {


                    return $this->calls->ffeed('https://graph.facebook.com/v2.6/' . $id . '/feed?fields=from,message,created_time&limit='.$limit.'&offset='.$startpoint.'&' . $this->config->getAccessToken());

                }
             }
            else
            {
                return $this->calls->exception("NO correct Input");
            }
        }

    public function getMemberList(Request $request,$response)
    {



        if ($this->input->getEntity($request->getParsedBody())) {

            $value = $this->input->additionalFields;
            $id = $value['GroupID'];
            $startpoint = $this->input->transformFields['MemberStartpoint'];
            $limit = $this->input->transformFields['MemberLimit'];

            if(!ctype_digit($startpoint) || !ctype_digit($limit))
            {
                return $this->calls->exception("Wrong Input, only Numerical Strings allowed");

            }else {


               return $this->calls->fmember("https://graph.facebook.com/v2.6/" . $id . "/members?fields=last_name,first_name,picture&limit=" . $limit . "&offset=" . $startpoint . "&" . $this->config->getAccessToken());
            }

        } else {

            return $this->calls->exception("NO input entity found");
        }


    }



}


