<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
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
            ->post('message', ['receiver' => '10.5'])
            ->seeStatusCode(302)
            ->post('message', ['receiver' => '1024'])
            ->seeJson(['result' => false, 'msg' => 'no such receiver'])
            ->post('message', ['content' => 'testMessage', 'receiver' => '1'])
            ->seeStatusCode(200);

        //test Message Number
        $this->withSession(['user_id' => 1])
            ->get('message/num')
            ->see('1');

        //test Get Message List
        $this->withSession(['user_id' => 1])
            ->visit('message')
            ->seeStatusCode(200);

        //test Unauthorized
        $this->withSession(['user_id' => 2])
            ->delete('message/1')
            ->seeJson(['result' => false, 'msg' => 'Auth Failure.']);

        //test Del Message
        $this->withSession(['user_id' => 1])
            ->delete('message/1')
            ->seeJson(['result' => true, 'msg' => 'success'])
            ->visit('message')
            ->dontSee('testMessage');

    }
}
