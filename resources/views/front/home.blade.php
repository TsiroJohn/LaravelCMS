@extends('layouts.blog-home')

@section('content')



<div class="row">

<!-- Blog Entries Column -->
    <div class="col-md-8">
 @if($posts)

    @foreach($posts as $post)
    

        <!-- First Blog Post -->
        <h2>
            {{ $post->title }}
        </h2>
        <p class="lead">
            by {{ $post->user->name }}
        </p>
        <p><span class="glyphicon glyphicon-time"></span> Posted on {{ $post->created_at->diffForHumans() }} </p>
        <hr>
        <img  height="300" width="700" src="{{ $post->photo ? $post->photo->file : $post->photoPlaceholder() }}" alt="">
        <hr>
        <p>{!! str_limit($post->body,300) !!}</p>
        <a class="btn btn-primary" href="{{ route('home.post',$post->slug) }}">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

        <hr>
    @endforeach
    
 @endif
       


        <!-- Pagination -->
        <div class="row">
            <div class="col-sm-6 col-sm-offset-5">
        {{ $posts->render() }}
            </div>
        </div>

    </div>

    <!-- Blog Sidebar Widgets Column -->
    @include('includes.front_sidebar')

</div>
<!-- /.row -->


@endsection
