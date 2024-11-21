<?php

namespace RaRashed\PayplusSdk;

class Payplus
{
    protected $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Process Payment Request
     *
     * @param array $data
     * @return string|array
     */
    public function processPayment(array $data)
    {
        $jsonData = json_encode($data);
        $url = $this->config['payment_url'];

        $options = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $jsonData,
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "Authorization: {\"api_key\":\"" . $this->config['api_key'] . "\",\"secret_key\":\"" . $this->config['secret_key'] . "\"}"
            )
        );

        $ch = curl_init();
        curl_setopt_array($ch, $options);
        $response = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($response, true);
        if (isset($result['results']) && $result['results']['status'] === 'success') {
            return $result['data']['payment_page_link'];
        }

        return ['status' => 'error', 'response' => $result];
    }
}
