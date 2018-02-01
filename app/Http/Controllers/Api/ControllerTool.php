<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;


class ControllerTool extends Controller
{

    public function toolphpca(){
        $request="test";

        //verification  existance du  repertoire
        $path = env('REPOSITORIES_PATH') ."/". $request;
        //var_dump($path);die;

        if (is_dir($path)){
            //lancement du test
           $res = shell_exec('phpca --no-progress '. $path. " 2>&1");
          $filename= $path."/testphpca.txt";
          file_put_contents($filename,$res);

        }


        return response()->json(['status'=>'success', 'return' => $res]);
    }


    public function toolPhpCs(){
        $request="TM-Laravel";

        //path  to project
        chdir('../tmp');
        $projectPath = getcwd();

        //path de l'analyseur
        $path = env('PHPCS_PATH');


        if (is_dir($projectPath.'/'.$request)){
            //lancement du test
            $res = shell_exec($path.'phpcs '.$request);
            $filename = $projectPath."/testphpca.txt";
            file_put_contents($filename,$res);
        }

        return response()->json(['status'=>'success', 'return' => $res]);
    }


    public function toolPhpMetrics(){
        $request="TM-Laravel";

        //path  to project
        chdir('../tmp');
        $projectPath = getcwd();

        //path de l'analyseur
        $path = env('PHPCS_PATH');


        if (is_dir($projectPath.'/'.$request)){
            //lancement du test
            $res = shell_exec($path.'phpmetrics --report-html='.$projectPath.' '.$request);
            $filename = $projectPath."/testphpmetrics.txt";
            file_put_contents($filename,$res);
        }

        return response()->json(['status'=>'success', 'return' => $res]);
    }






}
