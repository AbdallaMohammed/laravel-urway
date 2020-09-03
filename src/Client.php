<?php

namespace URWay;

class Client extends BaseService
{
    /**
     * @var string
     */
    protected $endpoint = 'URWAYPGService/transaction/jsonProcess/JSONrequest';

    /**
     * Request method.
     * 
     * @var string
     */
    protected $method = 'POST';

    /**
     * Store request attributes.
     * 
     * @var array
     */
    protected $attributes = [
        'action' => '1', // According to the documentation the action must be 1
    ];

    /**
     * @return $this
     */
    public function setTrackId(string $trackId)
    {
        $this->attributes['trackid'] = $trackId;
        return $this;
    }

    /**
     * @return $this
     */
    public function setCustomerEmail(string $email)
    {
        $this->attributes['customerEmail'] = $email;
        return $this;
    }

    /**
     * @return $this
     */
    public function setCustomerIp($ip)
    {
        $this->attributes['merchantIp'] = $ip;
        return $this;
    }

    /**
     * @return $this
     */
    public function setCurrency(string $currency)
    {
        $this->attributes['currency'] = $currency;
        return $this;
    }

    /**
     * @return $this
     */
    public function setCountry(string $country)
    {
        $this->attributes['country'] = $country;
        return $this;
    }

    /**
     * @return $this
     */
    public function setAmount($amount)
    {
        $this->attributes['amount'] = $amount;
        return $this;
    }

    /**
     * @return $this
     */
    public function setRedirectUrl($url)
    {
        $this->attributes['udf2'] = $url;
        return $this;
    }

    /**
     * @return $this
     */
    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;
        return $this;
    }

	/**
	 * @return mixed
	 * @throws \GuzzleHttp\Exception\GuzzleException|\Exception
	 */
    public function pay()
    {
        // According to documentation we have to send the `terminal_id`, and `password` now.
        $this->attributes['terminalId'] = config('urway.auth.terminal_id');
        $this->attributes['password'] = config('urway.auth.password');

        // We have to generate request
        $this->generateRequestHash();

        try {
            $response = $this->guzzleClient->request(
                $this->method,
                $this->getEndPointPath(),
                [
                    'json' => $this->attributes,
                    'headers' => [
                        'Accept' => 'application/json',
                    ],
                ]
            );

            return json_decode((string) $response->getBody());
        } catch (\Throwable $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @return void
     */
    protected function generateRequestHash()
    {
        $this->attributes['requestHash'] = $this->attributes['trackid'] . '|' . config('urway.auth.terminal_id') . '|' . config('urway.auth.password') . '|' . config('urway.auth.merchant_key') . '|' . $this->attributes['amount'] . '|' . $this->attributes['currency'];
        $this->attributes['requestHash'] = hash('sha256', $this->attributes['requestHash']);
    }
}
