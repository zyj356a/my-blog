<?php

use Illuminate\Database\Seeder;
use App\Model\Tag;
use App\Model\Post;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Post::truncate(); //清理数据表
        factory(Tag::class,5)->create();
    }
}