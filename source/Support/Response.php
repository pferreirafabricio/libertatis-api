<?php

namespace Source\Support;

class Response
{
    /** @var array */
    private $data;

    /** @var int */
    private $httpResponseCode;

    public function __construct($data, int $httpResponseCode = 200)
    {
        $this->data = $data;
        $this->httpResponseCode = $httpResponseCode;
        return $this;
    }

    /**
     * Return the given data as JSON
     */
    public function json(): string
    {
        http_response_code($this->httpResponseCode);
        return json_encode(["data" => ($this->data ?? '')]);
    }
}
