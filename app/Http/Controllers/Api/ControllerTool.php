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






}
