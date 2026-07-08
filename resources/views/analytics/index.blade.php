@extends('layouts.app')

@section('content')

<h2>
    Analytics
</h2>

<div class="card card-custom p-4">

    <canvas
        id="trendChart"
        height="120"
    ></canvas>

</div>

@endsection

@section('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

fetch('/dashboard/trend')

.then(response => response.json())

.then(data => {

    new Chart(
        document.getElementById(
            'trendChart'
        ),
        {
            type:'line',

            data:{
                labels:
                    data.labels,

                datasets:[
                    {
                        label:
                            'Average Risk',

                        data:
                            data.values
                    }
                ]
            }
        }
    );

});

</script>

@endsection