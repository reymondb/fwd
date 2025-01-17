@extends('dashboard.dashboardlayout')
@section('title', 'Dashboard')

@section('content')

        <main>
            <div class="container-fluid">
                <h1 class="mt-4">Dashboard</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Total Number Of Lead Rows: <b id="totalz">{{number_format($total[0]->total)}}</b>
                        @csrf
                        <select name="campaignid" id="campaignid" onchange="refreshCharts()">
                            <option value="">Select Campaign</option>
                            @foreach ($campaigns as $c)
                                <option value="{{$c->id}}">{{$c->CampaignName}}</option>
                            @endforeach
                        </select>
                        <img src="images/blue loading.gif" class="loading6"  height="30">
                    </li>
                </ol>
                
               
            </div>
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <!-- Pie CHART -->
                            <div class="card card-primary">
                                <div class="card-header" >
                                    
                                    <div style="display: inline;">
                                    Campaigns (Total: <span id="campaign_total">0</span>) 
                                    </div>
                                    @if( Auth::user()->role ==1)
                                    <div style="display: inline-block"">
                                        <button class="btn-primary btn" onclick="refreshChart1()" style="font-size: 12px;">Refresh Data</button>
                                        <img src="images/blue loading.gif" class="loading1"  height="30">
                                    </div>
                                    @endif
                                </div>
                                <div class="card-body">
                                    <div class="chart" id="resetter1"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                                        <canvas id="campaignstotals" height="280" width="600"></canvas>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <div class="col-md-6">    
                            <!-- Pie CHART -->
                            <div class="card card-primary">
                                <div class="card-header">
                                    <div style="display: inline;">
                                        From Supplier (Total: <span id="supplier_total">0</span>)
                                    </div>
                                    @if( Auth::user()->role ==1)
                                    <div style="display: inline-block"">
                                        <button class="btn-primary btn" onclick="refreshChart2()" style="font-size: 12px;">Refresh Data</button>
                                        <img src="images/blue loading.gif" class="loading2"  height="30">
                                    </div>
                                    @endif                                
                                </div>
                                <div class="card-body">
                                    <div class="chart" id="resetter2"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                                        <canvas id="supplierchart" height="280" width="600"></canvas>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>      
                    </div>
                    <div class="row" style="padding-top:20px;">
                        <div class="col-md-6">    
                            <!-- Pie CHART -->
                            <div class="card card-primary">
                                <div class="card-header">
                                    <div style="display: inline;">
                                        Total Blanks (Total: <span id="blank_total">0</span>)
                                    </div>
                                    @if( Auth::user()->role ==1)
                                    <div style="display: inline-block"">
                                        <button class="btn-primary btn" onclick="refreshChart3()" style="font-size: 12px;">Refresh Data</button>
                                        <img src="images/blue loading.gif" class="loading3"  height="30">
                                    </div>
                                    @endif
                                </div>
                                <div class="card-body">
                                    <div class="chart" id="resetter3"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                                            <canvas id="blanktotals" height="280" width="600"></canvas>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>    
                        <div class="col-md-6">    
                            <!-- Pie CHART -->
                            <div class="card card-primary">
                                <div class="card-header">
                                    <div style="display: inline;">
                                        Total Records Containing (Total: <span id="noblank_total">0</span>)
                                    </div>
                                    @if( Auth::user()->role ==1)
                                    <div style="display: inline-block"">
                                        <button class="btn-primary btn" onclick="refreshChart4()" style="font-size: 12px;">Refresh Data</button>
                                        <img src="images/blue loading.gif" class="loading4"  height="30">
                                    </div>
                                    @endif
                                </div>
                                <div class="card-body">
                                    <div class="chart" id="resetter4"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                                        <canvas id="noblanktotals" height="280" width="600"></canvas>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>      
                    </div>
                    <div class="row" style="padding-top:20px;">
                        <div class="col-md-6">    
                            <!-- Pie CHART -->
                            <div class="card card-primary">
                                <div class="card-header">
                                    <div style="display: inline;">
                                        DNC Dashboard
                                        @if( Auth::user()->role ==1)
                                        <div style="display: inline-block"">
                                            <a href="/dnc/exportdnc/1" id="downloadLink2" class="btn btn-primary" style="font-size: 12px;" download><i class="fas fa-download"></i> 5 days</a>
                                            <a href="/dnc/exportdnc/2" id="downloadLink2" class="btn btn-primary" style="font-size: 12px;" download><i class="fas fa-download"></i> 30 days</a>
                                            <a href="/dnc/exportdnc/3" id="downloadLink2" class="btn btn-primary" style="font-size: 12px;" download><i class="fas fa-download"></i> 60 days</a>
                                            <a href="/dnc/exportdnc/4" id="downloadLink2" class="btn btn-primary" style="font-size: 12px;" download><i class="fas fa-download"></i> 60 days++</a>
                                            <button class="btn-primary btn" onclick="refreshChart5()" style="font-size: 12px;">Refresh Data</button>
                                        <img src="images/blue loading.gif" class="loading5"  height="30">
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="chart" id="resetter5"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                                        <canvas id="dnctotals" height="280" width="600"></canvas>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>    
                    </div>
                </div>
                <!-- /.row -->
            </section>
        </main>

          <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.js" charset="utf-8"></script>
          <script src="https://cdn.jsdelivr.net/gh/emn178/chartjs-plugin-labels/src/chartjs-plugin-labels.js" charset="utf-8"></script>
          

        <script>
            function numberWithCommas(x) {
                return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }

            loadChart1();
            loadChart2();
            loadChart3();
            loadChart4();
            
            loadChart5();
            
            
            $(".loading1").hide();
            $(".loading2").hide();
            $(".loading3").hide();
            $(".loading4").hide();
            $(".loading5").hide();
            $(".loading6").hide();
            

            function refreshCharts(){
                var campaignid = $("#campaignid").val();
                $(".loading6").show();
                
                console.log(campaignid);
                loadChart1(campaignid);
                loadChart2(campaignid);
                loadChart3(campaignid);
                loadChart4(campaignid);
                getCampaignTotals(campaignid);
            }

            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('input[name=_token]').val()
                }
            });
            function refreshChart1(){
                $(".loading1").show();
                $.ajax({
                    url: "/optimizeChart1",
                    type: 'GET',
                    contentType: false, // The content type used when sending data to the server.
                    cache: false, // To unable request pages to be cached
                    processData: false,
                    success: function (data) {
                        console.log(data);
                        $("#updated1").html(data);
                        loadChart1();
                        $(".loading1").hide();                
                    }
                });
            }
            function refreshChart2(){
                $(".loading2").show();
                
                $.ajax({
                    url: "/optimizeChart2",
                    type: 'GET',
                    contentType: false, // The content type used when sending data to the server.
                    cache: false, // To unable request pages to be cached
                    processData: false,
                    success: function (data) {
                        console.log(data);
                        $("#updated2").html(data);
                        loadChart2();
                        $(".loading2").hide();                
                    }
                });
            }
            
            function refreshChart3(){
                $(".loading3").show();
                
                $.ajax({
                    url: "/optimizeChart3",
                    type: 'GET',
                    contentType: false, // The content type used when sending data to the server.
                    cache: false, // To unable request pages to be cached
                    processData: false,
                    success: function (data) {
                        console.log(data);
                        $("#updated3").html(data);
                        loadChart3();
                        $(".loading3").hide();                
                    }
                });
            }

            function refreshChart4(){
                $(".loading4").show();
                
                $.ajax({
                    url: "/optimizeChart4",
                    type: 'GET',
                    contentType: false, // The content type used when sending data to the server.
                    cache: false, // To unable request pages to be cached
                    processData: false,
                    success: function (data) {
                        console.log(data);
                        $("#updated4").html(data);
                        loadChart4();
                        $(".loading4").hide();                
                    }
                });
            }

            
            function refreshChart5(){
                $(".loading5").show();
                
                $.ajax({
                    url: "/optimizeChart5",
                    type: 'GET',
                    contentType: false, // The content type used when sending data to the server.
                    cache: false, // To unable request pages to be cached
                    processData: false,
                    success: function (data) {
                        console.log(data);
                        $("#updated5").html(data);
                        loadChart5();
                        $(".loading5").hide();                
                    }
                });
            }
            
            function getCampaignTotals(campaignids){
                $.ajax({
                    url: "/getCampaignTotals?campaignid="+campaignids,
                    type: 'GET',
                    contentType: false, // The content type used when sending data to the server.
                    cache: false, // To unable request pages to be cached
                    processData: false,
                    success: function (data) {
                        console.log(data);
                        $("#totalz").html(numberWithCommas(data));        
                    }
                });
            }

            function loadChart1(campaignids){
                $(".loading1").show();
                $('#campaignstotals').remove(); 
                $('#resetter1').append('<canvas id="campaignstotals" height="280" width="600"><canvas>');
                var url = "/leadschart?campaignid="+campaignids;
                var Totals = new Array();
                var Labels = new Array();
                var campaigntotals=0;
                $(document).ready(function(){
                    $.get(url, function(response){
                        response.forEach(function(data){
                            console.log(data);
                            Totals.push(data.total);
                            Labels.push(data.CampaignName);
                            campaigntotals = campaigntotals + data.total;
                        });
                        $("#campaign_total").html(numberWithCommas(campaigntotals));
                        var ctx = document.getElementById("campaignstotals").getContext('2d');
                        if(ctx){
                            console.log("exist");
                        }
                        var myPieChart = new Chart(ctx, {
                            type: 'doughnut',
                            data:{
                                datasets: [{
                                    data: Totals,
                                    backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
                                }],

                                // These labels appear in the legend and in the tooltips when hovering different arcs
                                labels: Labels
                            },                   
                            options: {
                                legend: {
                                    display: true,
                                    position: 'left',
                                },
                                tooltips: {
                                    enabled: false
                                },
                                plugins: {
                                    labels: {
                                        render: 'percentage',
                                        fontColor: '#FFFFFF',
                                        precision: 2
                                    }
                                }
                            }

                        
                        });
                    }).always(function (data) {
                        $(".loading1").hide();
                        });
                    
                });
            }

            function loadChart3(campaignids){
                $(".loading3").show();
                $('#blanktotals').remove(); 
                $('#resetter3').append('<canvas id="blanktotals" height="280" width="600"><canvas>');
                var url2 = "/blankchart?campaignid="+campaignids;;
                var BlankTotals = new Array();
                var BlankLabels = new Array();
                var BlankPercentage = new Array();
                var blank_total = 0;
                $(document).ready(function(){
                    $.get(url2, function(response){
                        response.forEach(function(data){
                            console.log(data);
                            BlankTotals.push(data.totals);
                            BlankLabels.push(data.Label);
                            BlankPercentage.push(data.percentage);
                            blank_total = blank_total + data.totals;
                        });
                        $("#blank_total").html(numberWithCommas(blank_total));
                        var ctx = document.getElementById("blanktotals").getContext('2d');
                        var myPieChart = new Chart(ctx, {
                            type: 'doughnut',
                            data:{
                                datasets: [{
                                    data: BlankTotals,
                                    backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
                                }],

                                // These labels appear in the legend and in the tooltips when hovering different arcs
                                labels: BlankLabels
                            },                        
                            options: {
                                legend: {
                                    display: true,
                                    position: 'left',
                                },
                                tooltips: {
                                    enabled: false
                                },
                                plugins: {
                                    labels: {
                                        render: 'percentage',
                                        fontColor: '#FFFFFF',
                                        precision: 2
                                    }
                                }
                            }
                        
                        });
                    }).always(function (data) {
                        $(".loading3").hide();
                        });;
                });
            }
            
            function loadChart2(campaignids){
                $(".loading2").show();
                $('#supplierchart').remove(); 
                $('#resetter2').append('<canvas id="supplierchart" height="280" width="600"><canvas>');
                var url3 = "/supplierchart?campaignid="+campaignids;
                var supplierTotals = new Array();
                var supplierLabels = new Array();
                var supplier_total = 0;
                $(document).ready(function(){
                    $.get(url3, function(response){
                        response.forEach(function(data){
                            console.log(data);
                            supplierTotals.push(data.totals);
                            supplierLabels.push(data.supplier);
                            supplier_total = supplier_total + data.totals;
                        });
                        $("#supplier_total").html(numberWithCommas(supplier_total));
                        var ctx = document.getElementById("supplierchart").getContext('2d');
                        var myPieChart = new Chart(ctx, {
                            type: 'doughnut',
                            data:{
                                datasets: [{
                                    data: supplierTotals,
                                    backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
                                }],

                                // These labels appear in the legend and in the tooltips when hovering different arcs
                                labels: supplierLabels
                            },                        
                            options: {
                                legend: {
                                    display: true,
                                    position: 'left',
                                },
                                tooltips: {
                                    enabled: false
                                },
                                plugins: {
                                    labels: {
                                        render: 'percentage',
                                        fontColor: '#FFFFFF',
                                        precision: 2
                                    }
                                }
                            }
                        
                        });
                    }).always(function (data) {
                        $(".loading2").hide();
                        });
                });
            }

            function loadChart4(campaignids){
                $(".loading4").show();
                $(".loading5").show();
                $('#noblanktotals').remove(); 
                $('#resetter4').append('<canvas id="noblanktotals" height="280" width="600"><canvas>');
                var url2 = "/noblankchart?campaignid="+campaignids;
                var noBlankTotals = new Array();
                var noBlankLabels = new Array();
                var noBlankPercentage = new Array();
                var noblank_total = 0;
                $(document).ready(function(){
                    $.get(url2, function(response){
                        response.forEach(function(data){
                            console.log(data);
                            noBlankTotals.push(data.totals);
                            noBlankLabels.push(data.Label);
                            noBlankPercentage.push(data.percentage);
                            noblank_total = noblank_total + data.totals;
                        });
                        $("#noblank_total").html(numberWithCommas(noblank_total));
                        var ctx = document.getElementById("noblanktotals").getContext('2d');
                        var myPieChart = new Chart(ctx, {
                            type: 'doughnut',
                            data:{
                                datasets: [{
                                    data: noBlankTotals,
                                    backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
                                }],

                                // These labels appear in the legend and in the tooltips when hovering different arcs
                                labels: noBlankLabels
                            },                        
                            options: {
                                legend: {
                                    display: true,
                                    position: 'left',
                                },
                                tooltips: {
                                    enabled: false
                                },
                                plugins: {
                                    labels: {
                                        render: 'percentage',
                                        fontColor: '#FFFFFF',
                                        precision: 2
                                    }
                                }
                            }
                        
                        });
                    }).always(function (data) {
                        $(".loading4").hide();
                        $(".loading5").hide();
                    });
                });
                
                
            }

            function loadChart5(){
                var url5 = "/dncchart";
                var DNCtotals = new Array();
                var DncLabels = new Array();
                var DncPercentage = new Array();
                var DNC_total = 0;
                $(document).ready(function(){
                    $.get(url5, function(response){
                        response.forEach(function(data){
                            console.log(data);
                            DNCtotals.push(data.totals);
                            DncLabels.push(data.Label);
                            DncPercentage.push(data.percentage);
                            DNC_total = DNC_total + data.totals;
                        });
                        $("#dnc_total").html(numberWithCommas(DNC_total));
                        var ctx = document.getElementById("dnctotals").getContext('2d');
                        var myPieChart = new Chart(ctx, {
                            type: 'doughnut',
                            data:{
                                datasets: [{
                                    data: DNCtotals,
                                    backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
                                }],

                                // These labels appear in the legend and in the tooltips when hovering different arcs
                                labels: DncLabels
                            },                        
                            options: {
                                legend: {
                                    display: true,
                                    position: 'left',
                                },
                                tooltips: {
                                    enabled: false
                                },
                                plugins: {
                                    labels: {
                                        render: 'percentage',
                                        fontColor: '#FFFFFF',
                                        precision: 2
                                    }
                                }
                            }
                        
                        });
                    }).always(function (data) {
                        $(".loading4").hide();
                        $(".loading5").hide();
                    });
                });
            }
            
            


        </script>
@stop