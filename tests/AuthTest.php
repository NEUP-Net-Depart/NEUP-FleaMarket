<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\BrowserKitTestCase;
use App\User;

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
            ->dontSee('出售');


    }
}
