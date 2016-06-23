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


class Google{

    private $calls;
    private $input;
    private $config;

    public function __construct(Calls $calls, MaltegoTransformInput $input, Config $config)
    {
        $this->calls  = $calls;
        $this->input  = $input;
        $this->config = $config;

    }


    public function findPerson($request,$response){

        if($this->input->getEntity()) {

            $value = $this->input->transformFields['GooglePoPUp'];
            if(ctype_digit($value)){

                //do the find person
                return $this->calls->gpersonById("https://www.googleapis.com/plus/v1/people/".$value."?key=".$this->config->getGooglekey());

            }
            else{

                    //do the search all names
                    $value = str_replace(" ","+",$value);
                    $result = $this->calls->gpersonByName("https://www.googleapis.com/plus/v1/people?query=".$value."&maxResults=50&key=".$this->config->getGooglekey(),$value,$this->config->getGooglekey());

                    $output = "<MaltegoMessage>\n";
                    $output .= "<MaltegoTransformResponseMessage>\n";
                    $output .="<Entities>\n";
                    $output .=  $result;
                    $output .="</Entities>\n";

                    $output .="<UIMessages>\n";
                    $output .="</UIMessages>\n";

                    $output .= "</MaltegoTransformResponseMessage>\n";
                    $output .= "</MaltegoMessage>\n";

                    return $output;
                }

            }
            else{

              return  $this->calls->exception("NO Valid Input");
            }
        }

    public function getInformation($request,$response){

            if ($this->input->getEntity()) {

                $value = $this->input->additionalFields;
                $id = $value['id'];

                return $this->calls->gpersonById("https://www.googleapis.com/plus/v1/people/" . $id . "?key=" . $this->config->getGooglekey());

            }
            else{

                return  $this->calls->exception("NO Valid Input");
            }
        }

    public function getOrganizations($request,$response){

            if ($this->input->getEntity()) {

                $value = $this->input->additionalFields;
                $id = $value['id'];

                return $this->calls->gorganizations("https://www.googleapis.com/plus/v1/people/".$id."?key=".$this->config->getGooglekey());


            }else{

                return $this->calls->exception("NO Valid Input");

            }


        }

    public function getPlaces($request,$response){

            $input = new MaltegoTransformInput();

            if ($input->getEntity()) {

                $value = $input->additionalFields;
                $id = $value['id'];

                return $this->calls->gplaces("https://www.googleapis.com/plus/v1/people/".$id."?key=".$this->config->getGooglekey());


            }else{
                return $this->calls->exception("NO Valid Input");
            }
        }



}

