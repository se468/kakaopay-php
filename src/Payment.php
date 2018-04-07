<?php
namespace se468\Kakaopay;

class Payment extends ApiResource
{
    public function restApiRequest($endpoint, $data)
    {
        try {
            $response = $this->_request(
                "POST",
                Kakaopay::$apiBaseUrl.$endpoint,
                $data
            );
            return json_decode($response->getBody());
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
    
    public function ready($data)
    {
        return $this->restApiRequest("/v1/payment/ready", $data);
    }

    public function approve($data)
    {
        return $this->restApiRequest("/v1/payment/approve", $data);
    }

    public function subscription($data)
    {
        return $this->restApiRequest("/v1/payment/subscription", $data);
    }

    public function cancel($data)
    {
        return $this->restApiRequest("/v1/payment/cancel", $data);
    }

    public function order($data)
    {
        return $this->restApiRequest("/v1/payment/order", $data);
    }

    public function inactive($data)
    {
        return $this->restApiRequest("/v1/payment/inactive", $data);
    }
}
