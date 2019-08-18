<?php

namespace App;

use Illuminate\Support\Facades\Cache;
use Redis;
use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'post', 'author_id', 'tags'
    ];

    protected $table = 'blog_posts';

    protected $casts = [
        'tags' => 'array'
    ];

    public static function showAll($tag)
    {
        $posts = Cache::remember('posts:' . $tag, 1, function() use ($tag)
        {
            $result = BlogPost::orderBy('created_at', 'desc')->get();
            if($tag != 'all')
            {
                return $result->filter(function($post) use ($tag) {
                    $tags = $post->tags;
                    return !is_null($tags) && in_array($tag, $tags);
                });
            }

            return $result;
        });

        return $posts;
    }

    public function store($input)
    {
        $post = $this->create($input);

        if(sizeof($input['tags']) > 0)
        {
            foreach($input['tags'] as $tag)
            {
                // Add into a sorted set of the post
                Redis::zadd('posts:' . $tag, $post->id, $post->id);
                // Create a set of tags for the post
                Redis::sadd('posts:' . $post->id . ':tags', $tag);
                Redis::sadd('posts:tags', $tag);
            }
        }
    }

    public function author()
    {
        return $this->belongsTo('App\User', 'author_id');
    }
}
