<?php
/**
 * Simple Stripe API Client for CafeConnect
 * Minimal implementation for Payment Intents
 */

class StripeAPI {
    private static $apiKey;
    
    public static function setApiKey($key) {
        self::$apiKey = $key;
    }
    
    public static function createPaymentIntent($data) {
        $url = 'https://api.stripe.com/v1/payment_intents';
        
        $postData = http_build_query($data);
        
        $context = stream_context_create([
            'http' => [
                'method' => 'POST',
                'header' => [
                    'Authorization: Bearer ' . self::$apiKey,
                    'Content-Type: application/x-www-form-urlencoded'
                ],
                'content' => $postData
            ]
        ]);
        
        $response = file_get_contents($url, false, $context);
        return json_decode($response, true);
    }
    
    public static function retrievePaymentIntent($id) {
        $url = 'https://api.stripe.com/v1/payment_intents/' . $id;
        
        $context = stream_context_create([
            'http' => [
                'method' => 'GET',
                'header' => [
                    'Authorization: Bearer ' . self::$apiKey
                ]
            ]
        ]);
        
        $response = file_get_contents($url, false, $context);
        return json_decode($response, true);
    }
    
    public static function confirmPaymentIntent($id, $data) {
        $url = 'https://api.stripe.com/v1/payment_intents/' . $id . '/confirm';
        
        $postData = http_build_query($data);
        
        $context = stream_context_create([
            'http' => [
                'method' => 'POST',
                'header' => [
                    'Authorization: Bearer ' . self::$apiKey,
                    'Content-Type: application/x-www-form-urlencoded'
                ],
                'content' => $postData
            ]
        ]);
        
        $response = file_get_contents($url, false, $context);
        return json_decode($response, true);
    }
}
?>