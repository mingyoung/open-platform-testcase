<?php

namespace EasyWeChatComposer\OpenPlatformTestcase;

use EasyWeChat\Kernel\Contracts\EventHandlerInterface;
use EasyWeChat\OpenPlatform\Authorizer\OfficialAccount\Application as OfficialAccount;
use EasyWeChat\OpenPlatform\Authorizer\MiniProgram\Application as MiniProgram;

class Handler implements EventHandlerInterface
{
    public static function getAccessor()
    {
        return [OfficialAccount::class, MiniProgram::class];
    }

    public function handle(array $payload = [])
    {
        if (!in_array($payload['ToUserName'], ['gh_3c884a361561', 'gh_8dad206e9538'])) {
            return;
        }

        if ($payload['MsgType'] === 'text' && $payload['Content'] === 'TESTCOMPONENT_MSG_TYPE_TEXT') {
            return 'TESTCOMPONENT_MSG_TYPE_TEXT_callback';
        }

        if ($payload['MsgType'] === 'event') {
            return $payload['Event'].'from_callback';
        }

        if ($payload['MsgType'] === 'text' && strpos($payload['Content'], 'QUERY_AUTH_CODE:') !== false) {
            $authCode = str_replace('QUERY_AUTH_CODE:', '', $payload['Content']);

            event(new ApiTextMessageCase($authCode, $payload['FromUserName']));
        }
    }
}
