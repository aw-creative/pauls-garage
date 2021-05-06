<?php
return[
    /*hardcoded for the sake of setting this up and testing for Hike
    Documentation can be found here https://verifalia.com/developers
    As this is a free Verifalia account we can disable it from here or in ther ENV file to avoid credit usage.
    */

    'enabled' => env('VERIFALIA_ENABLED' , true),
    'credentials' => [
        'username' => env('VERIFALIA_USERNAME' ,'andywade84@gmail.com'),
        'password' => env('VERIFALIA_USERNAME','@iup6H2KFRyt*.#')
    ],
    'endpoint' => env('VERIFALIA_ENDPOINT' ,'https://api.verifalia.com/v2.2/')
]

 ?>
