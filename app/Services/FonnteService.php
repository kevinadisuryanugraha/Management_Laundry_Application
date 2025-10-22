<?php

namespace App\Services;

class FonnteService
{
    public static function send($target, $message, $token)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.fonnte.com/send",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => [
                "target" => $target,
                "message" => $message,
            ],
            CURLOPT_HTTPHEADER => [
                'Authorization: b1xPrJF9HpZb6TZzPdXA',
            ],
        ]);

        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            return [
                "status" => false,
                "error" => curl_error($curl)
            ];
        }

        curl_close($curl);

        return json_decode($response, true);
    }
}
