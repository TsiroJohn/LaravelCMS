<div class="col-md-4">

<!-- Blog Search Well -->
<div class="well">
    <h4>Blog Search</h4>
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

<!-- Blog Categories Well -->
<div class="well">
    <h4>Categories</h4>
    <div class="row">
        <div class="col-lg-12">
            <ul class="list-unstyled">
            @if($categories)
                @foreach($categories as $category)
                     <li><a href="#">{{ $category->name }}</a>
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
    <div class="row">
        <div class="col-lg-12">
            <ul class="list-inline">
            @if($tags)
                @foreach($tags as $tag)
                     <li><a href="#"><span class="badge badge-secondary">{{ $tag->name }}</span></a>
                    </li>
                @endforeach
            @endif  
            </ul>
        </div>
      
    </div>
    <!-- /.row -->
</div>

</div>