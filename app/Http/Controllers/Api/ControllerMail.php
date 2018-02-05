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
        'name' => "app-secure-scan");
        $emails = ['enfoux.kevin@gmail.com','gnorvene@gmail.com','gregory.norvene@laposte.net','yannick.jeanjean.pro@gmail.com'];
        try
        {

            Mail::send('emails.welcome', $data, function ($message)use ($emails, $data) {
            $message->from('gnorvene2@gmail.com', 'result php');
            $message->to($emails)->subject('Report  test');
               
            });
        }
        catch (\Exception $e)
        {
            dd($e->getMessage());
        }
            return response()->json(['status'=>'success', 'return' => "Your email has been sent successfully"]);

    }


}
