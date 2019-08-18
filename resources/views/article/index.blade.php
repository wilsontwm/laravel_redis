@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12" style="margin-bottom: 10px">
            <a href="{!! route('article.create') !!}" class="btn btn-primary">Create</a>
        </div>
        <div class="col-md-12">
            <div class="panel panel-default table-responsive">
                <table class="table table-hover">
                    @foreach($posts as $post)
                        <tr>
                            <td>
                                <h2>{{ $post->title }}</h2>
                                <small>By: {{ $post->author->name }}</small>
                                <p>{{ $post->post }}</p>
                                <p>
                                    @if(isset($post->tags))
                                        @foreach($post->tags as $tag)
                                        <a href="{{ route('article.index', ['tag' => $tag]) }}" class="label-info" style="color:white;padding: 3px; font-size:12px;">{{ $tag }}</a>
                                        @endforeach
                                    @endif
                                </p>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
