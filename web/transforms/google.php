<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 22.06.2016
 * Time: 13:58
 */
namespace mpoellath\sociallinks\transforms;

use mpoellath\sociallinks\maltego\MaltegoTransformInput;
use mpoellath\sociallinks\config\Config;
use Psr\Http\Message\ServerRequestInterface as Request;


class Google{

    private $calls;
    private $input;
    private $config;
    private $link = "https://www.googleapis.com/plus/v1/people";
    private $invalid = "No Valid Input!";

    /**
     * Google constructor.
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
    public function findPerson(Request $request){

        if($this->input->getEntity($request->getParsedBody())) {

            $value = $this->input->transformFields['GooglePoPUp'];
            if(ctype_digit($value)){
                //do the find person
                return $this->calls->gpersonById($this->link."/".$value."?key=".$this->config->getGooglekey());
            }
            else{
                //do the search all names
                $value = str_replace(" ","+",$value);
                return $this->calls->gpersonByName($this->link."?query=".$value."&maxResults=50&key=".$this->config->getGooglekey(),$value,$this->config->getGooglekey());
            }
        } else{
            return $this->calls->exception($this->invalid);
        }
    }

    /**
     * @param Request $request
     * @return string
     */
    public function getInformation(Request $request){

        if ($this->input->getEntity($request->getParsedBody())) {

            $value = $this->input->additionalFields;
            $id = $value['id'];

            return $this->calls->gpersonById($this->link."/" . $id . "?key=" . $this->config->getGooglekey());
        }
        else {
            return  $this->calls->exception($this->invalid);
        }
    }

    /**
     * @param Request $request
     * @return string
     */
    public function getOrganizations(Request $request){

        if ($this->input->getEntity($request->getParsedBody())) {

            $value = $this->input->additionalFields;
            $id = $value['id'];

            return $this->calls->gorganizations($this->link."/".$id."?key=".$this->config->getGooglekey());

        }else{
            return $this->calls->exception($this->invalid);
        }
    }

    /**
     * @param Request $request
     * @return string
     */
    public function getPlaces(Request $request){

        if ($this->input->getEntity($request->getParsedBody())) {

            $value = $this->input->additionalFields;
            $id = $value['id'];

            return $this->calls->gplaces($this->link."/".$id."?key=".$this->config->getGooglekey());


        }else{
            return $this->calls->exception($this->invalid);
        }
    }

    /**
     * @param Request $request
     * @return string
     */
    public function getUrls(Request $request){

        if($this->input->getEntity($request->getParsedBody())){

            $value = $this->input->additionalFields;
            $id = $value['id'];

            return $this->calls->gurls($this->link."/".$id."?key=".$this->config->getGooglekey());

        }else{
            return $this->calls->exception($this->invalid);
        }
    }
}

