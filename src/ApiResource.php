<?php
namespace se468\Kakaopay;

use GuzzleHttp\Client;
use se468\Kakaopay\Kakaopay;

abstract class ApiResource
{
    protected function _request($method, $url, $params = [], $options = null)
    {
        $client = new Client();

        $header = null;
        if (Kakaopay::getAdminKey() != null) {
            $header = "KakaoAK ".Kakaopay::getAdminKey();
        } elseif (Kakaopay::getAccessToken() != null) {
            $header = "Bearer ".Kakaopay::getAccessToken();
        }

        if ($header == null) {
            throw new \Exception("You need to set either admin key or access token");
        }

        $res = $client->request($method, $url, [
            'headers' => [
                "Authorization" => $header
            ],
            'form_params' => $params
        ]);
        
        return $res;
    }
}
