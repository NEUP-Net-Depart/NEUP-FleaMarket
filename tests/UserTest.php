<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
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
        $u2 = User::find(2);
        $u2->username = "test";
        $u2->save();

        // test add username
        $this->withSession(['user_id' => 1])
            ->visit('/user')
            ->press('设置')
            ->see('用户名不可为空')
            ->type('*#^$%', 'username')
            ->press('设置')
            ->see('用户名只能为')
            ->type('test', 'username')
            ->press('设置')
            ->see('该用户名已被注册')
            ->type('testusernameuname', 'username')
            ->press('设置')
            ->see('设置成功');

        // test change username
        $this->withSession(['user_id' => 1])
            ->post('/user/edit/username', ['username' => 'newnewnew'])
            ->seeStatusCode(302);
        $this->visit('/user')
            ->dontSee('newnewnew')
            ->see('testusernameuname');

        $nu = new User();
        $nu->privilege = 0;
        $nu->baned =  false;
        $nu->havecheckedemail = false;
        $nu->role = 0;
        $nu->save();

        //test change email
        $this->withSession(['user_id' => $nu->id])
            ->visit('/user?tab=account')
            ->press('email_submit')
            ->see('邮箱不能为空')
            ->type('bindemail@example', 'email')
            ->press('email_submit')
            ->see('邮箱格式不正确')
            ->type('test@example.com', 'email')
            ->press('email_submit')
            ->see('已有用户使用该邮箱注册')
            ->type('bindemail@example.com', 'email')
            ->press('email_submit')
            ->see('已向您的邮箱发送一封验证邮件')
            ->see('未验证')
            ->see('解绑')
            ->press('解绑')
            ->see('解绑成功');

        $nu->email = "testnuemail@example.com";
        $nu->havecheckedemail = true;
        $nu->save();
        $this->withSession(['user_id' => $nu->id])
            ->visit('/user?tab=account')
            ->see('解绑')
            ->press('解绑')
            ->see('验证完成后即可解绑此邮箱');




        //test change password
        $this->withSession(['user_id' => $nu->id])
            ->visit('/user?tab=account')
            ->dontsee('当前密码')
            ->press('password_submit')
            ->see('密码不能为空')
            ->type('newpassword','newPassword')
            ->type('newpasswordn', 'newPassword_confirmation')
            ->press('password_submit')
            ->see('两次输入的密码不一致')
            ->type('newpassword','newPassword')
            ->type('newpassword', 'newPassword_confirmation')
            ->press('password_submit')
            ->see('密码已变更')
            ->see('当前密码')
            ->type('wrongpassword','password')
            ->type('newpassword2','newPassword')
            ->type('newpassword2', 'newPassword_confirmation')
            ->press('password_submit')
            ->see('旧密码错误')
            ->type('newpassword','password')
            ->type('newpassword2','newPassword')
            ->type('newpassword2', 'newPassword_confirmation')
            ->press('password_submit')
            ->see('密码已变更');

        $nu = User::find($nu->id);
        $this->assertTrue(Hash::check('newpassword2', $nu->password));
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
            ->visit('/user/userinfo/edit/1')
            ->assertResponseStatus(200)
            ->json('PUT', '/user/userinfo/edit', [
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
            ->json('DELETE', '/user/userinfo/delete', [
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
