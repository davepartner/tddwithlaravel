<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Post;

class CreatePostTest extends TestCase
{
    use RefreshDatabase;
   
    protected function setUp()
        {
            parent::setUp();

            $this->withoutExceptionHandling();

            //create a dummy user
            $this->user = factory('App\User')->create();
        }

    
    /** @test */
   public function authenticated_users_can_create_new_posts(){
    $this->withExceptionHandling();
        //check if the Posts table is empty
        $this->assertEquals(0, Post::count());
      
        //dummy data
        $dummyData = [
            'title' => 'The quick brown fox',
            'body' => 'Dave Partner must be the greatest. He just beat sunny liston and he is only 22 years old.'
        ];
        
        $this->actingAs($this->user)->postJson(route('posts.store'), $dummyData)->assertStatus(201);

        //check if the Posts table contains exactly one post
        $this->assertEquals(1, Post::count());

        //check what we sent was what was saved
        $post = Post::first();

        $this->assertEquals($dummyData['title'], $post->title);
        $this->assertEquals($dummyData['body'], $post->body);

        //Trust but verify

    } 

    /** @test */
    public function unauthenticated_users_cant_create_new_posts(){
        $this->withExceptionHandling();

        //throw a 401 if a non-logged in user is attempting to use the posts.store route
        $this->postJson(route('posts.store'))->assertStatus(401);
    }
}
