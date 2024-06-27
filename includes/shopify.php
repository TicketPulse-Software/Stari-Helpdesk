<?php
use GuzzleHttp\Client;

function get_shopify_access_token($shop, $code) {
    $client = new Client();
    $response = $client->post("https://{$shop}/admin/oauth/access_token", [
        'form_params' => [
            'client_id' => SHOPIFY_API_KEY,
            'client_secret' => SHOPIFY_API_SECRET,
            'code' => $code,
        ]
    ]);

    $data = json_decode($response->getBody(), true);
    return $data['access_token'] ?? null;
}

function shopify_api_request($shop, $access_token, $endpoint, $method = 'GET', $body = []) {
    $client = new Client();
    $options = [
        'headers' => [
            'X-Shopify-Access-Token' => $access_token,
            'Content-Type' => 'application/json',
        ]
    ];

    if ($method === 'POST' && !empty($body)) {
        $options['json'] = $body;
    }

    $response = $client->request($method, "https://{$shop}/admin/api/2023-04/{$endpoint}", $options);
    return json_decode($response->getBody(), true);
}
?>
