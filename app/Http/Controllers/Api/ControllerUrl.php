<?php


namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use GuzzleHttp\Client;

class ControllerUrl extends Controller
{
    /**
     * @param Request $request
    */
    public function  test (Request $request)
    {
        $url = $request->input('url');
        $firstReplace='';

        if(!(stristr($url, 'https://github.com/') === FALSE))
        {
            $firstReplace = str_replace('https://github.com/','',$url);

        }
        if(!(stristr($firstReplace, '.git') === FALSE)){
            $depot = str_replace('.git','',$firstReplace);

        }else{

            return response()->json(['error'=>'format  url incorect']);
        }

        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'https://api.github.com/repos/',
            // You can set any number of default request options.
            'timeout'  => 2.0,
            //verification certificat https
            'verify' => false]);

        $response = $client->request('GET', $depot);

        //Recuperation du code http
        $code = $response->getStatusCode();

        if($code == '404'){
            return response()->json(['error'=>'dépot inexistant'], 401);
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
                //var_dump($responseDecoded);
                return response()->json(['succes'=>'repot existant'], 202);
            }
        }
        
    }
}