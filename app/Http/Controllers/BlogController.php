<?php

namespace App\Http\Controllers;

use App\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class BlogController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(BlogPost $blogPost)
    {
        //$this->middleware('auth')->except(['index', 'show']);
        $this->blogPost = $blogPost;
    }

    public function index(Request $request)
    {
        $selectedTag = $request->input('tag','all');

        $posts = BlogPost::showAll($selectedTag);

        return view('article.index', compact('posts'));
    }

    public function create()
    {
        return view('article.create');
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $input['author_id'] = Auth::id();
        $input['tags'] = array_map('trim', explode(',', trim($request['tags'])));

        $this->blogPost->store($input);

        return redirect()->route('article.index');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }
}
