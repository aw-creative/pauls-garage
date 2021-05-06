<?php

namespace App\Services;

//Use laravel built in HTTP Client
use Illuminate\Support\Facades\Http;

class VehicleSearchService {

    public $apiKey;
    public $endpoint;

    public function __construct(){

        //Get Config values from dvla.php config file

        $this->apikey = config('dvla.apikey');
        $this->endpoint = config('dvla.endpoint');
    }

    public function search($reg){

        //Make HTTP Post request to DVLA Vehicle database

        $response = Http::withHeaders([
            'x-api-key' => $this->apikey,
        ])->post($this->endpoint , [
            'registrationNumber' => $reg
        ]);

        //Return the Response from the Database

        return $response->body();
    }

}

?>
