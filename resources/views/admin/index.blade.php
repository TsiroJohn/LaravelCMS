@extends('layouts.admin')

@section('content')
<h1 class="page-header">Dashboard</h1>
    
    <div class="row">
            <div class="col-md-6">
                 <canvas id="myChart"></canvas>
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