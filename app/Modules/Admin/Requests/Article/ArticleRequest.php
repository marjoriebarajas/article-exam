<?php

namespace App\Modules\Admin\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
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
            'title'             => 'required|min:3|unique:articles,title,'.(($this->getID()) ? $this->getID():'NULL').',id,client_id,'.auth()->user()->client->id,
            'content'           => 'required',
            'status'            => 'required',
            'published_date'    => 'required',
            'expired_date'      => 'nullable|after:published_date',
            'thumbnail'         => 'mimes:jpeg,jpg,png,PNG|max:10000'
        ];
    }

    public function messages()
    {
        return [
            'expired_date.after'    => 'This must be after publish date.',
            'featured_image.max'    => 'The image may not be greater than 10MB.'
        ];
    }

    public function getID()
    {
        return decode($this->article);
    }
}