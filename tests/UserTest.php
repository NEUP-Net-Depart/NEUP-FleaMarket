<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\BrowserKitTestCase;
use App\GoodInfo;
use App\FavList;

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

    public function testFavList()
    {
        $good = new GoodInfo();
        $good->good_name = 'fav_test';
        $good->cat_id = 1;
        $good->description = 'description';
        $good->price = 1;
        $good->type = 1;
        $good->count = 1;
        $good->user_id = 1;
        $good->baned = '0';
        $good->save();
        $fav = new FavList();
        $fav->user_id = 1;
        $fav->good_id = $good->id;
        $fav->save();

        $this->withSession(['user_id' => 1])
            ->visit('/user/fav')
            ->see('编辑收藏夹')
            ->click('编辑收藏夹')
            ->seePageIs('/user/fav/edit')
            ->see('fav_test');
        $this->withSession(['user_id' => 1])
            ->delete('/user/fav/del', ["del_goods" => [$good->id]])
            ->seeStatusCode(302);
        $this->withSession(['user_id' => 1])
            ->delete('/user/fav/del')
            ->seeStatusCode(302);
        $this->withSession(['user_id' => 1])
            ->visit('/user/fav')
            ->dontSee('fav_test');
    }
}
