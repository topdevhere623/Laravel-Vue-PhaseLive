<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\User;
use App\News;

class LikeTest extends TestCase
{
    private $user, $news;

    public function setUp() : void
    {
        parent::setUp();
        $this->artisan('migrate:fresh');
        $this->artisan('db:seed');
        $this->user = User::find(1);
        $this->news = News::find(1);
    }

    public function testNewsWithNoLikes()
    {
        $this->assertEmpty($this->news->likes);
        $this->assertFalse($this->news->isLiked($this->user));
    }

    public function testUserWithNoLikes()
    {
        $this->assertEmpty($this->user->likes);
    }

    public function testAddLikeToNews()
    {
        $this->news->like($this->user);
        $this->assertNotEmpty($this->news->likes);
        $this->assertNotEmpty($this->user->likes());
        $this->assertTrue($this->news->isLiked($this->user));

        $like = $this->news->likes[0];

        $this->assertEquals($like->liker, $this->user);
    }

    public function tearDown() : void
    {
        $this->artisan('migrate:fresh');
        $this->artisan('db:seed');
        parent::tearDown();
    }
}
