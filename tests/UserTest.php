<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\BrowserKitTestCase;
use App\User;
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

    public function testEditUserExtra()
    {
        $this->withSession(['user_id' => 1])
            ->visit('/user/1')
            ->type('changenickname', 'nickname')
            ->press('保存')
            ->see('changenickname');
    }

    public function testEditUserAccount()
    {
        $user_backup = User::where('email', 'test@example.com')->first();

        // test add username
        $this->withSession(['user_id' => 1])
            ->visit('/user/1')
            ->post('/user/1/edit/account', [
                '_token' => csrf_token(),
                'username' => 'username',
                'email' => 'test@example.com',
                'password' => 'wrongpassword',
                'newPassword' => '',
                'newPassword_confirmation' => ''
            ])
            ->visit('/user/1')
            ->see('当前密码错误')
            ->post('/user/1/edit/account', [
                '_token' => csrf_token(),
                'username' => 'username',
                'email' => 'test@example.com',
                'password' => 'test@example.com',
                'newPassword' => '',
                'newPassword_confirmation' => ''
            ])
            ->visit('/user/1')
            ->seePageIs('/login')
            ->type('username', 'username')
            ->type('test@example.com', 'password')
            ->press('登录')
            ->seePageIs('/')
            ->seeInSession('user_id');

        $user_another = new User;
        $user_another->username = 'hasusername';
        $user_another->email = 'hasemail@example.com';
        $user_another->havecheckedemail = true;
        $user_another->save();

        //test change username and email
        $this->withSession(['user_id' => 1])
            ->visit('/user/1')
            ->post('/user/1/edit/account', [
                '_token' => csrf_token(),
                'username' => 'username',
                'email' => 'hasemail@example.com',
                'password' => 'test@example.com',
                'newPassword' => '',
                'newPassword_confirmation' => ''
            ])
            ->visit('/user/1')
            ->see('已有用户使用该邮箱注册')
            ->post('/user/1/edit/account', [
                '_token' => csrf_token(),
                'username' => 'changeusername',
                'email' => 'changeemail@example.com',
                'password' => 'test@example.com',
                'newPassword' => '',
                'newPassword_confirmation' => ''
            ])
            ->visit('/user/1');

        $user = User::where('email', 'changeemail@example.com')->first();
        $user->havecheckedemail = true;
        $user->save();

        $this->seePageIs('/login')
            ->type('changeemail@example.com', 'username')
            ->type('test@example.com', 'password')
            ->press('登录')
            ->seePageIs('/')
            ->seeInSession('user_id');

        //test change password
        $this->withSession(['user_id' => 1])
            ->visit('/user/1')
            ->post('/user/1/edit/account', [
                '_token' => csrf_token(),
                'username' => 'changeusername',
                'email' => 'changeemail@example.com',
                'password' => 'test@example.com',
                'newPassword' => 'changepassword',
                'newPassword_confirmation' => 'changepassword2'
            ])
            ->visit('/user/1')
            ->see('两次输入的密码不一致')
            ->post('/user/1/edit/account', [
                '_token' => csrf_token(),
                'username' => 'changeusername',
                'email' => 'changeemail@example.com',
                'password' => 'test@example.com',
                'newPassword' => 'changepassword',
                'newPassword_confirmation' => 'changepassword'
            ])
            ->visit('/user/1')
            ->seePageIs('/login')
            ->type('username', 'username')
            ->type('changepassword', 'password')
            ->press('登录')
            ->seePageIs('/')
            ->seeInSession('user_id');

        $user_backup->save();
    }

    public function testEditUserInfo()
    {
        $this->withSession(['user_id' => 1])
            ->visit('/user/1')
            ->json('POST', '/user/userinfo', [
                'realname' => '',
                'tel_num' => '10000000000',
                'QQ' => '10000000',
                'wechat' => 'wechat',
                'address' => 'address',
            ])
            ->assertResponseStatus(422)
            ->json('POST', '/user/userinfo', [
                'realname' => 'realname',
                'tel_num' => '10000000000',
                'QQ' => '11000000',
                'wechat' => 'wechat',
                'address' => 'address',
            ])
            ->visit('/user/userinfo')
            ->see('realname')
            ->see('10000000000')
            ->see('11000000')
            ->see('wechat')
            ->see('address')
            ->json('POST', '/user/userinfo/update', [
                'id' => '1',
                'realname' => 'changerealname',
                'tel_num' => '999',
                'QQ' => '987',
                'wechat' => 'changewechat',
                'address' => 'changeaddress',
            ])
            ->visit('/user/userinfo')
            ->see('changerealname')
            ->see('999')
            ->see('987')
            ->see('changewechat')
            ->see('changeaddress')
            ->json('POST', '/user/userinfo/delete', [
                'id' => '1',
            ])
            ->dontSee('changerealname');
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
