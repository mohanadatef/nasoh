<?php

namespace Modules\Acl\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

trait otpTrait
{
    public function sendOTP($to = '966592031195')
    {
        //APf731aa7b18554128b8c1d696c89fcbc8
        //eyJhbGciOiJIUzI1NiJ9.eyJzZXJ2aWNlX2lkIjoiQVBmNzMxYWE3YjE4NTU0MTI4YjhjMWQ2OTZjODlmY2JjOCJ9.NtKYOUXuT1Aa3MByKJk7DlZ59WDBT32gpAWTh2Ia-Rw
        try {
            $client = new Client();//ask
            $response = $client->post('https://authenticate.cloud.api.unifonic.com/services/api/v2/verifications/start', [
                'json' => [
                    'to' => '+'.$to,
                    'channel' => 'sms',
                    'length' => 4,
                    'locale' => 'en'
                ],
                'headers' => [
                    'Accept' => 'application/json',
                    'x-authenticate-app-id' => getSetting('otp_app_id')->value ,
                    'Authorization' => getSetting('otp_Authorization')->value
                    ],
            ]);


                return true;
        } catch (RequestException $e) {
            return false;
        }

    }

    public function checkOTP($to = '966592031195',$code)
    {

        //APf731aa7b18554128b8c1d696c89fcbc8
        //eyJhbGciOiJIUzI1NiJ9.eyJzZXJ2aWNlX2lkIjoiQVBmNzMxYWE3YjE4NTU0MTI4YjhjMWQ2OTZjODlmY2JjOCJ9.NtKYOUXuT1Aa3MByKJk7DlZ59WDBT32gpAWTh2Ia-Rw
        try {
            $client = new Client();//ask
            $response = $client->post('https://authenticate.cloud.api.unifonic.com/services/api/v2/verifications/check', [
                'json' => [
                    'to' => '+'.$to,
                    'channel' => 'sms',
                    'code' => $code,
                    'locale' => 'en'
                ],
                'headers' => [
                    'Accept' => 'application/json',
                    'x-authenticate-app-id' => getSetting('otp_app_id')->value ,
                    'Authorization' => getSetting('otp_Authorization')->value
                    ],
            ]);
            $data=json_decode($response->getBody(),true);
            return  $data['response_status'];
        } catch (RequestException $e) {
            return false;
        }

    }
}

