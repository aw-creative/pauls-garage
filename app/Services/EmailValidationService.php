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

        //Get Config values from dvla.php config file
        $this->credentials = [
            'username' => 'andywade84@gmail.com',
            'password' => '@iup6H2KFRyt*.#'
    ];
        $this->endpoint = config('verifalia.endpoint');
        $this->getToken();
    }


    public function getToken(){
        $response = Http::post($this->endpoint.'auth/tokens',$this->credentials);
        $data = json_decode($response->body(),true);
        $this->token = $data['accessToken'];
    }

    public function verify($email){

        //Create the array to verify a single email.
        $entries = [
            'entries' => array(['inputData' => $email])
        ];
        $response = Http::withToken($this->token)
            ->post($this->endpoint .'email-validations' ,$entries);
        $this->emaildata = $response->body();
        print_r(json_decode($this->emaildata , true));
        return $this->emailstatuscheck();
    }

    public function emailstatuscheck(){
        sleep(10);
        $id = json_decode($this->emaildata , true)['overview']['id'];
        $response = Http::withToken($this->token)->get($this->endpoint .'email-validations/'.$id);
        $data = json_decode($response->body(),true);
        if($data['entries']['data'][0]['status'] == 'Success'){
            return true;
     } else {
            return false;
        }
    }

}

?>
