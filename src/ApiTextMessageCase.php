<?php

namespace EasyWeChatComposer\OpenPlatformTestcase;

class ApiTextMessageCase
{
    public $payload;

    public function __construct($payload)
    {
        $this->payload = $payload;
    }

    public function getAuthCode()
    {
        return str_replace('QUERY_AUTH_CODE:', '', $this->payload['Content']);
    }

    public function getOpenid()
    {
        return $this->payload['FromUserName'];
    }
}
