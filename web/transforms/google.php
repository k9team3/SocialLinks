<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 22.06.2016
 * Time: 13:58
 */
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


    public function findPerson(){

        if($this->input->getEntity()) {

            $value = $this->input->transformFields['GooglePoPUp'];
            if(ctype_digit($value)){

                //do the find person
                echo $this->calls->gpersonById("https://www.googleapis.com/plus/v1/people/".$value."?key=".$this->config->getGooglekey());

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

                    echo $output;
                }

            }
            else{

              echo  $this->calls->exception("NO Valid Input");
            }
        }

    public function getInformation(){

            if ($this->input->getEntity()) {

                $value = $this->input->additionalFields;
                $id = $value['id'];

                echo $this->calls->gpersonById("https://www.googleapis.com/plus/v1/people/" . $id . "?key=" . $this->config->getGooglekey());

            }
            else{

                echo  $this->exception("NO Valid Input");
            }
        }

    public function getOrganizations(){

            if ($this->input->getEntity()) {

                $value = $this->input->additionalFields;
                $id = $value['id'];

                echo $this->calls->gorganizations("https://www.googleapis.com/plus/v1/people/".$id."?key=".$this->config->getGooglekey());


            }else{

                echo $this->calls->exception("NO Valid Input");

            }


        }

    public function getPlaces(){

            $input = new MaltegoTransformInput();

            if ($input->getEntity()) {

                $value = $input->additionalFields;
                $id = $value['id'];

                echo $this->calls->gplaces("https://www.googleapis.com/plus/v1/people/".$id."?key=".$this->config->getGooglekey());


            }else{
                echo $this->calls->exception("NO Valid Input");
            }
        }



}

