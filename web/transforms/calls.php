<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 23.06.2016
 * Time: 16:12
 */
namespace mpoellath\sociallinks\transforms;
use mpoellath\sociallinks\maltego\MaltegoEntity;
use mpoellath\sociallinks\maltego\MaltegoTransform;
use mpoellath\sociallinks\config\Send;

class Calls{

    private $entity;
    private $transform;
    private $request;

    /**
     * Calls constructor.
     * @param MaltegoEntity $entity
     * @param MaltegoTransform $transform
     * @param Send $request
     */
    public function __construct(MaltegoEntity $entity ,MaltegoTransform $transform,Send $request){

        $this->entity = $entity;
        $this->transform = $transform;
        $this->request = $request;
    }

    /**
     * @param $url
     * @return string
     */
    public function fgroup($url){

        $result = $this->request->response($url);
        $output= "";

        if ($result->error != NULL) {

            return $this->exception("" . $result->error->message . " + " . $result->error->type);

        } else {

            $string = str_replace("&", "", $result->name);
            $this->entity->MaltegoEntity("michaelpoellath.FacebookGroup",$string);

            $this->entity->setDisplayInformation("Click <a
                    href=\"https://www.facebook.com/" . $result->id . "\">here</a> to get more Information about the Group.\n" . "\n!!!DISCRIPTION:" . $result->description . "!!!");
            $this->entity->setIconURL("http://graph.facebook.com/" . $result->cover->id . "/picture");
            $this->entity->addAdditionalFields("GroupID", "Group ID", "false", $result->id);
            $this->entity->addAdditionalFields("privacy", "Group Privacy", false, $result->privacy);
            $this->entity->addAdditionalFields("update", "Update Time", false, $result->updated_time);
            $output .= $this->entity->returnEntity();

            return $this->output($output);
        }
    }

    /**
     * @param $url
     * @return string
     */
    public function femail($url){

        $result = $this->request->response($url);
        $output ="";
        if ($result->error != NULL) {

            return $this->exception("" . $result->error->message . " + " . $result->error->type);

        } else {

            $this->entity->MaltegoEntity("maltego.EmailAddress", $result->email);
            $output .= $this->entity->returnEntity();
            return $this->output($output);
        }
    }

    public function ffeed($url){

        $result = $this->request->response($url);
        $output = "";
        if ($result->error != NULL) {

            return $this->exception("" . $result->error->message . " + " . $result->error->type);

        } else {
            foreach ($result->data as $item) {

                $this->entity->MaltegoEntity("michaelpoellath.FacebookFeed", $item->from->name);
                $this->entity->setDisplayInformation("Click <a
                    href=\"https://www.facebook.com/" . $item->id . "\">here</a> to get more Information about Feed. Message::".$item->message);
                $this->entity->addAdditionalFields("ID","ID",false,$item->from->id);
                $this->entity->addAdditionalFields("createdtime","Created Time",false,$item->created_time);

                $output.=$this->entity->returnEntity();
            }
            return $this->output($output);
        }
    }

    public function fmember($url)
    {
        $data = $this->request->response($url);
        $output="";

        if ($data->error != NULL) {

            return $this->exception("" . $data->error->message . " + " . $data->error->type);

        } else {

            foreach ($data->data as $item) {

                $name = "" . $item->first_name . " " . $item->last_name;
                $this->entity->MaltegoEntity("michaelpoellath.FacebookPerson", $name);

                $this->entity->setDisplayInformation("Click <a
                    href=\"https://www.facebook.com/" . $item->id . "\">here</a> to get more Information about the Person. The ID=" . $item->id . "");
                $this->entity->setIconURL("http://graph.facebook.com/" . $item->id . "/picture");

                $this->entity->addAdditionalFields("person.firstnames", "First Names", false, $item->first_name);
                $this->entity->addAdditionalFields("person.lastname", "Surname", false, $item->last_name);
                $this->entity->addAdditionalFields("ID", "ID", false, $item->id);
                $output.=$this->entity->returnEntity();
            }

            return $this->output($output);
        }
    }

    public function gpersonByName($url,$id,$key){

        $output = "";
        $result = $this->request->response($url);

        if($result->error != NULL){
            return $this->exception("Error:".$result->error->code." with message ".$result->error->message);
        }
        else{

            foreach($result->items as $item){

                $this->entity->MaltegoEntity("michaelpoellath.GoogleResult",$item->etag);
                $this->entity->setDisplayInformation("Click <a
                    href=\"".$item->url. "\">here</a> to get more Information about the Person\n");
                $this->entity->setIconURL($item->image->url);
                $this->entity->addAdditionalFields("id","ID",false,$item->id);
                $string = str_replace("&", "",$item->displayName);

                $this->entity->addAdditionalFields("name","Name",false,$string);
                $output .=  $this->entity->returnEntity();

            }
            if($result->nextPageToken !=""){

                $output.=$this->gpersonByName("https://www.googleapis.com/plus/v1/people?query=".$id."&pageToken=".$result->nextPageToken."&maxResults=50&key=".$key,$id,$key);
            }
            return $this->output($output);
        }
    }

    /**
     * @param $url
     * @return string
     */
    public function gpersonById($url){

        $result = $this->request->response($url);
        $output = "";

        if($result->error != NULL){
            return $this->exception("Error:".$result->error->code." with message ".$result->error->message);
        }
        else{

            $this->entity->MaltegoEntity("michaelpoellath.GooglePerson",$result->etag);
            $this->entity->setDisplayInformation("Click <a
                    href=\"".$result->url. "\">here</a> to get more Information about the Person.\n About Me:".$result->aboutMe."\n");

            $this->entity->setIconURL($result->image->url);
            $this->entity->addAdditionalFields("person.firstnames", "First Names", false, $result->name->givenName);
            $this->entity->addAdditionalFields("person.lastname", "Surname", false, $result->name->familyName);
            $this->entity->addAdditionalFields("gender","Gender",false,$result->gender);
            $this->entity->addAdditionalFields("id","ID",false,$result->id);

            $string = str_replace("&", "",$result->displayName);
            $this->entity->addAdditionalFields("displayname","Display Name",false,$string);
            $this->entity->addAdditionalFields("occupation","Occupation",false,$result->occupation);
            $this->entity->addAdditionalFields("circledByCount","Circled",false,intval($result->circledByCount));
            $output .= $this->entity->returnEntity();

            return $this->output($output);
        }
    }

    /**
     * @param $url
     * @return string
     */
    public function gorganizations($url){

        $result = $this->request->response($url);
        $output="";

        if($result->error != NULL){
            return $this->exception("Error:".$result->error->code." with message ".$result->error->message);
        }
        else{

            foreach ($result->organizations as $item) {

                $this->entity->MaltegoEntity("michaelpoellath.GoogleOrganizations",$item->name);
                $this->entity->setDisplayInformation($item->description);
                $this->entity->addAdditionalFields("title","Title",false,$item->title);
                $this->entity->addAdditionalFields("type","Type",false,$item->type);
                $this->entity->addAdditionalFields("startDate","Start Date",false,$item->startDate);
                $this->entity->addAdditionalFields("endDate","End Date",false,$item->endDate);
                if($item->primary == false){
                    $this->entity->addAdditionalFields("primary","Primary",false,false);
                }else{
                    $this->entity->addAdditionalFields("primary","Primary",false,true);
                }

                $this->entity->addAdditionalFields("department","Department",false,$item->department);
                $this->entity->addAdditionalFields("location","Location",false,$item->location);
                $output .= $this->entity->returnEntity();
            }

            return $this->output($output);
        }
    }

    /**
     * @param $url
     * @return string
     */
    public function gplaces($url){

        $result = $this->request->response($url);
        $output ="";

        if($result->error != NULL){
            return $this->exception("Error:".$result->error->code." with message ".$result->error->message);
        }
        else{

            foreach ($result->placesLived as $item) {

                $this->entity->MaltegoEntity("michaelpoellath.GooglePlaces",$item->value);
                if($item->primary == false){

                    $this->entity->addAdditionalFields("primary","Primary",false,false);

                }else{

                    $this->entity->addAdditionalFields("primary","Primary",false,true);
                }
                $output .= $this->entity->returnEntity();
            }
            return $this->output($output);
        }
    }

    /**
     * @param $url
     * @return string
     */
    public function gurls($url){

        $result = $this->request->response($url);
        $output ="";

        if($result->error != NULL){
            return $this->exception("Error:".$result->error->code." with message ".$result->error->message);
        }
        else{

            foreach($result->urls as $item){

                $this->entity->MaltegoEntity("maltego.URL",$item->label);
                $this->entity->setDisplayInformation("Click <a
                    href=\"".$item->value. "\">here</a> to get more Information about the Website.");
                $this->entity->addAdditionalFields("url","URL",false,$item->value);
                $output.= $this->entity->returnEntity();

            }
            return $this->output($output);
        }
    }


    /**
     * @param $message
     * @return string
     */
    public function exception($message){

        $this->transform->addException($message);
        return $this->transform->throwExceptions();
    }


    /**
     * @param $entities
     * @return string
     */
    public function output($entities){

        $output = "<MaltegoMessage>\n";
        $output .= "<MaltegoTransformResponseMessage>\n";
        $output .="<Entities>\n";
        $output.=   $entities;
        $output .="</Entities>\n";

        $output .="<UIMessages>\n";

        $output .="</UIMessages>\n";

        $output .= "</MaltegoTransformResponseMessage>\n";
        $output .= "</MaltegoMessage>\n";
        return $output;
    }
}







