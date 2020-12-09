<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    
    'github' => [
        'client_id' => '55309d2f1a05c8eff07b', // Your GitHub Client ID
        'client_secret' =>'71c66f431e6d5ce44b60dff01cf2210ae558be49', // Your GitHub Client Secret
        'redirect' => 'http://localhost:8000/auth/github/callback',
    ],

    'facebook'=>[
         'client_id'=>'685363235594229',
         'client_secret'=>'a4f70338106bf32b6325a3692bf89282',
         'redirect'=>'http://localhost:8000/auth/facebook/callback'
    ],
    
    'google' => [
        'client_id'     => '1035413712911-f8c7964cm51kr60v4v0n6ceshoqnoilb.apps.googleusercontent.com',
        'client_secret' => 'T0Pitjs3LAy-kGAw6zvRVm02',
        'redirect'      => 'http://localhost:8000/auth/google/callback'
    ],


];
