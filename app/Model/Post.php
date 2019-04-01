<?php

namespace App\Model;

use App\Services\Markdowner;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Model\Tag;

class Post extends Model
{
    protected $dates = ['published_at'];

    protected $fillable = [
        'title','subtitle','content_raw', 'page_image', 'meta_description','layout','is_draft','published_at',
    ];

    /**
     * @param $value
     */
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;

        if(! $this->exists)
        {
            $value = uniqid(str_random(8));
            $this->setUniqueSlug($value,0);
        }
    }

    /*
     * 标签与文章的多对多关系
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tag_pivot');
    }

    /*
     *Recursive routine to set a unique slug
     */
    public function setUniqueSlug($title, $extra)
    {
        $slug = Str::slug($title . '-'. $extra);

        if(static::where('slug',$slug)->exists())
        {
            $this->setUniqueSlug($title, $extra + 1);
        }

        $this->attributes['slug'] = $slug;
    }

    /*
     * Set the HTML content automatically when the raw content is set
     */
    public function setContentRawAttribute($value)
    {
        $markdown = new Markdowner();

        $this->attributes['content_raw'] = $value;
        $this->attributes['content_html'] = $markdown->toHTML($value);
    }

    /*
     * Sync tag relation adding new tags as needed
     */
    public function syncTags(array $tags)
    {
        Tag::addNeededTags($tags);

        if(count($tags))
        {
            $this->tags()->sync(
                Tag::whereIn('tag',$tags)->get()->pluck('id')->all()
            );
            return;
        }

        $this->tags()->detach();
    }

    /*
     * 返回published_at字段的日期部分
     */
    public function getPublishDateAttribute($value)
    {
        return $this->published_at->format('Y-m-d');
    }
    /*
     * 返回published_at字段的时间部分
     */
    public function getPublishTimeAttribute($value)
    {
        return $this->published_at->format('g:i A');
    }

    /*
     * content_raw字段别名
     */
    public function getContentAttribute($value)
    {
        return $this->content_raw;
    }

    /*
     * return URL to post
     */
    public function url(Tag $tag = null)
    {
        $url = url('blog/'.$this->slug);
        if($tag)
        {
            $url .= '?tag='.urlencode($tag->tag);
        }

        return $url;
    }
    /*
     * return array of tag links
     */
    public function tagLinks($base = '/blog?tag=%TAG%')
    {
        $tags = $this->tags()->get()->pluck('tag')->all();
        $return = [];
        foreach ($tags as $tag)
        {
            $url = str_replace('%TAG%', urlencode($tag), $base);
            $return[] = '<a href = "' . $url . '">'.e($tag). '</a>';
        }
        return $return;
    }

    /*
     * return next post after this one or null
     */
    public function newerPost(Tag $tag = null)
    {
        $query = static::where('published_at', '>', $this->published_at)
            ->where('published_at','<=',Carbon::now())
            ->where('is_draft',0)
            ->orderBy('published_at','asc');
        if($tag)
        {
            $query = $query->whereHas('tags', function($q) use ($tag){
                $q->where('tag','=',$tag->tag);
            });
        }

        return $query->first();
    }
    /*
     * return older post before this one or null
     */
    public function olderPost(Tag $tag = null)
    {
        $query = static::where('published_at', '<', $this->published_at)
            ->where('is_draft',0)
            ->orderBy('published_at','desc');
        if($tag)
        {
            $query = $query->whereHas('tags', function($q) use ($tag){
                $q->where('tag','=',$tag->tag);
            });
        }

        return $query->first();
    }
}
