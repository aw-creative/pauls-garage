<?php

namespace App\Services;

//Use laravel built in HTTP Client
use Illuminate\Support\Facades\Http;

class EmailValidationService {

    public $apiKey;
    public $endpoint;
    public $token;
    public $emaildata;

    public function __construct(){

        //Get Config values from verfialia config file
        //Here we simply get an API Bearer token to us in later calls.
        //$this->credentials = config('verfifalia.credentials');

        $this->credentials = config('verifalia.credentials');
        $this->endpoint = config('verifalia.endpoint');
        $this->getToken();

    }


    public function getToken(){
        //Make a post request to the api AUTH function and retrive the access token
        $response = Http::post($this->endpoint.'auth/tokens',$this->credentials);
        $data = json_decode($response->body(),true);
        $this->token = $data['accessToken'] ?? null;
    }

    public function verify($email){
        //Only run this if we have the api turned on via env or config
        if(config('verifalia.enabled')){
        //Create the array to verify a single email.
        $entries = [
            'entries' => array(['inputData' => $email])
        ];
        $response = Http::withToken($this->token)
            ->post($this->endpoint .'email-validations' ,$entries);
            $this->emaildata = $response->body();
            //send the id of the email back for later use
            return $this->emailstatuscheck();
        }else{
            return false;
        }
    }

    public function emailstatuscheck(){
        //It takes a while to check the email so theres a disgusting sleep in here
        if(config('verifalia.enabled')){
            sleep(5);
            $id = json_decode($this->emaildata , true)['overview']['id'];
            $response = Http::withToken($this->token)->get($this->endpoint .'email-validations/'.$id);
            $data = json_decode($response->body(),true);
            if($data['entries']['data'][0]['status'] == 'Success'){
                return true;
            } else {
                return false;
            }
         } else {
            // return it as valid if we havent got the integration turned on
            return true;

        }
    }

}

?>
