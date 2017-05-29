<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\BrowserKitTestCase;

class MessageTest extends BrowserKitTestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicMessage()
    {
        //test Send Message
        $this->withSession(['user_id' => 1])
            ->post('message')
            ->seeStatusCode(302)
            ->post('message', ['title' => 'testMessage'])
            ->seeStatusCode(302)
            ->post('message', ['title' => 'testMessage', 'receiver' => '10.5'])
            ->seeStatusCode(302)
            ->post('message', ['title' => 'testMessage', 'receiver' => '1024'])
            ->seeJson(['result' => false, 'msg' => 'no such receiver'])
            ->post('message', ['title' => 'testMessage', 'content' => 'content', 'receiver' => '1'])
            ->seeJson(['result' => true, 'msg' => 'success']);

        //test Message Number
        $this->withSession(['user_id' => 1])
            ->get('message/num')
            ->see('1');

        //test Get Message List
        $this->withSession(['user_id' => 1])
            ->visit('message')
            ->see('testMessage');

        //test Unauthorized
        $this->withSession(['user_id' => 2])
            ->put('message/1')
            ->seeJson(['result' => false, 'msg' => 'Auth Failure.'])
            ->delete('message/1')
            ->seeJson(['result' => false, 'msg' => 'Auth Failure.']);

        //test Read Message
        $this->withSession(['user_id' => 1])
            ->put('message/1')
            ->seeJson(['result' => true, 'msg' => 'success'])
            ->get('message/num')
            ->see('0')
            ->visit('message')
            ->see('testMessage');

        //test Del Message
        $this->withSession(['user_id' => 1])
            ->delete('message/1')
            ->seeJson(['result' => true, 'msg' => 'success'])
            ->visit('message')
            ->dontSee('testMessage');

    }
}
