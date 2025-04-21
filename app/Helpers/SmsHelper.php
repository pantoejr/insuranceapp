<?php

namespace App\Helpers;

use App\Models\SmsLog;
use Illuminate\Support\Facades\Auth;
use Twilio\Exceptions\ConfigurationException;
use Twilio\Rest\Client;

class SmsHelper
{
     /**
      * Send an SMS using Twilio API.
      *
      * @param string $to The recipient's phone number.
      * @param string $message The message to send.
      * @throws \Exception If there is an error sending the SMS.
      */

     public static function sendSms($to, $message)
     {
          $sid = env('TWILIO_SID');
          $token = env('TWILIO_AUTH_TOKEN');
          $from = env('TWILIO_PHONE_NUMBER');
          if (empty($sid) || empty($token) || empty($from)) {
               throw new \Exception("Twilio credentials are not set in the environment file.");
          }
          $client = new Client($sid, $token);
          if (empty($to) || empty($message)) {
               throw new \Exception("Phone number or message is empty.");
          }
          try {
               $client->messages->create(
                    $to,
                    [
                         'from' => $from,
                         'body' => $message
                    ]
               );

               SmsLog::create([
                    'phone_number' => $to,
                    'message' => $message,
                    'status' => 'sent',
                    'created_by' => 'system',
               ]);
          } catch (\Exception $e) {

               SmsLog::create([
                    'phone_number' => $to,
                    'message' => $message,
                    'status' => 'failed',
                    'created_by' => 'system',
               ]);

               throw new \Exception("Error sending SMS: " . $e->getMessage());
          }
     }
}
