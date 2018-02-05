<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mail;


class ControllerMail extends Controller
{

    public function sendEmail()
    {
        $data = array(
            'name' => "app-secure-scan"
        );

        $emails = ['enfoux.kevin@gmail.com', 'gnorvene@gmail.com', 'gregory.norvene@laposte.net', 'yannick.jeanjean.pro@gmail.com'];
        chdir('../tmp');
        $projectPath = getcwd();

        //TODO Recupere le chemin de chaque fichier et les ajoute dans un array
        $requestA = "test/testphpca.txt";
        $requestB = "test/testphpcaf.txt";
        $pathToFileA = $projectPath . '/' . $requestA;
        $pathToFileB = $projectPath . '/' . $requestB;

        $pathToFile = [
            $pathToFileA,
            $pathToFileB,
        ];

        try {
            Mail::send('emails.welcome', $data, function ($message) use ($emails, $data, $pathToFile) {
                $message->from(env('MAIL_USERNAME'), 'result php');
                $message->to($emails)->subject('Report  test');

                //Parcourt le tableau pour générer chaque pièce jointe
                foreach($pathToFile as  $path){
                    $message->attach($path);
                }
            });

        } catch (\Exception $e) {
            ($e->getMessage());
        }

        return response()->json(['status' => 'success', 'return' => "Your email has been sent successfully"]);

    }

}
