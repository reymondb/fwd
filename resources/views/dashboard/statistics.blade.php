@extends('dashboard.dashboardlayout')
@section('title', 'Dashboard > Content')

@section('content')
        <main>
            <div class="container-fluid">
                <h2 class="mt-4">Lead Statistics</h2>
                
                <div class="card mb-4">
                    <div class="card-header"><i class="fas fa-table mr-1"></i>Select Campaign: 
                        @csrf
                        <select name="campaign_id" id="campaign">
                            <option value="">Select Campaign</option>
                            @foreach ($campaigns as $c)
                                <option value="{{$c->id}}">{{$c->CampaignName}}</option>
                            @endforeach
                        </select> 

                        Select List ID:
                        <select id="list_id" name="list_id"></select>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" >
                            <table class='table table-bordered table-hover' id="leadstats">
                                <thead>
                                    <tr><th colspan='8'>From vicidial_list</th></tr>
                                    <tr>
                                        <th colspan=3></th>
                                        <th colspan='2'>Dial Attempt Pass #1</th>
                                        <th colspan='2'>Dial Attempt Pass #2</th>
                                        <th colspan='2'>Dial Attempt Pass #3</th>
                                        <th colspan='2'>Dial Attempt Pass #4</th>
                                        <th colspan='2'>Dial Attempt Pass #5</th>
                                        <th colspan='2'>Dial Attempt Pass > #5</th>
                                    </th>
                                    <tr>
                                        <th style='width:50px'>Status</th>
                                        <th style='width:100px'>Status Name</th>
                                        <th style='width:200px'>Total Count</th>                                        
                                        <th style='width:100px'>COUNT</th>
                                        <th style='width:200px'>LEAD %</th>                                     
                                        <th style='width:100px'>COUNT</th>
                                        <th style='width:200px'>LEAD %</th>                                     
                                        <th style='width:100px'>COUNT</th>
                                        <th style='width:200px'>LEAD %</th>                                     
                                        <th style='width:100px'>COUNT</th>
                                        <th style='width:200px'>LEAD %</th>                                     
                                        <th style='width:100px'>COUNT</th>
                                        <th style='width:200px'>LEAD %</th>                                     
                                        <th style='width:100px'>COUNT</th>
                                        <th style='width:200px'>LEAD %</th>
                                    </tr>
                                </thead>                                
                                <tbody id="leadstatslists">

                                </tbody>
                            </table>
                        </div>
                        <br>
                        <div class="table-responsive" id="reportholderlogs">
                            
                        </div>
                    </div>
                </div>
               
            </div>
        </main>
       

          
@stop

@section('js')

    <style>
        .filter_inputs{
            font-size:14px;
        }
    </style>
    <script>
            $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('input[name=_token]').val()
            }
        });
        $(document).ready(function(){
            $("#campaign").on("change",function(){
                $.ajax({
                    url: "/getleadlists?campaignid="+$("#campaign").val(),
                    type: 'GET',
                    contentType: false, // The content type used when sending data to the server.
                    cache: false, // To unable request pages to be cached
                    processData: false,
                    success: function (data) {
                        $('#list_id').empty().append('<option selected="selected" value="">Select List ID</option>');
                        $.each(data, function(k, v) {
                            $('#list_id').append('<option value="'+v.list_id+'">'+v.list_id+'</option>');
                        });
                                
                    }
                });
            });
            $("#list_id").on("change",function(){
                $("#leadstatslists").html("");
                $("#reportholderlogs").html("");
                fetchLeadStatList();
                fetchLeadStatLog();
            });
            
        });

        function fetchLeadStatList(){
            $.ajax({
                url: "/getleadstats?list_id="+$("#list_id").val()+"&campaignid="+$("#campaign").val(),
                type: 'GET',
                contentType: false, // The content type used when sending data to the server.
                cache: false, // To unable request pages to be cached
                processData: false,
                success: function (data) {
                    if ( $.fn.DataTable.isDataTable('#leadstats') ) {
                        $('#leadstats').DataTable().destroy();
                    }

                    $('#leadstats tbody').empty();
                    
                    //$('#list_id').empty().append('<option selected="selected" value="">Select List ID</option>');
                    $.each(data, function(k, v) {
                        $('#leadstatslists').append('<tr><td>'+v.status+'</td><td>'+v.status_name+'</td><td>'+v.total+'</td><td>'+v.total1+'</td><td>'+(v.total1 / v.overalltotal).toFixed(2)+'%</td><td>'+v.total2+'</td><td>'+(v.total2 / v.overalltotal).toFixed(2)+'</td><td>'+v.total3+'</td><td>'+(v.total3 / v.overalltotal).toFixed(2)+'</td><td>'+v.total4+'</td><td>'+(v.total4 / v.overalltotal).toFixed(2)+'</td><td>'+v.total5+'</td><td>'+(v.total5 / v.overalltotal).toFixed(2)+'</td><td>'+v.total6+'</td><td>'+(v.total6 / v.overalltotal).toFixed(2)+'</td></tr>');
                        
                        //$('#list_id').append('<option value="'+v.list_id+'">'+v.list_id+'</option>');
                    });
                    
                    $('#leadstats').DataTable( {
                        "paging":   false,
                        "ordering": true,
                        "info":     false
                        dom: 'Bfrtip',
                        buttons: [
                            'copyHtml5',
                            'excelHtml5',
                            'csvHtml5',
                            'pdfHtml5'
                        ]
                    } );
                }
            });
        }

        function fetchLeadStatLog(){
            $.ajax({
                url: "/getleadstatslogs?list_id="+$("#list_id").val()+"&campaignid="+$("#campaign").val(),
                type: 'GET',
                contentType: false, // The content type used when sending data to the server.
                cache: false, // To unable request pages to be cached
                processData: false,
                success: function (data) {
                    //$('#list_id').empty().append('<option selected="selected" value="">Select List ID</option>');
                    $("#reportholderlogs").html("<table id='leadstatslogs' class='table' ><tr><th colspan='8'>From vicidial_logs</th></tr><tr><th style='width:100px'>Status</th><th style='width:100px'>Status Name</th><th style='width:200px'>Total Count</th><th colspan='2'>Dial Attempt Pass #1</th><th colspan='2'>Dial Attempt Pass #2</th><th colspan='2'>Dial Attempt Pass #3</th><th colspan='2'>Dial Attempt Pass #4</th><th colspan='2'>Dial Attempt Pass #5</th><th colspan='2'>Dial Attempt Pass > #5</th></tr></table>");
                    //$('#list_id').empty().append('<option selected="selected" value="">Select List ID</option>');
                    $.each(data, function(k, v) {
                        $('#leadstatslogs').append('<tr><td>'+v.status+'</td><td>'+v.status_name+'</td><td>'+v.total+'</td></tr>');
                        //$('#list_id').append('<option value="'+v.list_id+'">'+v.list_id+'</option>');
                    });
                            
                }
            });
        }
    </script>
    
    
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>
@stop
