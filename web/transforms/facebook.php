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
    private $link = "https://graph.facebook.com/v2.6/";
    private $invalid = "No Valid Input!";

    /**
     * Facebook constructor.
     * @param Calls $calls
     * @param MaltegoTransformInput $input
     * @param Config $config
     */
    public function __construct(Calls $calls, MaltegoTransformInput $input, Config $config)
    {
        $this->calls  = $calls;
        $this->input  = $input;
        $this->config = $config;

    }

    /**
     * @param Request $request
     * @return string
     */
    public function getGroup(Request $request){

        if($this->input->getEntity($request->getParsedBody())) {

            $value = $this->input->transformFields['GroupPopUp'];
            if(!ctype_digit($value)) {
                return $this->calls->exception("Wrong Input, only Numerical String allowed");
            }
            else {
                return $this->calls->fgroup($this->link . $value . "?fields=cover,description,name,privacy,updated_time&" . $this->config->getAccessToken());
            }
        }
        else {
            return $this->calls->exception($this->invalid);
        }
    }

    /**
     * @param Request $request
     * @return string
     */
    public function getEmailGroup(Request $request){

        if($this->input->getEntity($request->getParsedBody())) {

            $value =$this->input->additionalFields;
            $id = $value['GroupID'];

            return  $this->calls->femail($this->link.$id.'?fields=email&'.$this->config->getAccessToken());
        }
        else {
            return $this->calls->exception($this->invalid);
        }
    }

    /**
     * @param Request $request
     * @return string
     */
    public function getFeed(Request $request){

        if ($this->input->getEntity($request->getParsedBody())) {

            $value = $this->input->additionalFields;
            $id = $value['GroupID'];
            $startpoint = $this->input->transformFields['FeedStartpoint'];
            $limit = $this->input->transformFields['FeedLimit'];

            if (!ctype_digit($startpoint) || !ctype_digit($limit)) {

                return $this->calls->exception("Wrong Input, only Numerical String allowed");

            } else {
                return $this->calls->ffeed($this->link . $id . '/feed?fields=from,message,created_time&limit='.$limit.'&offset='.$startpoint.'&' . $this->config->getAccessToken());
            }
        } else {
            return $this->calls->exception($this->invalid);
            }
        }

    /**
     * @param Request $request
     * @return string
     */
    public function getMemberList(Request $request){

        if ($this->input->getEntity($request->getParsedBody())) {

            $value = $this->input->additionalFields;
            $id = $value['GroupID'];
            $startpoint = $this->input->transformFields['MemberStartpoint'];
            $limit = $this->input->transformFields['MemberLimit'];

            if(!ctype_digit($startpoint) || !ctype_digit($limit))
            {
                return $this->calls->exception("Wrong Input, only Numerical Strings allowed");

            } else {
                return $this->calls->fmember($this->link . $id . "/members?fields=last_name,first_name,picture&limit=" . $limit . "&offset=" . $startpoint . "&" . $this->config->getAccessToken());
            }
        } else {
            return $this->calls->exception($this->invalid);
        }
    }
}


