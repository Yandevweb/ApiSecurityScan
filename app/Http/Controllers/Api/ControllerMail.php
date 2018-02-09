<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mail;

class ControllerMail extends Controller
{
    public function sendEmail(Request $request, $resTest, $userId)
    {
        $data = array(
            'name' => "app-secure-scan"
        );
        $emails = $request->input('emails');

        $pathToFile = [];
        // On parse le retour des test afin de récupérer le chemin des logs
        foreach ($resTest as $logPath) {
            $pathToFile[] = $logPath['logFile'];
        }

        try
        {
            Mail::send('emails.welcome', $data, function ($message) use ($emails, $data, $pathToFile ,$userId)
            {
                $message->from('groupe6@asr.lan', 'result php');
                $message->to($emails)->subject('Report  test');
                //Parcours le tableau pour générer chaque pièce jointe
                foreach($pathToFile as  $path)
                {
                    $file = env('FREE_USER_PATH').'/'.$userId.$path;
                    if(is_file($file))
                    {
                        $message->attach($file);
                    }
                }
            });

            return response()->json(['status' => 'success', 'return' => "Your email has been sent successfully"]);
        } catch (\Exception $e) {
            ($e->getMessage());
        }

        return $e->getMessage();
    }
}
