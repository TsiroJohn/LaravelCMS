@extends('layouts.admin')

@section('content')
<h1 class="page-header">Dashboard</h1>
            <div class="row">


                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-users fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">{{ $userCount }}</div>
                                    <div>Users</div>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('admin.users.index') }}">
                            <div class="panel-footer">
                                <span class="pull-left">View Users</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-pencil fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">{{ $postCount }}</div>
                                    <div>Posts</div>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('admin.posts.index') }}">
                            <div class="panel-footer">
                                <span class="pull-left">View Posts</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-comments fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">{{ $unapprovedComments }}</div>
                                    <div>Unapproved Comments</div>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('admin.comments.index') }}">
                            <div class="panel-footer">
                                <span class="pull-left">View Comments</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-archive fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">{{ $categoriesCount }}</div>
                                    <div>Categories</div>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('admin.categories.index') }}">
                            <div class="panel-footer">
                                <span class="pull-left">View Categories</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
    <div class="row">
            <div class="col-md-5">
                <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-bar-chart-o fa-fw"></i> Statistics
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <canvas id="myChart"></canvas>
                            </div>
                            <!-- /.panel-body -->
                </div>
                 
            </div>
            <div class="col-md-7">
                <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-pencil fa-fw"></i> Latest Posts
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <ul class="timeline">
                                @if($posts)
                                    @foreach($posts as $post)                              
                                        <li @if ($post->id % 2 == 1) class="timeline-inverted" @endif>
                                            <div class="timeline-badge  @if ($post->id % 2 == 1) primary @else success @endif "><i class="fa fa-pencil"></i>
                                            </div>
                                            <div class="timeline-panel">
                                                <div class="timeline-heading">
                                                    <h4 class="timeline-title">{{ $post->title }}</h4>
                                                    <p><small class="text-muted"><i class="fa fa-clock-o"></i> {{ $post->created_at->diffForHumans() }} by <a href="#" onclick="return false;">{{$post->user->name}}</a></small>
                                                    </p>
                                                </div>
                                                <div class="timeline-body">
                                                    <p>{!! str_limit($post->body,200) !!}</p>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                        <!-- /.panel-body -->
                    </div>
            </div>
    </div>
<hr>

@stop
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
<script>
var ctx = document.getElementById("myChart").getContext('2d');
var myChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: ["Posts", "Categories", "Comments"],
        datasets: [{
            label: 'Number of Posts',
            data: [{{ $postCount }}, {{ $categoriesCount }}, {{ $commentsCount }}],
            backgroundColor: [
                'rgba(255, 99, 132)',
                'rgba(54, 162, 235)',
                'rgba(255, 206, 86)',
               
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
               
            ],
            borderWidth: 1
        }]
    }
});
</script>
@stop