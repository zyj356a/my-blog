<?php
namespace App\Services;

use App\Model\Post;
use App\Model\Tag;
use Carbon\Carbon;


class PostService
{
    protected $tag;

    /*
     * @param string|null| $tag
     */
    public function __construct($tag)
    {
        $this->tag = $tag;
    }

    /**
     * @return mixed
     */
    public function lists()
    {
        if($this->tag)
        {
            return $this->tagIndexData($this->tag);
        }
        return $this->normalIndexData();
    }
    /*
     * return data for normal index page
     */
    protected function normalIndexData()
    {
        $posts = Post::with('tags')
                ->where('published_at', '<=', Carbon::now())
                ->where('is_draft',0)
                ->orderBy('published_at','desc')
                ->simplePaginate(config('blog.posts_per_page'));

        return [
            'title' => config('blog.title'),
            'subtitle' => config('blog.subtitle'),
            'posts' => $posts,
            'page_image' => config('blog.page_image'),
            'meta_description' => config('blog.description'),
            'reverse_direction' => false,
            'tag' => null,
        ];
    }

    /*
     * return data for a tag index page
     */

    protected function tagIndexData($tag)
    {
        $tag = Tag::where('tag', $tag)->firstOrFail;
        $reverse_direction = (bool)$tag->reverse_direction;

        $posts = Post::where('published_at', '<=', Carbon::now())
            ->whereHas('tags', function ($q) use ($tag){
                $q->where('tag', '=', $tag->tag);
            })
            ->where('is_draft', 0)
            ->orderBy('published_at',$reverse_direction ? 'asc' : 'dsc')
            ->simplePaginate(config('tag', $tag->tag));

        $page_image = $tag->page_image ? : config('blog.page_image');

        return [
            'title' => $tag->title,
            'subtitle' => $tag->subtitle,
            'posts' => $posts,
            'page_image' => $tag->$page_image,
            'tag' => $tag,
            'reverse_direction' => $reverse_direction,
            'meta_description' => $tag->meta_decription ? : config('blog.description'),
        ];
    }
}
