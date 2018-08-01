@extends('layouts.admin')

@section('content')
    @include('includes.tinyeditor')
<h1 class="page-header">Create Post</h1>

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
            {!! Form::label('tags','Tags:') !!}
            {!! Form::select('tags[]',$tags,null,['class'=>'form-control select2-multi','multiple'=>'multiple']) !!}
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
@section('scripts')
<script>

$(".select2-multi").select2({
  theme: "bootstrap",
  matcher: matchCustom
});


function matchCustom(params, data) {
    // If there are no search terms, return all of the data
    if ($.trim(params.term) === '') {
      return data;
    }

    // Do not display the item if there is no 'text' property
    if (typeof data.text === 'undefined') {
      return null;
    }

    // `params.term` should be the term that is used for searching
    // `data.text` is the text that is displayed for the data object
    if (data.text.indexOf(params.term) > -1) {
      var modifiedData = $.extend({}, data, true);
      modifiedData.text += ' (matched)';

      // You can return modified objects from here
      // This includes matching the `children` how you want in nested data sets
      return modifiedData;
    }

    // Return `null` if the term should not be displayed
    return null;
}
</script>
@stop
