<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;


class ControllerTool extends Controller
{

    public function toolphpca(){
        $request="TM-Laravel";

        //path  to project
        chdir('../tmp');
        $projectPath = getcwd();

        //path de l'analyseur
        $path = env('VENDOR_BIN_PATH'); //../vendor/bin

//        if (is_dir($path)){
//            //lancement du test
//           $res = shell_exec('phpca --no-progress '. $path. " 2>&1");
//          $filename= $path."/testphpca.txt";
//          file_put_contents($filename,$res);
//        }

        if (is_dir($projectPath.'/'.$request)){
            //lancement du test
            $res = shell_exec($path.'phpca --no-progress '.$request.' 2>&1');
            $filename = $projectPath."/testphpca.txt";
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
        $path = env('VENDOR_BIN_PATH');//../vendor/bin


        if (is_dir($projectPath.'/'.$request)){
            //lancement du test
            $res = shell_exec($path.'phpcs '.$request);
            $filename = $projectPath."/testphpcs.txt";
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
        $path = env('VENDOR_BIN_PATH');//../vendor/bin


        if (is_dir($projectPath.'/'.$request)){
            //lancement du test
            $res = shell_exec($path.'phpmetrics --report-html='.$projectPath.'/phpmetrics '.$request);
            $filename = $projectPath."/testphpmetrics.txt";
            file_put_contents($filename,$res);
        }

        return response()->json(['status'=>'success', 'return' => $res]);
    }


    public function testability(){
        $request="TM-Laravel";

        //path  to project
        chdir('../tmp');
        $projectPath = getcwd();

        //path de l'analyseur
        $path = env('VENDOR_BIN_PATH');//../vendor/bin


        if (is_dir($projectPath.'/'.$request)){
            //lancement du test
            $res = shell_exec($path.'testability '.$request.' -o testability');
            $filename = $projectPath."/testability.txt";
            file_put_contents($filename,$res);
        }

        return response()->json(['status'=>'success', 'return' => $res]);
    }

}
