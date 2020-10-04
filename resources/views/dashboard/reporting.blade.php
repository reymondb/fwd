@extends('dashboard.dashboardlayout')
@section('title', 'Dashboard > Content')

@section('content')
        <main>
            <div class="container-fluid">
                <h1 class="mt-4">Reporting</h1>
                @if(isset($status))
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Content Updated</li>
                    </ol>
                @endif
                

                <div class="card mb-4">
                    <div class="card-header"><i class="fas fa-table mr-1"></i>Existing Content</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="host_all" class="table table-condensed table-bordered table-striped " style="margin-top: 20px ">
                                <thead>
                                    <tr>
                                        <th>lead_id</th>
                                        <th>entry_date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $h)
                                    <tr>
                                        <td style="width:200px;">{{$h->lead_id}}</td>
                                        <td>{{$h->entry_date}}</td>
                                       
                                    </tr>
                                    @endforeach
                                </tbody>
                        
                            </table>
                        </div>
                    </div>
                </div>
               
            </div>
        </main>
       

          
@stop

@section('js')

@stop