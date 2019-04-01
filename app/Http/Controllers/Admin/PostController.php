<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostCreateRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Model\Post;
use App\Model\Tag;
use Carbon\Carbon;
use Illuminate\Http\Response;

class PostController extends Controller
{
    protected $fieldList = [
        'title' => '',
        'subtitle' => '',
        'page_image' => '',
        'content' => '',
        'meta_description' => '',
        'is_draft' => "0",
        'publish_date' => '',
        'publish_time' => '',
        'layout' => 'blog.layouts.post',
        'tags' => [],
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.post.index', ['posts' => Post::all()] );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $fields = $this->fieldList;
        $when = Carbon::now()->addHour();
        $fields['publish_date'] = $when->format('Y-m-d');
        $fields['publish_time'] = $when->format('g:i A');

        foreach ($fields as $fieldName => $fieldValue)
        {
            $fields[$fieldName] = old($fieldName, $fieldValue);
        }

        $data = array_merge(
            $fields,
            ['allTags' => Tag::all()->pluck('tag')->all()]
        );

        return view('admin.post.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostCreateRequest $request)
    {
        $post = Post::create($request->postFillData());
        $post->syncTags($request->get('tags', []));

        return redirect()->back()->with('success','新文章创建成功');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * 编辑文章
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $fields = $this->fieldsFromModel($id,  $this->fieldList);

        foreach ($fields as $fieldName => $fieldValue)
        {
            $fields[$fieldName] = old($fieldName,$fieldValue);
        }

        $data = array_merge(
            $fields,
            ['allTags' => Tag::all()->pluck('tag')->all()]
        );

        return view('admin.post.edit', $data);
    }

    /**
     * 更新文章
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostUpdateRequest $request, $id)
    {
        $post = Post::findOrFail($id);
        $post->fill($request->postFillData());
        $post->save();
        $post->syncTags($request->get('tags', []));

        if($request->action === 'continue')
        {
            return redirect()->back()->with('success','文章已保存');
        }
        return redirect()->route('post.index')->with('success','文章已保存');
    }

    /**
     * 删除文章
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->tags()->detach();
        $post->delete();

        return redirect()->route('post.index')->with('success','文章已删除');
    }

    /*
     * 从模型中获取数据
     */
    private function fieldsFromModel($id, array $fields)
    {
        $post = Post::findOrFail($id);

        $fieldsName = array_keys(array_except($fields,['tags']));

        $fields = ['id' => $id];
        foreach ($fieldsName as $field) {
            $fields[$field] = $post->{$field};
        }

        $fields['tags'] = $post->tags->pluck('tag')->all();

        return $fields;
    }
}
