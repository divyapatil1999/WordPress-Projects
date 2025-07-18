<?php

class My_API_Handler {

    public function send_user_to_api($data) {
        $url = 'https://webhook.site/e7bcaaba-8ce9-451b-ae09-b591265fa69b'; // API endpoint

        $response = wp_remote_post($url, [
            'headers' => ['Content-Type' => 'application/json'],
            'body'    => json_encode($data),
            'timeout' => 15,
        ]);

        if (is_wp_error($response)) {
            error_log('API Error: ' . $response->get_error_message());
        } else {
            $status = wp_remote_retrieve_response_code($response);
            $body   = wp_remote_retrieve_body($response);
            error_log("API Response [$status]: $body");
        }
    }
}
