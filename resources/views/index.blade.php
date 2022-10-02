@extends('layout')

@section('content')
<style>
    label.error {
        color: red;
        font-size: 14px;
    }

    .alert-message {
        color: red;
        font-size: 14px;
    }

    .uper {
        margin-top: 40px;
    }

    .left {
        margin-block-start: 40px;
    }

    #overlay {
        position: fixed;
        top: 0;
        z-index: 100;
        width: 100%;
        height: 100%;
        display: none;
        background: rgba(0, 0, 0, 0.6);
    }

    .cv-spinner {
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .spinner {
        width: 40px;
        height: 40px;
        border: 4px #ddd solid;
        border-top: 4px #2e93e6 solid;
        border-radius: 50%;
        animation: sp-anime 0.8s infinite linear;
    }

    @keyframes sp-anime {
        100% {
            transform: rotate(360deg);
        }
    }

    .is-hide {
        display: none;
    }
</style>
<div class="container">
    <!-- Form -->
    <div class="uper">

        <form method="post" action="{{ url('store-form') }}" id="myForm">
            @csrf
            <div class="row">
                <div class="col-xl-8 m-auto">
                    <div class="card shadow">
                        <div class="card-header">
                            <h4 class="text-center font-weight-bold">Filters </h4>
                        </div>

                        <div class="card-body pl-4 pr-4">

                            @if(Session::has("success"))
                            <div class="alert alert-success">
                                {{Session::get("success")}}
                            </div>
                            @elseif(Session::has("failed"))
                            {{Session::get("failed")}}
                            @endif


                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="symbol">Company Symbol</label>
                                        <input type="text" id="symbol" name="symbol" class="form-control" required="">
                                        <div class="alert-message" id="symbolError"></div>

                                    </div>
                                </div>

                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="text" id="email" name="email" class="form-control" required="">
                                        <div class="alert-message" id="emailError"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="start_date">Start Date</label>
                                        <input type="text" id="start_date" name="start_date" class="form-control" required="">
                                        <div class="alert-message" id="start_dateError"></div>
                                    </div>
                                </div>

                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="end_date">End Date</label>
                                        <input type="text" id="end_date" name="end_date" class="form-control" required="">
                                        <div class="alert-message" id="end_dateError"></div>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Fetch Data</button>

                        </div>
                    </div>
                </div>


        </form>
    </div>

    <!-- Loader -->
    <div id="overlay">
        <div class="cv-spinner">
            <span class="spinner"></span>
        </div>
    </div>

    <!-- Show Data -->
    <div class="row" id="content">

        <!-- Chart -->
        <div class="col-xl-5 left">
            <div class="card shadow">
                <div class="card-header">
                    <h4 class="text-center font-weight-bold">CHART </h4>
                </div>
                <div class="panel-body">
                    <canvas id="myChart" height="700" width="1400"></canvas>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="col-xl-7 left">
            <div class="card shadow">
                <div class="card-header">
                    <h4 class="text-center font-weight-bold">List </h4>
                </div>
                <!-- <div class="panel-body"> -->
                <div class="table-responsive text-center">
                    <table id="myTable" class="table table-theme table-row v-middle" data-plugin="dataTable">
                        <!-- <table id="myTable" height="380" width="800" class="display" style="width:100%"> -->
                        <thead>
                            <tr>
                                <th><span class="text-muted d-none d-sm-block">Date</span></th>
                                <th><span class="text-muted d-none d-sm-block">Open</span></th>
                                <th><span class="text-muted d-none d-sm-block">High</span></th>
                                <th><span class="text-muted d-none d-sm-block">Low</span></th>
                                <th><span class="text-muted d-none d-sm-block">Close</span></th>
                                <th><span class="text-muted d-none d-sm-block">Volume</span></th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <!-- </div> -->
            </div>
        </div>

    </div>
</div>


<script type="text/javascript">
    $('#content').hide();
    let table = null;
    let chart = null;
    $("#start_date").datepicker({
        dateFormat: "mm/dd/yy'",
        numberOfMonths: 1,
        maxDate: '0d',
        onSelect: function(selectedDate) {
            var end_date = $('#end_date');
            var startDate = $(this).datepicker('getDate');
            var minDate = $(this).datepicker('getDate');
            end_date.datepicker('option', 'minDate', minDate);
        }
    });

    $("#end_date").datepicker({
        dateFormat: "mm/dd/yy'",
        maxDate: '0d',
    });
    $(document).ajaxSend(function() {
        $("#overlay").fadeIn(300);
    });
    $('#myForm').on('submit', function(e) {

        var isValid = $("#myForm").valid();
        if (!isValid) {
            e.preventDefault(); //prevent the default action
            return;
        }
        e.preventDefault();
        fetchData();
    });

    $(document).ready(function() {
        $("#myForm").validate({
            rules: {
                symbol: {
                    required: true,

                },
                start_date: {
                    required: true,


                },
                end_date: {
                    required: true,


                },
                email: {
                    required: true,
                    email: 'email:rfc,dns',

                },

            },

            messages: {
                symbol: {
                    required: 'symbol is required',

                },
                start_date: {
                    required: 'Start date  is required',


                },
                end_date: {
                    required: 'End date is required',


                },
                email: {
                    required: 'Email is required',
                    email: 'Email is not valid',

                },
            }
        });
    });



    function fetchData() {
        $('#content').hide();
        // let dataInput=
        $.ajax({
            type: "POST",
            url: "{{ route('fetchData') }}",
            data: $("#myForm").serialize(),
            success: function(response) {
                console.log('res', response);
                let opens = [];
                let closes = [];
                let labels = [];
                let tableData = [];
                response.data.prices.forEach((elem, i) => {
                    opens.push(elem.open)
                    closes.push(elem.close)
                    let date = new Date(elem.date * 1000).toLocaleDateString("default")
                    labels.push(date)
                    let temp = {
                        ...elem,
                        formatDate: date
                    }

                    tableData.push(temp)
                });
                $('#content').show();

                var ctx = $('#myChart');
                var config = {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                                label: 'Open',
                                type: 'line',
                                data: opens,
                                backgroundColor: 'rgba(75, 33, 192, 1)',

                            },
                            {
                                label: 'Close',
                                type: 'line',
                                data: closes,
                                backgroundColor: 'rgba(75, 192, 192, 1)',

                            }
                        ]
                    }
                };
                if (chart) {
                    chart.destroy();
                }
                chart = new Chart(ctx, config);
                console.log('tableData', tableData);
                if (table) {
                    table.destroy();
                }

                table = $('#myTable').DataTable({
                    // paging: false,
                    // searching: false,
                    data: tableData,
                    serverSide: false,
                    columns: [{
                            data: 'formatDate'
                        },
                        {
                            data: 'open'
                        },
                        {
                            data: 'high'
                        },
                        {
                            data: 'low'
                        },
                        {
                            data: 'close'
                        },
                        {
                            data: 'volume'
                        },
                    ]
                });

                console.log('finish');

            },
            error: function(xhr) {
                setTimeout(function() {
                    $("#overlay").fadeOut(300);
                }, 500);

                let response = JSON.parse(xhr.responseText);
                console.log('xhr', response);
                for (var k in response.errors) {
                    $(`#${k}Error`).text(response.errors[k][0]);
                }
              
            }
        }).done(function() {
            setTimeout(function() {
                $("#overlay").fadeOut(300);
            }, 500);
        });;
    }
</script>
@endsection
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script> -->