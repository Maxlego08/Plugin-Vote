@extends('admin.layouts.admin')

@section('title', trans('vote::admin.statistics.title'))

@section('content')

    <!-- All -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div
                                class="text-xs font-weight-bold text-primary text-uppercase mb-1">{{ trans('vote::admin.statistics.stats.global') }}</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{numberFormat($voteAmount)}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-vote-yea fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Month -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div
                                class="text-xs font-weight-bold text-primary text-uppercase mb-1">{{ trans('vote::admin.statistics.stats.month') }}</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{numberFormat($voteAmountMonth)}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-vote-yea fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Week -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div
                                class="text-xs font-weight-bold text-primary text-uppercase mb-1">{{ trans('vote::admin.statistics.stats.week') }}</div>
                            <div
                                class="h5 mb-0 font-weight-bold text-gray-800">{{ numberFormat($voteAmountWeek) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-vote-yea fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Day -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div
                                class="text-xs font-weight-bold text-primary text-uppercase mb-1">{{ trans('vote::admin.statistics.stats.day') }}</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ numberFormat($voteAmountDay) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-vote-yea fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row">

        <div class="col-xl-12 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ trans('vote::admin.statistics.stats.month-char') }}</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="newVoteChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-12 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ trans('vote::admin.statistics.stats.year-char') }}</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="newVoteChartYear"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@push('footer-scripts')
    <script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>
    <script>

        Chart.defaults.global.defaultFontColor = '#858796';

        //Month
        const voteMonthKeys = @json($voteMonth->keys());
        const voteMonthValues = @json($voteMonth->values());

        //Year
        const voteYearKeys = @json($voteYear->keys());
        const voteYearValues = @json($voteYear->values());
        const voteLastYearValues = @json($voteLastYear->values());

        new Chart(document.getElementById('newVoteChart'), {
            type: 'line',
            data: {
                labels: voteMonthKeys,
                datasets: [{
                    label: 'Votes',
                    lineTension: 0.3,
                    backgroundColor: "rgba(78, 115, 223, 0.05)",
                    borderColor: "rgba(78, 115, 223, 1)",
                    pointRadius: 3,
                    pointBackgroundColor: "rgba(78, 115, 223, 1)",
                    pointBorderColor: "rgba(78, 115, 223, 1)",
                    pointHoverRadius: 3,
                    pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                    pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                    pointHitRadius: 10,
                    pointBorderWidth: 2,
                    data: voteMonthValues,
                }],
            },
            options: {
                maintainAspectRatio: false,
                scales: {
                    xAxes: [{
                        /*time: {
                            unit: 'date'
                        },*/
                        gridLines: {
                            display: false,
                            drawBorder: false
                        },
                        /*ticks: {
                            maxTicksLimit: 7
                        }*/
                    }],
                    yAxes: [{
                        /*ticks: {
                            maxTicksLimit: 5,
                            padding: 10,
                        },*/
                        gridLines: {
                            color: "rgb(234, 236, 244)",
                            zeroLineColor: "rgb(234, 236, 244)",
                            drawBorder: false,
                            borderDash: [2],
                            zeroLineBorderDash: [2]
                        }
                    }],
                },
                legend: {
                    display: false
                },
                tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    titleMarginBottom: 10,
                    titleFontColor: '#6e707e',
                    titleFontSize: 14,
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 20,
                    yPadding: 20,
                    displayColors: false,
                    intersect: false,
                    mode: 'index',
                    caretPadding: 10,
                }
            }
        });

        //Years
        new Chart(document.getElementById('newVoteChartYear'), {
            type: 'line',
            data: {
                labels: voteYearKeys,
                datasets: [{
                    label: '{{now()->year}}',
                    lineTension: 0.3,
                    backgroundColor: "rgba(78, 115, 223, 0.05)",
                    borderColor: "rgba(78, 115, 223, 1)",
                    pointRadius: 3,
                    pointBackgroundColor: "rgba(78, 115, 223, 1)",
                    pointBorderColor: "rgba(78, 115, 223, 1)",
                    pointHoverRadius: 3,
                    pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                    pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                    pointHitRadius: 10,
                    pointBorderWidth: 2,
                    data: voteYearValues,
                }, {
                    label: '{{now()->subYear()->year}}',
                    lineTension: 0.3,
                    backgroundColor: "rgba(213,115,223,0.05)",
                    borderColor: "rgb(104,196,223,1)",
                    pointRadius: 3,
                    pointBackgroundColor: "rgba(104,196,223, 1)",
                    pointBorderColor: "rgba(104,196,223, 1)",
                    pointHoverRadius: 3,
                    pointHoverBackgroundColor: "rgba(104,196,223, 1)",
                    pointHoverBorderColor: "rgba(104,196,223, 1)",
                    pointHitRadius: 10,
                    pointBorderWidth: 2,
                    data: voteLastYearValues,
                }
                ],
            },
            options: {
                maintainAspectRatio: false,
                scales: {
                    xAxes: [{
                        /*time: {
                            unit: 'date'
                        },*/
                        gridLines: {
                            display: false,
                            drawBorder: false
                        },
                        /*ticks: {
                            maxTicksLimit: 7
                        }*/
                    }],
                    yAxes: [{
                        /*ticks: {
                            maxTicksLimit: 5,
                            padding: 10,
                        },*/
                        gridLines: {
                            color: "rgb(234, 236, 244)",
                            zeroLineColor: "rgb(234, 236, 244)",
                            drawBorder: false,
                            borderDash: [2],
                            zeroLineBorderDash: [2]
                        }
                    }],
                },
                legend: {
                    display: false
                },
                tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    titleMarginBottom: 10,
                    titleFontColor: '#6e707e',
                    titleFontSize: 14,
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 20,
                    yPadding: 20,
                    displayColors: false,
                    intersect: false,
                    mode: 'index',
                    caretPadding: 10,
                }
            }
        });

    </script>
@endpush
