@extends('layouts.admin')

@section('content')
<h1 class="page-header">Update Category</h1>

{!! Form::model($category,['method'=>'PATCH','action'=>['AdminCategoriesController@update',$category->id]]) !!}

    <div class="row">
        <div class="form-group">
            {!! Form::label('name','Name:') !!}
            {!! Form::text('name',null,['class'=>'form-control']) !!}
        </div>
        <div class="form-group pull-right">
            {!! Form::button('<i class="fa fa-save fa-fw"></i><span>Update Category</span>',['type' => 'submit','class'=>'btn btn-primary ']) !!}
        </div>  

    </div>
{!! Form::close() !!}
    <div class="row">
         @include('includes.form_error')
    </div>
@stop
