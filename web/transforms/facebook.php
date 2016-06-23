<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 08.06.2016
 * Time: 13:46
 */
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

    public function getGroup(){

        if($this->input->getEntity()) {


            $value = $this->input->transformFields['GroupPopUp'];
            if(!ctype_digit($value)) {

                echo $this->calls->exception("Wrong Input, only Numerical String allowed");
            }
            else {

                echo $this->calls->fgroup("https://graph.facebook.com/v2.6/' . $value . '?fields=cover,description,name,privacy,updated_time&" . $this->config->getAccessToken());
            }
        }
        else
        {
            echo $this->calls->exception("NO correct Input");
        }
    }


    public function getEmailGroup(){

        if($this->input->getEntity()) {

            $value =$this->input->additionalFields;
            $id = $value['GroupID'];

            echo  $this->calls->femail('https://graph.facebook.com/v2.6/'.$id.'?fields=email&'.$this->config->getAccessToken());
        }
        else {
            echo $this->$this->calls->exception("NO correct Input");

        }
    }

    public function getFeed()
    {


        if ($this->input->getEntity()) {

            $value = $this->input->additionalFields;
            $id = $value['GroupID'];
            $startpoint = $this->input->transformFields['FeedStartpoint'];
            $limit = $this->input->transformFields['FeedLimit'];


            if (!ctype_digit($startpoint) || !ctype_digit($limit)) {

                echo $this->calls->exception("Wrong Input, only Numerical String allowed");

            } else {


                    echo $this->calls->ffeed('https://graph.facebook.com/v2.6/' . $id . '/feed?fields=from,message,created_time&limit='.$limit.'&offset='.$startpoint.'&' . $this->config->getAccessToken());

                }
             }
            else
            {
                echo $this->calls->exception("NO correct Input");
            }
        }

    public function getMemberList()
    {



        if ($this->input->getEntity()) {

            $value = $this->input->additionalFields;
            $id = $value['GroupID'];
            $startpoint = $this->input->transformFields['MemberStartpoint'];
            $limit = $this->input->transformFields['MemberLimit'];

            if(!ctype_digit($startpoint) || !ctype_digit($limit))
            {
                echo $this->calls->exception("Wrong Input, only Numerical Strings allowed");

            }else {


                echo $this->calls->fmember("https://graph.facebook.com/v2.6/" . $id . "/members?fields=last_name,first_name,picture&limit=" . $limit . "&offset=" . $startpoint . "&" . $this->config->getAccessToken());
            }

        } else {

            echo $this->calls->exception("NO input entity found");
        }


    }



}


