`App\Providers\EventServiceProvider`

```php
protected $listen = [
    // ...
    'EasyWeChatComposer\OpenPlatformTestcase\ApiTextMessageCase' => [
        'App\Listeners\SendCustomerServiceMessage', // 需要自己创建的 Listener
    ],
];
```

```php
<?php

namespace App\Listeners;

use EasyWeChatComposer\OpenPlatformTestcase\ApiTextMessageCase;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendCustomerServiceMessage implements ShouldQueue
{
    public function handle(ApiTextMessageCase $event)
    {
        // Event 提供以下方法：
        // 获取微信推送的内容
        $payload = $event->payload;
        // 获取授权方 auth_code
        $authCode = $event->getAuthCode();
        // 获取需要回复的 openid
        $openid = $event->getOpenid();

        // Step0: 创建 EasyWeChat 开放平台实例
        $app = app('wechat.open_platform'); // app('wechat.open_platform') 为 laravel-wechat 默认容器实例（如有必要请修改）

        // Step1: 根据 auth_code 获取授权方信息
        $info = $app->handleAuthorize($authCode);

        // Step2: 创建授权方实例，调用发送客服消息接口
        $authorizerAppid = $info['authorization_info']['authorizer_appid'];
        $authorizerRefreshToken = $info['authorization_info']['authorizer_refresh_token'];

        $app->officialAccount($authorizerAppid, $authorizerRefreshToken)
            ->customer_service
            ->message($authCode.'_from_api')
            ->to($openid)
            ->send();
    }
}

```
