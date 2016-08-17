<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 23.06.2016
 * Time: 16:20
 */

//facebook routes
$app->post('/facebook/memberlist','facebook:getMemberList');
$app->post('/facebook/group','facebook:getGroup');
$app->post('/facebook/group/mail','facebook:getEmailGroup');
$app->post('/facebook/group/feed','facebook:getFeed');

//google routes
$app->post('/google/person/find','google:findPerson');
$app->post('/google/person/information','google:getInformation');
$app->post('/google/person/organization','google:getOrganizations');
$app->post('/google/person/place','google:getPlaces');
$app->post('/google/person/url','google:getUrls');

