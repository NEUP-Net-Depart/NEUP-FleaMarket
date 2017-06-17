<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\BrowserKitTestCase;
use App\GoodCat;

class GoodTest extends BrowserKitTestCase
{
    public function testAddGood()
    {
        //add good_cat
        $cat = new GoodCat;
        $cat->cat_name = '测试';
        $cat->cat_index = '0';
        $cat->save();

        //test add good
        $this->withSession(['user_id' => 1])
            ->visit('/good/add')
            ->press('添加')
            ->see('商品名不能为空')
            ->type('算法竞赛入门经典', 'good_name')
            ->select('1', 'cat_id')
            ->type('刘汝佳', 'description')
            ->press('添加')
            ->see('商品价格不能为空')
            ->type('aaa', 'price')
            ->press('添加')
            ->see('商品价格必须为数值')
            ->type('65.5', 'price')
            ->press('添加')
            ->see('库存数不能为空')
            ->select('1', 'type')
            ->type('10.5', 'count')
            ->press('添加')
            ->see('库存数必须是整数')
            ->type('10', 'count')
            ->press('添加')
            ->see('必须为商品上传封面')
            ->attach(__DIR__ . '/resources/good.jpg', 'goodTitlePic')
            ->press('添加')
            ->see('请按要求裁剪图片')
            ->attach(__DIR__ . '/resources/good.jpg', 'goodTitlePic')
            ->type('400', 'crop_width')
            ->type('225', 'crop_height')
            ->type('50', 'crop_x')
            ->type('137.5', 'crop_y')
            ->press('添加')
            ->see('65.5');
    }

    public function testGoodPic()
    {
        $this->visit('/good/'. sha1(1) .'/titlepic')
            ->seeHeader('Content-Type', 'image/jpeg')
            ->visit('/good/'. sha1(1) .'/titlepic/640/480')
            ->seeHeader('Content-Type', 'image/jpeg');
    }

    public function testListGood()
    {
        $this->visit('/logout')
            ->visit('/good')
            ->see('算法竞赛入门经典')
            ->visit('/good?cat_id=1')
            ->see('算法竞赛入门经典')
            ->visit('/good?cat_id=2')
            ->dontSee('算法竞赛入门经典')
            ->visit('/good/1')
            ->see('算法竞赛入门经典')
            ->dontSee('修改');
    }

    public function testSortGood()
    {
        $this->withSession(['user_id' => 1])
            ->visit('/good/add')
            ->type('第二版', 'good_name')
            ->select('1', 'cat_id')
            ->type('刘汝佳', 'description')
            ->type('50', 'price')
            ->select('1', 'type')
            ->type('20', 'count')
            ->attach(__DIR__ . '/resources/good.jpg', 'goodTitlePic')
            ->type('400', 'crop_width')
            ->type('225', 'crop_height')
            ->type('50', 'crop_x')
            ->type('137.5', 'crop_y')
            ->press('添加')
            ->visit('/logout')
            ->visit('/good?start_price=60')
            ->see('算法竞赛入门经典')
            ->dontSee('第二版')
            ->visit('/good?end_price=60')
            ->dontSee('算法竞赛入门经典')
            ->see('第二版')
            ->visit('/good?start_price=60&end_price=70')
            ->see('算法竞赛入门经典')
            ->dontSee('第二版')
            ->visit('/good?start_price=60&end_price=40')
            ->see('第二版')
            ->dontSee('算法竞赛入门经典')
            ->visit('/good?sort=p')
            ->see('算法竞赛入门经典')
            ->see('第二版')
            ->visit('/good?sort=pd')
            ->see('算法竞赛入门经典')
            ->see('第二版')
            ->visit('/good?sort=c')
            ->see('算法竞赛入门经典')
            ->see('第二版')
            ->visit('/good?sort=cd')
            ->see('算法竞赛入门经典')
            ->see('第二版')
            ->visit('/good?sort=old')
            ->see('算法竞赛入门经典')
            ->see('第二版');
    }

    public function testFavList()
    {
        $this->withSession(['user_id' => 1])
            ->post('/good/1/add_favlist')
            ->see('success')
            ->delete('/good/1/del_favlist')
            ->see('success');
    }

    public function testEditGood()
    {
        //test edit good
        $this->withSession(['user_id' => 1])
            ->visit('/good/1')
            ->press('修改')
            ->type('', 'good_name')
            ->press('更改')
            ->see('商品名不能为空')
            ->type('算法竞赛入门经典', 'good_name')
            ->type('', 'price')
            ->press('更改')
            ->see('商品价格不能为空')
            ->type('aaa', 'price')
            ->press('更改')
            ->see('商品价格必须为数值')
            ->type('2333', 'price')
            ->type('', 'count')
            ->press('更改')
            ->see('库存数不能为空')
            ->type('10.5', 'count')
            ->press('更改')
            ->see('库存数必须是整数')
            ->type('10', 'count')
            ->type('汝佳大法好', 'description')
            ->type('666', 'price')
            ->type('10', 'count')
            ->attach(__DIR__ . '/resources/good.jpg', 'goodTitlePic')
            ->type('500', 'crop_width')
            ->type('281', 'crop_height')
            ->type('0', 'crop_x')
            ->type('108', 'crop_y')
            ->press('更改')
            ->see('￥666')
            ->see('汝佳大法好')
            ->visit('/good/'. sha1(1) .'/titlepic')
            ->seeHeader('Content-Type', 'image/jpeg')
            ->visit('/good/'. sha1(1) .'/titlepic/640/480')
            ->seeHeader('Content-Type', 'image/jpeg');
    }



    public function testUnauthorized()
    {
        //test unauthorized access
        $this->withSession(['user_id' => 2])
            ->visit('/good/1')
            ->dontSee('修改')
            ->dontSee('删除')
            ->visit('/good/1/edit')
            ->seePageIs('/good/1')
            ->delete('/good/1/delete')
            ->seeStatusCode(302)
            ->post('/good/1/edit', ['good_name' => '111', 'description' => '111', 'price' => 111, 'count' => 111])
            ->seeStatusCode(302);

        $this->withSession(['user_id' => 2, 'is_admin' => 1])
            ->visit('/good/1')
            ->dontSee('修改')
            ->dontSee('删除')
            ->visit('/good/1/edit')
            ->seePageIs('/good/1')
            ->delete('/good/1/delete')
            ->seeStatusCode(302)
            ->post('/good/1/edit', ['good_name' => '111', 'description' => '111', 'price' => 111, 'count' => 111])
            ->seeStatusCode(302);
    }

    public function testSuperAdmin()
    {
        //test super administrator access and delete good
        $this->withSession(['user_id' => 2, 'is_admin' => 2])
            ->visit('/good/1')
            ->see('修改')
            ->see('删除')
            ->press('修改')
            ->type('算竞入经', 'good_name')
            ->press('更改')
            ->see('算竞入经')
            ->visit('/good/1')
            ->press('删除')
            ->dontSee('算竞入经')
            ->visit('/good/1')
            ->see('商品ID错误')
            ->visit('/good/1/edit')
            ->see('商品ID错误');
    }

}
