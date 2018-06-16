@extends('layouts.admin')

@section('content')
    @include('includes.tinyeditor')
<h1>Create Post</h1>

{!! Form::open(['method'=>'POST','action'=>'AdminPostsController@store','files'=>true]) !!}
    <div class="row">
        <div class="form-group">
            {!! Form::label('title','Title:') !!}
            {!! Form::text('title',null,['class'=>'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('category_id','Category:') !!}
            {!! Form::select('category_id',[''=>'Choose Options'] + $categories,null,['class'=>'form-control']) !!}
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
            {!! Form::button('<i class="fa fa-save fa-fw"></i><span>Create Post</span>',['type' => 'submit','class'=>'btn btn-primary ']) !!}
        </div>  

    </div>
{!! Form::close() !!}
    <div class="row">
         @include('includes.form_error')
    </div>
@stop
