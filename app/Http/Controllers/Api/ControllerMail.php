<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mail;


class ControllerMail extends Controller
{

    public function sendEmail(Request $request)
    {
        $data = array(
            'name' => "app-secure-scan"
        );
        $emails = $request->input('emails');
        $idfile= $request ->input('id');
        //$emails = ['enfoux.kevin@gmail.com', 'gnorvene@gmail.com', 'gregory.norvene@laposte.net', 'yannick.jeanjean.pro@gmail.com'];


        //TODO Recupere le chemin de chaque fichier et les ajoute dans un array

        $pathToFile= ["/logs/testPhpcs.txt","/logs/testPhpca.txt","/testPhpMetrics.txt","/testPhpMetrics.txt","/logs/testAbility.txt"];


        try
        {
            Mail::send('emails.welcome', $data, function ($message) use ($emails, $data, $pathToFile,$idfile)
            {
                $message->from(env('MAIL_USERNAME'), 'result php');
                $message->to($emails)->subject('Report  test');

                //Parcourt le tableau pour générer chaque pièce jointe
                foreach($pathToFile as  $path)
                {
                    $file = env('FREE_USER_PATH').'/'.$idfile.$path;
                        if(is_file($file))
                        {
                            $message->attach($file);
                        }
                }

            });
            return response()->json(['status' => 'success', 'return' => "Your email has been sent successfully"]);
        } catch (\Exception $e)
            {
                ($e->getMessage());
            }



    }

}
