<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\BrowserKitTestCase;

class UserTest extends BrowserKitTestCase
{
    public function testUserInfo()
    {
        $this->withSession(['user_id' => 1])
            ->visit('/user/userinfo')
            ->see('æ·»å èç³»æ¹å¼'); //添加联系方式

        $this->withSession(['user_id' => 1])
            ->visit('/user/userinfo/create')
            ->see('ä¿å­'); //保存

        $this->withSession(['user_id' => 1])
            ->json('POST', '/user/userinfo', [
                'realname' => 'test',
                'tel_num' => '13333333333',
                'QQ' => 'interesting@u.me',
                'wechat' => '13333333333',
                'address' => 'nonono, imagasaikou',
            ])
            ->seeJson([
                'result' => 'true',
                'msg' => 'success'
            ]);
    }

    public function testAvatar()
    {
        // show
        $this->visit('/avatar/1')
            ->seeHeader('Content-Type', 'image/jpeg')
            ->visit('/avatar/1/64/64')
            ->seeHeader('Content-Type', 'image/jpeg');
    }
}
