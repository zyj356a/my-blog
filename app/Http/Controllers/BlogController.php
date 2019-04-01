<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Model\Post;
use App\Model\Tag;
use App\Services\PostService;
use App\Services\RssFeed;
use App\Services\SiteMap;

class BlogController extends Controller
{
    //首页显示所有文章
    public function index(Request $request)
    {
        $tag = $request->get('tag');
        $postService = new PostService($tag);
        $data = $postService->lists();
        $layout  = $tag ? Tag::layout($tag) : 'blog.layouts.index';
        return view($layout, $data);
    }

    //文章详情
    public function showPost($slug, Request $request)
    {
        $post = Post::with('tags')->where('slug', $slug)->firstOrFail();
        $tag = $request->get('tag');
        if($tag)
        {
            $tag = Tag::where('tag',$tag)->firstOrFail();
        }
        return view($post->layout, compact('post','tag'));
    }

    //
    public function rss(RssFeed $feed)
    {
        $rss = $feed->getRSS();

        return response($rss)
            ->header('Content-type','application/rss+xml');
    }

    public function siteMap(SiteMap $siteMap)
    {
        $map = $siteMap->getSiteMap();

        return response($map)
            ->header('Content-type', 'text/xml');
    }
}
