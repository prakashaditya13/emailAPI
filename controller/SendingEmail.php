<?php

require_once('../model/Response.php');
require_once('../model/Emailresponse.php');

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    try {
        if($_SERVER['CONTENT_TYPE'] !== 'application/json'){
            $response = new Response();
            $response->setHttpStatusCode(400);
            $response->setSuccess(false);
            $response->setMessage("Content-Type header is not JSON type.");
            $response->Send();
            exit;
        }

        $rawEmailData = file_get_contents('php://input');

        if(!$JsonData = json_decode($rawEmailData)){
            $response = new Response();
            $response->setHttpStatusCode(400);
            $response->setSuccess(false);
            $response->setMessage('Request Body is not Json type.');
            $response->Send();
            exit;
        }

        if(!isset($JsonData->toEmail) || !isset($JsonData->fromEmail) || !isset($JsonData->body)){
            $response = new Response();
            $response->setHttpStatusCode(400);
            $response->setSuccess(false);
            (!isset($JsonData->toEmail) ? $response->setMessage("Recipents Email is required.") : false);
            (!isset($JsonData->fromEmail) ? $response->setMessage("Sender Email is required.") : false);
            (!isset($JsonData->body) ? $response->setMessage("Body is empty.") : false);
            $response->Send();
            exit;
        }

        $EmailResponse = new Email($JsonData->toEmail, $JsonData->subject, $JsonData->body,  $JsonData->fromEmail);
        $ToEmail = $EmailResponse->getToEmail();
        $Subject = $EmailResponse->getSub();
        $Body = $EmailResponse->getBody();
        $FromEmail = "From: ".$EmailResponse->getFromEmail();

        if(mail($ToEmail, $Subject, $Body, $FromEmail)){
            $response = new Response();
            $response->setHttpStatusCode(201);
            $response->setSuccess(true);
            $response->setMessage("Email Send Successfuly!");
            $response->Send();
            exit;
        }else{
            $response = new Response();
            $response->setHttpStatusCode(400);
            $response->setSuccess(false);
            $response->setMessage("Email Sending Failed!");
            $response->Send();
            exit;
        }


    } catch (Exception $e) {
        error_log("Sending Mail Error - ".$e,0);
    }
}

else{
    try {
        $response = new Response();
        $response->setHttpStatusCode(400);
        $response->setSuccess(false);
        $response->setMessage("Wrong Request Methods!!");
        $response->Send();
        exit;
    } catch (Exception $e) {
        error_log("Server Error - ".$e,0);
    }
}