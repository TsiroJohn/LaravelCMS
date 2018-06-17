@extends('layouts.admin')

@section('content')
@include('includes.tinyeditor')

<h1 class="page-header">Edit Post</h1>

                <div class=row>
                        <div class="col-md-3">
                        <img src="{{ $post->photo ? $post->photo->file : 'http://placehold.it/400x400'}}" alt="" class="img-responsive img-rounded">
                </div>
{!! Form::model($post,['method'=>'PATCH','action'=>['AdminPostsController@update',$post->id],'files'=>true]) !!}
                <div class="col-md-9">
                    <div class="form-group">
                        {!! Form::label('title','Title:') !!}
                        {!! Form::text('title',null,['class'=>'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('category_id','Category:') !!}
                        {!! Form::select('category_id', $categories,null,['class'=>'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('photo_id','Photo:') !!}
                        {!! Form::file('photo_id',null,['class'=>'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('body','Description:') !!}
                        {!! Form::textarea('body',null,['class'=>'form-control']) !!}
                    </div>

                    <div class="form-group pull-right">
                        {!! Form::button('<i class="fa fa-save fa-fw"></i><span>Update Post</span>',['type' => 'submit','class'=>'btn btn-primary ']) !!}
                    </div>  

                </div>
</div>
{!! Form::close() !!}
    <div class="row">
         @include('includes.form_error')
    </div>
@stop
