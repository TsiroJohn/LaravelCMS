@extends('layouts.admin')

@section('content')
<h1 class="page-header">Media</h1>


            <div class="row">

            <iframe id="lfm" src="{{ url('laravel-filemanager') }}" type="image" style="width: 100%; height: 500px; overflow: hidden; border: none;"></iframe>
          
</div>

@stop


@section('scripts')

 <script src="/vendor/laravel-filemanager/js/lfm.js"></script>
<script type="text/javascript">


var route_prefix = "{{ url(config('lfm.url_prefix')) }}";
$('#lfm').filemanager('image', {prefix: route_prefix});


</script>
@stop