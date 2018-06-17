@extends('layouts.admin')

@section('content')
<h1 class="page-header">Create Category</h1>

{!! Form::open(['method'=>'POST','action'=>'AdminCategoriesController@store','files'=>true]) !!}
    <div class="row">
        <div class="form-group">
            {!! Form::label('name','Name:') !!}
            {!! Form::text('name',null,['class'=>'form-control']) !!}
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
