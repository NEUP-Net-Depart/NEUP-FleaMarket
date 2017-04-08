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
}
