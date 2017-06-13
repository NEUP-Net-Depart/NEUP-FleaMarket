<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\BrowserKitTestCase;
use App\User;
use App\UserInfo;
use Illuminate\Support\Facades\Hash;

class AuthTest extends BrowserKitTestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testBasicAuth()
    {
        //test login failure
        $this->visit('/login')
            ->see('用户名')
            ->type('sometestwrongusername', 'username')
            ->type('sometestuselesspassword', 'password')
            ->press('登录')
            ->see("用户名或者密码错误");

        $this->visit('/login')
            ->see('用户名')
            ->type('sometestwrongmail@invalid.fake', 'username')
            ->type('sometestuselesspassword', 'password')
            ->press('登录')
            ->see("用户名或者密码错误");

        //test register
        $this->visit('/register')
            ->see('邮箱')
            ->press('注册')
            ->see("邮箱不能为空")
            ->type('test', 'email')
            ->press('注册')
            ->see('邮箱格式不正确')
            ->type('test@example.com', 'email')
            ->type('test@example.com', 'password')
            ->type('test@example.com2', 'password_confirmation')
            ->press('注册')
            ->see('两次输入的密码不一致')
            ->type('test@example.com', 'email')
            ->type('test@example.com', 'password')
            ->type('test@example.com', 'password_confirmation')
            ->press('注册')
            ->see('已向您的邮箱发送一封验证邮件，请查收');

        //test register again
        $this->visit('/register')
            ->type('test@example.com', 'email')
            ->type('test@example.com', 'password')
            ->type('test@example.com', 'password_confirmation')
            ->press('注册')
            ->see('已有用户使用该邮箱注册');

        //test login
        $this->visit('/login')
            ->type('test@example.com', 'username')
            ->type('test@example.com', 'password')
            ->press('登录')
            ->see('未验证您的邮箱');

        $user = User::where('email', 'test@example.com')->first();
        $user->havecheckedemail = true;
        $user->save();
    }

    public function testAfterReg()
    {
        //test 2
        $this->visit('/login')
            ->type('test@example.com', 'username')
            ->type('test@example.com', 'password')
            ->press('登录')
            ->see('昵称')
            ->see('上传头像')
            ->type('aaa', 'nickname')
            ->press('保存')
            ->seePageIs('/register/2')
            ->see('aaa');

        //test redirect
        $this->visit('/login')
            ->seePageIs('/');

        //test logout
        $this->visit('logout')
            ->dontSee('出售')
            ->assertSessionMissing('user_id');

        //test 2 avatar
        $this->visit('/login')
            ->type('test@example.com', 'username')
            ->type('test@example.com', 'password')
            ->press('登录')
            ->seePageIs('/register/2')
            ->attach(__DIR__ . '/resources/good.jpg', 'avatarPic')
            ->type('500', 'crop_width')
            ->type('500', 'crop_height')
            ->type('0', 'crop_x')
            ->type('0', 'crop_y')
            ->press('保存')
            ->seePageIs('/register/3');

        //test 3
        $this->visit('logout')
            ->visit('/login')
            ->type('test@example.com', 'username')
            ->type('test@example.com', 'password')
            ->press('登录')
            ->seePageIs('/register/3');

        //test 0
        $this->visit('logout');
        $userinfo = new UserInfo();
        $userinfo->user_id = 1;
        $userinfo->tel_num = "12323232323";
        $userinfo->save();
        $this->visit('/login')
            ->type('test@example.com', 'username')
            ->type('test@example.com', 'password')
            ->press('登录')
            ->seePageIs('/')
            ->seeInSession('user_id');
    }

    public function testSuperAdmin()
    {
        $user = new User();
        $user->privilege = 2;
        $user->password = Hash::make('admin@example.com');
        $user->email = "admin@example.com";
        $user->havecheckedemail = 1;
        $user->save();

        $this->visit('logout')
            ->seePageIs('/login')
            ->assertSessionMissing('user_id');

        $this->visit('login')
            ->type('admin@example.com', 'username')
            ->type('admin@example.com', 'password')
            ->press('登录')
            ->seeInSession('is_admin', 2);
    }

    public function testSendLetter()
    {
        $this->get('/user/100/sendCheckLetter')
            ->assertResponseStatus(404)
            ->visit('/user/1/sendCheckLetter')
            ->see('该用户已经验证过邮箱');
        $this->get('/user/100/sendUnbindLetter')
            ->assertResponseStatus(404);
    }

    public function testPasswordForget()
    {
        $this->visit('/iforgotit')
            ->see('重置密码')
            ->type('admin@example.com', 'email')
            ->press('确定')
            ->see('已向你的邮箱发送一份包含重置密码的链接的邮件');
    }
}
