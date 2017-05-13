<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\BrowserKitTestCase;

class GoodTest extends BrowserKitTestCase
{
    public function testAddGood()
    {
        //login
        $this->visit('/login')
            ->type('test@example.com', 'username')
            ->type('test@example.com', 'password')
            ->press('登录');

        //test add good
        $this->visit('/good/add')
            ->see('添加')
            ->press('添加')
            ->see('商品名不能为空')
            ->type('算法竞赛入门经典', 'good_name')
            ->press('添加')
            ->see('商品描述不能为空')
            ->type('算法竞赛入门经典', 'good_name')
            ->select('1', 'cat_id')
            ->type('刘汝佳', 'description')
            ->press('添加')
            ->see('商品价格不能为空')
            ->type('算法竞赛入门经典', 'good_name')
            ->select('1', 'cat_id')
            ->type('刘汝佳', 'description')
            ->type('65', 'price')
            ->press('添加')
            ->see('库存数不能为空')
            ->type('算法竞赛入门经典', 'good_name')
            ->select('1', 'cat_id')
            ->type('刘汝佳', 'description')
            ->type('65', 'price')
            ->select('1', 'type')
            ->type('10', 'count')
            ->press('添加')
            ->see('必须为商品上传一张图片');
            /*->type('算法竞赛入门经典', 'good_name')
            ->select('1', 'cat_id')
            ->type('刘汝佳', 'description')
            ->type('65', 'price')
            ->select('1', 'type')
            ->type('10', 'count')
            ->attach(__DIR__.'/../storage/good.jpg', 'goodTitlePic') //测试时总会提示validation.uploaded
            ->press('添加')
            ->see('修改');*/
    }

    /*public function testEditGood()
    {

    }

    public function testDeleteGood()
    {

    }*/
}
