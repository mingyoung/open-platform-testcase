<?php

namespace EasyWeChatComposer\OpenPlatformTestcase;

class ApiTextMessageCase
{
    public $authCode;
    public $openid;

    public function __construct($authCode, $openid)
    {
        $this->authCode = $authCode;
        $this->openid = $openid;
    }
}
