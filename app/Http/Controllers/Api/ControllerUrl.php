<?php


namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use GuzzleHttp\Client;

class ControllerUrl extends Controller
{
    public function  test (Request $request)
    {
        $url = $request->input('url');


        $firstReplace = str_replace('https://github.com/','',$url);
        $depot = str_replace('.git','',$firstReplace);

        var_dump($depot);



        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'https://api.github.com/repos/',
            // You can set any number of default request options.
            'timeout'  => 2.0,]);

        $response = $client->request('GET', $depot);

        //Recuperation du code http
        $code = $response->getStatusCode();

        if($code == '404'){
            echo 'fuck you';
        }
        else{
            $body = $response->getBody();
            //Passage du body en string
            $stringBody = (string) $body;
            //decode du json pour passage en array
            $responseDecoded = json_decode($stringBody,true);

            //recuperation d'un boolean pour determiner si depot privé
            $isPrivate = $responseDecoded['private'];
            if($isPrivate == 'true'){
                var_dump($responseDecoded['private']);
            }
            else{
                var_dump($responseDecoded);
            }
        }




//        return response()->$client;
    }
}