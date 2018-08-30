<div class="col-md-4">

<!-- Blog Search Well -->
<div class="well">
    <h4>Blog Search</h4>
    <hr>
    <div class="input-group">
        <input type="text" class="form-control">
        <span class="input-group-btn">
            <button class="btn btn-default" type="button">
                <span class="glyphicon glyphicon-search"></span>
        </button>
        </span>
    </div>
    <!-- /.input-group -->
</div>
<!-- Blog Archives Well -->

<div class="well">
    <h4>Categories</h4>
    <hr>
    <div class="row">
        <div class="col-lg-12">
            <ul class="list-unstyled">
            @if($categories)
                @foreach($categories as $category)
                     <li><a href="{{ route('category',$category->id) }}">{{ $category->name }}</a>
                    </li>
                @endforeach
            @endif  
            </ul>
        </div>
      
    </div>
    <!-- /.row -->
</div>

<!-- Blog Categories Well -->
<div class="well">
    <h4>Archives</h4>
    <hr>
    <div class="row">
        <div class="col-lg-12">
            <ul class="list-unstyled">
            @if($archives)
                @foreach($archives as $stats)
                     <li><a href="/?month={{ $stats['month'] }}&year={{ $stats['year'] }}">{{ $stats['month']. ' ' . $stats['year'] }}</a>
                    </li>
                @endforeach
            @endif  
            </ul>
        </div>
      
    </div>
    <!-- /.row -->
</div>

<!-- Side Widget Well -->
<div class="well">
    <h4>Tags</h4>
    <hr>
    <div class="row">
        <div class="col-lg-12">
            <ul class="list-inline">
            @if($tags)
                @foreach($tags as $tag)
                     <li><a href="#"><span class="badge badge-primary">{{ $tag->name }} {{ $tag->posts->count() }}</span></a>
                    </li>
                @endforeach
            @endif  
            </ul>
        </div>
      
    </div>
    <!-- /.row -->
</div>

</div>