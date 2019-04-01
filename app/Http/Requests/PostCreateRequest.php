<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class PostCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'subtitle' => 'required',
            'content' => 'required',
            'publish_date' => 'required',
            'publish_time' => 'required',
            'layout' => 'required',
        ];
    }

    /*
     * 返回数据创建新的post
     */
    public function postFillData()
    {
        $publish_at = new Carbon(
            $this->publish_date . ' ' . $this->publish_time
        );

        return [
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'page_image' => $this->page_image,
            'content_raw' => $this->get('content'),
            'meta_description' => $this->meta_description,
            'is_draft' => (bool)$this->is_draft,
            'published_at' => $publish_at,
            'layout' => $this->layout,
        ];
    }
}
