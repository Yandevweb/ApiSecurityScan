<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Http\Adapter\Guzzle6\Client as GuzzleAdapter;

class ControlerMail extends Controller
{
    public function  Mail(){


        $httpClient = new GuzzleAdapter(new Client());
        $sparky = new SparkPost($httpClient, [
            'key' => $key]);

        $httpClient = new GuzzleAdapter(new Client());
        $sparky = new Mailgun($httpClient 'key-f1dba9b23c15aae8e77fe79a5281f435');
        $domain = "sandbox1f83a2cb4830437293f5a9d9dfdb355a.mailgun.org";
        $result = $mgClient->sendMessage("$domain",
        array('from'    => 'Excited User <excited@samples.mailgun.org>',
        'to'      => 'Mailgun Devs <devs@mailgun.net>',
        'subject' => 'Hello',
        'text'    => 'Testing some Mailgun awesomeness!'));

       }



    }
}
