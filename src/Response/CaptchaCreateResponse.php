<?php

namespace Ixolit\Dislo\Response;

/**
 * Class CaptchaCreateResponse
 * @package Ixolit\Dislo\Response
 */
class CaptchaCreateResponse {

    /**
     * Additional data returned by the API
     * @var array
     */
    private $data = [];

    /**
     * CaptchaVerifyResponse constructor.
     * @param array $data
     */
    public function __construct( $data = [] ) {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param string $key
     * @param mixed|null $default
     * @return mixed|null
     */
    public function getDataValue($key, $default=null) {
        if (array_key_exists($key, $this->data)) {
            return $this->data[$key];
        }
        return $default;
    }

    /**
     * @param $response
     * @param $couponCode
     * @param $event
     * @return CouponCodeValidateResponse
     */
    public static function fromResponse($response) {
		return new CaptchaCreateResponse(
			!empty($response['data']) ? $response['data'] : []
		);
	}

}