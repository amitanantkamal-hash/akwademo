<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;

trait SendWhatsAppNotification
{
    public function sendWhatsAppNotification($phone_number, $name, $plan_name, $plan_period, $plan_expire): bool
    {
        $cleanedPhoneString = preg_replace('/[^A-Za-z0-9]/', '', $phone_number);
        $phone_number = $cleanedPhoneString;

        try {
            // Assuming $phone_number, $plan_name, $plan_period, $plan_expire are defined elsewhere
            $app_name = env('APP_NAME', 'Anantkamal Wademo');
            $app_legal_name = env('BUSINESS_LEGAL_NAME', 'Anantkamal Wademo');
            $plan_period = ucfirst($plan_period);

            if ($plan_period == 'Lifetime') {
                $plan_expire = $plan_period;
            } else {
                $plan_expire = date_format($plan_expire, 'd M Y');
            }
            $url = 'https://app.dotflo.io/api/wpbox/sendtemplatemessage';

            // $textToCheck =  "Hola $name! Gracias por confiar en $app_name. Tu plan es $plan_name ($plan_period) que expira en $plan_expire. ��Disfruta de tus beneficios! $app_legal_name";

            if ($phone_number && $app_name && $app_legal_name && $plan_name && $plan_period && $plan_expire) {
                $dataToSend = [
                    'token' => '3I6uhFOUTeGwHhf6WiMaq35zzCPa9GbEikx9VStr88c99954',
                    'phone' => $phone_number,
                    'template_name' => 'activation_notification',
                    'template_language' => 'es',
                    'components' => [
                        [
                            'type' => 'body',
                            'parameters' => [['type' => 'text', 'text' => $name], ['type' => 'text', 'text' => __($plan_name)], ['type' => 'text', 'text' => $plan_period], ['type' => 'text', 'text' => $plan_expire]],
                        ],
                    ],
                ];

                $response = Http::withHeaders([
                    'Content-Type' => 'application/json',
                ])->post($url, $dataToSend);

                $statusCode = $response->status();
                $content = json_decode($response->body(), true);

                // If the response is successful
                if ($statusCode === 200) {
                    return true;
                } else {
                    return false;
                }
            }

            return false;
        } catch (\Exception $e) {
            // Log the error message
            return false;
        }
    }

    function clean($string)
    {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

        return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
    }
}
