@extends('dashboard.layout')

@section('css')

@endsection

@section('main')

                <div id="page-wrapper">
                  <div class="container-fluid pt-5">
                    <div class="row page-header">
                        <div class="col-lg-12">
                            <i class="fa fa-plus fa-2x my-plus-icon" aria-hidden="true" data-toggle="collapse" data-target="#collapseWidthExample" aria-expanded="false" aria-controls="collapseWidthExample"></i> <span class="my-plus-text">Add a new Project</span>
                        </div>

                        <div style="min-height: 120px;">
                            <div class="collapse width" id="collapseWidthExample">
                                <div class="card card-body" style="width: 320px;">
                                    <form role="form" method="post" action="{{route('list-prompts')}}">
                                        <div class="form-group">
                                            <label>Title of Project</label>
                                            <input class="form-control" name="title_project" />
                                        </div>
                                        <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>                                                                                 
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container">
                        <div class="row">
                            <div class="col-sm font-weight-bold">
                              <strong>Execute</strong>
                            </div>
                            <div class="col-sm">
                              <strong>Title</strong>
                            </div>
                            <div class="col-sm">
                              <strong>Token</strong>
                            </div>
                            <div class="col-sm">
                              <strong>Update</strong>
                            </div>   
                            <div class="col-sm">
                              <strong>Delete</strong>
                            </div>                                                      
                        </div>                        
                        @foreach ($projects as $project)
                        <div class="row">
                            <div class="col-sm">
                               <i className="fa fa-play fa-2x my-play-icon" aria-hidden="true"></i>
                            </div>
                            <div class="col-sm">
                               {{$project->title}}
                            </div>
                            <div class="col-sm">
                               {{$project->token}}
                            </div>
                            <div class="col-sm">
                               <i className="fa fa-pencil-square-o fa-2x my-pencil-icon" aria-hidden="true"></i>
                            </div>
                            <div class="col-sm">
                               <i className="fa fa-trash-o fa-2x my-trash-icon" aria-hidden="true"></i>
                            </div>                                                        
                        </div>
                        @endforeach
                    </div>

                  </div>
                </div>

@endsection

@section('js')
<script>
/*
$(document).ready(function(){
    //copy to clipboard
    $(function (e) { 
        $('[data-toggle="tooltip"]').tooltip('hide')
            .attr('data-original-title', $(e.target).attr('title')); //attr title - over-message                  
    });

    window.clipboard.on('success', function(e) {
        var btn = $(e.trigger);
        setTooltip(e, btn, $(e.trigger).attr('value')); //attr value - click-message
    }); 


    function setTooltip(e, btn, message) {
        btn.tooltip('hide')
            .attr('data-original-title', message)
            .tooltip('show');
    }     
});   
*/        
</script>
@endsection
