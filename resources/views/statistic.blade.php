@extends('layouts.app')
@section('content')
    {{-- <x-card>
        <div class="card" style="width: 50rem;">
           <br> <h3 class="text-center">The most rent films</h3><hr><br>
            <div class="chart-container">
                {!! $chart->container() !!}
            </div>
        </div>
        <br>
        <div class="card"  style="width: 50rem;">
            <br> <h3 class="text-center">The most active members</h3><hr><br>
             <div class="chart-container">
                 {!! $chart1->container() !!}
             </div>
         </div>

        {!! $chart->script() !!}
        {!! $chart1->script() !!}

    </x-card> --}}

    <x-card>
        <div class="container"></div>
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <br>
                    <h3 class="text-center">{{__('The most rent films')}}</h3>
                    <hr><br>
                    <div class="chart-container">
                        {!! $chart->container() !!}
                    </div>
                </div>
            </div>
            <div class="col-6">

                <div class="card">
                    <br>
                    <h3 class="text-center">{{__('The most active members')}}</h3>
                    <hr><br>
                    <div class="chart-container">
                        {!! $chart1->container() !!}
                    </div>
                </div>
            </div>
        </div>
        <br>

        <div class="row">
            <div class="col-6">
                <div class="card">
                    <br>
                    <h3 class="text-center">{{__('Earnings from film rentals per Month')}}</h3>
                    <hr><br>
                    <div class="chart-container">
                        {!! $chart2->container() !!}
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <br>
                    <h3 class="text-center">{{__('Earnings from delay per Month')}}</h3>
                    <hr><br>
                    <div class="chart-container">
                        {!! $chart3->container() !!}
                    </div>
                </div>
            </div>
        </div>
        <br>

        <div class="row">
            <div class="col-6">
                <div class="card">
                    <br>
                    <h3 class="text-center">{{__('Total earnings per Month')}}</h3>
                    <hr><br>
                    <div class="chart-container">
                        {!! $chart4->container() !!}
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <br>
                    <h3 class="text-center">{{__('Total earnings')}}</h3>
                    <hr><br>
                    <div class="chart-container">
                        {!! $chart5->container() !!}
                    </div>
                </div>
            </div>
        </div>

        {!! $chart->script() !!}
        {!! $chart1->script() !!}
        {!! $chart2->script() !!}
        {!! $chart3->script() !!}
        {!! $chart4->script() !!}
        {!! $chart5->script() !!}

    </x-card>

    <style>
        .chart-container {
            background-color: rgba(245, 245, 245, 0.649);

        }

        body {
            background: #000080d3;
        }
    </style>
@endsection
