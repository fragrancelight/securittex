<?php

namespace Modules\BlogNews\Entities;

use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    protected $fillable = [
        'title' ,'slug' , 'thumbnail' , 'category' , 
        'sub_category' , 'status' , 'body' , 
        'keywords','description','publish' , 'views',
        'is_fetured','publish_at','comment_allow'
    ];

    public function translationBlogPost()
    {
        return $this->hasMany(BlogPostTranslation::class, 'blog_post_id');
    }
}
