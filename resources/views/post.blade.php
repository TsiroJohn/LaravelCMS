@extends('layouts.blog-post')
@section('alert_message')
    @if(Session::has('comment_message'))
        <div   class="alert alert-info alert-dismissible fade in" data-auto-dismiss="2000" role="alert">{{ session('comment_message') }}
        <button type="button" class="close" data-dismiss="alert">x</button></div>
        </div>

    @endif
@stop
@section('content')



 <!-- Blog Post -->

                <!-- Title -->
                <h1>{{ $post->title }}</h1>

                <!-- Author -->
                <p class="lead">
                    by <a href="#">{{ $post->user->name }}</a>
                </p>

               
               @if ($post->tags)
                <div class="tags">
                    @foreach($post->tags as $tag)
                    <span class="badge badge-primary">{{ $tag->name }}</span>
                    @endforeach
                </div>
                @endif
                <hr>

                <!-- Date/Time -->
                <p><span class="glyphicon glyphicon-time"></span> Posted on {{ $post->created_at->diffForHumans() }}</p>

                <hr>
               
                <!-- Preview Image -->
                <img class="img-responsive"  src="{{ $post->photo ? $post->photo->file : 'http://placehold.it/750x400'}}" alt="">

                <hr>
               
                <!-- Post Content -->
                <p class="lead">{!! $post->body !!}

                <hr>

                <!-- Blog Comments -->
                @if(Auth::check())
                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>

                    {!! Form::open(['method'=>'POST','action'=>'PostCommentsController@store']) !!}

                        <input type="hidden" name="post_id" value="{{ $post->id }}">

                    <div class="form-group">
                        
                        {!! Form::textarea('body',null,['class'=>'form-control','rows'=>'5']) !!}
                    </div>
                    <div class="form-group">
                         {!! Form::submit('Submit',['class'=>'btn btn-primary']) !!}
                    </div>

                    {!! Form::close() !!}



                </div>
                @endif
                <div class="row">
                @include('includes.form_error')
                </div>
                <hr>

                <!-- Posted Comments -->
       @if(count($comments)>0)

       
                @foreach($comments as $comment)
                    <div class="media">
                        <a class="pull-left" href="#">
                            <img class="media-object" height="40px" width="40px" src="{{ $comment->user->photo ? $comment->user->photo->file : 'http://identicon.org?t=$comment->user->name&s=32' }}" title="{{ $comment->user->name }}">
                        </a>
                        <div class="media-body">
                            <h4 class="media-heading">{{ $comment->user->name }}
                                <small title="{{ $comment->created_at }}">{{ $comment->created_at->diffForHumans() }}</small>
                            </h4>
                            <p> {{ $comment->body }}</p>

                            @if(count($comment->replies)>0)
                                @foreach($comment->replies as $reply)
                                    @if($reply->is_active == 1)

                                    

                                                <div class="media" style="margin-top:20px;" >
                                                        <a class="pull-left" href="#">
                                                            <img height="40px" width="40px" class="media-object" src="{{ $reply->user->photo ? $reply->user->photo->file : 'http://identicon.org?t=$reply->user->name&s=32' }}" title="{{ $reply->user->name }}">
                                                        </a>
                                                        <div class="media-body">
                                                            <h4 class="media-heading">{{ $reply->user->name }}
                                                                <small title="{{ $reply->created_at }}" >{{ $reply->created_at->diffForHumans() }}</small>
                                                            </h4>
                                                        <p>{{ $reply->body }}</p>
                                                        </div>
                                                </div>
                                                <div class="comment-reply-container">
                                                @if(Auth::check())
                                                <a href="javascript:;" class="toggle-reply">Reply</a>
                                                @endif  
                                                <div class="comment-reply">
                                               
                                                        {!! Form::open(['method'=>'POST','style'=>'margin-top:10px;','action'=>'CommentRepliesController@createReply']) !!}

                                                            <input type="hidden" name="comment_id" value="{{ $comment->id }}">

                                                            <div class="form-group ">

                                                            {!! Form::textarea('body',null,['class'=>'form-control','rows'=>'2']) !!}
                                                            </div>
                                                            <div class="form-group">
                                                            {!! Form::submit('Submit',['class'=>'btn btn-primary']) !!}
                                                            </div>

                                                        {!! Form::close() !!}
                                                </div>
                            </div>
                                    @endif
                                @endforeach

                            @endif

                        </div>
                    </div>
                @endforeach
                
        @endif

@stop



@section('scripts')
<script>

    $(".toggle-reply").click(function(){

            $(this).next().slideToggle("slow");

    })

</script>
@stop