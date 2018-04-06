<?php
namespace se468\Kakaopay;

class Payment extends ApiResource
{
    public function ready($data)
    {
        $response = $this->_request(
            "POST",
            Kakaopay::$apiBaseUrl."/v1/payment/ready",
            $data
        );

        return json_decode($response->getBody());
    }

    public function approve($data)
    {
        try {
            $response = $this->_request(
                "POST",
                Kakaopay::$apiBaseUrl."/v1/payment/approve",
                $data
            );

            return json_decode($response->getBody());
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function subscription($data)
    {
    }

    public function cancel($data)
    {
    }

    public function order($data)
    {
    }

    public function inactive($data)
    {
    }
}
