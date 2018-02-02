<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use DateTime;
use App\Http\Controllers\Api\ControllerTool;

class ControllerUrl extends Controller
{

    /**
     * @param Request $request
    */
    public function  test (Request $request)
    {
        $url = $request->input('url');
        $depot = $url;
        if(stristr($depot, 'https://github.com/') !== false)
        {
            $depot = str_replace('https://github.com/','',$depot);
        }

        if(stristr($depot, '.git') !== false){
            $depot = str_replace('.git','',$depot);
        } else {
            return response()->json(['error'=>'format url incorrect']);
        }

        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'https://api.github.com/repos/',
            // You can set any number of default request options.
            'timeout'  => 120.0,
            //verification certificat https
            'verify' => false]);

        $response = $client->request('GET', $depot, ['http_errors' => false]);

        //Recuperation du code http
        $code = $response->getStatusCode();

        if($code == '404'){
            return response()->json(['error'=>'dépot inexistant'], 404);
        } else {
            $body = $response->getBody();
            //Passage du body en string
            $stringBody = (string) $body;
            //decode du json pour passage en array
            $responseDecoded = json_decode($stringBody,true);
            $repoName   = $responseDecoded['name'];
            $ownerLogin = $responseDecoded['owner']['login'];

            //recuperation d'un boolean pour determiner si depot privé
            $isPrivate = $responseDecoded['private'];
            if($isPrivate == 'true'){
                var_dump($responseDecoded['private']);
            } else {

                // Creation d'un user id à partir d'un timestamp
                $date = new DateTime();
                $tempUserId = $date->getTimeStamp();

                // Par défaut dans répertoire de l'utilisateur non authentifié
                $path = env('FREE_USER_PATH') ."/". $tempUserId ."/". $repoName;
                // Suppression du Repo si il est déjà existant
                if (is_dir($path)){
                    shell_exec('rm -rf '. $path);
                }
                // Clonage du repo
                $res = shell_exec("git clone --depth 1 ". $url ." ". $path . " 2>&1");

                $statusCode = 200;
                // Si il est bien cloné
                if(stristr($res, 'Cloning') !== false)
                {
                    $tool = new ControllerTool($path, $repoName);
                    $res = $this->launchTest($tool);


                    return response()->json(['status'=>'success', 'return' => $res], $statusCode);
                } else if (stristr($res, 'fatal') !== false){
                    // Sinon erreur..
                    $statusCode = 404;
                    return response()->json(['status'=>'error', 'return' => $res], $statusCode);
                }
            }
        }
    }

    public function launchTest(ControllerTool $tool)
    {

        $res = $tool->toolPhpca();

        return $res;
    }
}
