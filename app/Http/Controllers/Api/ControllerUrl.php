<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use DateTime;
use App\Http\Controllers\Api\ControllerTool;

class ControllerUrl extends Controller
{

    private $_path     = null;
    private $_logsPath = null;

    public function process(Request $request)
    {
        // Récupération et clonage du repo
        $tool = $this->getRepo($request);

        if (!$tool instanceof ControllerTool)
        {
            return response()->json(['status'=>'error', 'message' => $tool], 404);
        }

        // Lancement des test
        $resTest = $this->launchTest($tool);

        return response()->json(['status'=>'success', 'plugins' => $resTest], 200);
    }

    /**
     * @param Request $request
    */
    public function getRepo(Request $request)
    {
        $url = $request->input('url');
        $depot = $this->parseUrl($url);

        $response = $this->getRepoInfo($depot);

        //Recuperation du code http
        $code = $response->getStatusCode();

        if($code == '404'){
            return "Invalid repository";
        } else {
            $body = $response->getBody();
            //Passage du body en string
            $stringBody = (string) $body;
            //decode du json pour passage en array
            $responseDecoded = json_decode($stringBody,true);
            $repoName   = $responseDecoded['name'];

            //recuperation d'un boolean pour determiner si depot privé
            $isPrivate = $responseDecoded['private'];
            if($isPrivate == 'true'){
                // Erreur
                return "Private repository";
            } else {

                // Creation d'un user id à partir d'un timestamp
                $date = new DateTime();
                $tempUserId = $date->getTimeStamp();

                // Par défaut dans répertoire de l'utilisateur non authentifié
                $this->_path     = env('FREE_USER_PATH') ."/". $tempUserId ."/". $repoName;
                $this->_logsPath = env('FREE_USER_PATH') ."/". $tempUserId ."/logs";

                // Suppression du Repo si il est déjà existant
                if (is_dir($this->_path)){
                    shell_exec('rm -rf '. $this->_path);
                }
                // Clonage du repo
                $res = shell_exec("git clone --depth 1 ". $url ." ". $this->_path . " 2>&1");
                // Création du repertoire des logs si pas existant
                if (!is_dir($this->_logsPath)){
                    shell_exec("mkdir " .  $this->_logsPath);
                }

                $statusCode = 200;
                // Si il est bien cloné
                if(stristr($res, 'Cloning') !== false)
                {
                    $tool = new ControllerTool($this->_path, $repoName,  $this->_logsPath);

                    return $tool;
                } else if (stristr($res, 'fatal') !== false){
                    // Sinon erreur..
                    return $res;
                }
            }
        }
    }

    public function launchTest(ControllerTool $tool)
    {
        $results = [];
        $results['phpCa']       = $tool->toolPhpca();
        $results['phpCs']       = $tool->toolPhpCs();
        $results['phpMetrics']  = $tool->toolPhpMetrics();
        $results['testability'] = $tool->toolTestability();

        return $results;
    }

    public function parseUrl($url)
    {
        if(stristr($url, 'https://github.com/') !== false)
        {
            $url = str_replace('https://github.com/','',$url);
        }

        if(stristr($url, '.git') !== false){
            $url = str_replace('.git','',$url);
        } else {
            return null;
        }

        return $url;
    }

    public function getRepoInfo($repo)
    {
        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'https://api.github.com/repos/',
            // You can set any number of default request options.
            'timeout'  => 120.0,
            //verification certificat https
            'verify' => false]);

        $response = $client->request('GET', $repo, ['http_errors' => false]);

        return $response;
    }
}
