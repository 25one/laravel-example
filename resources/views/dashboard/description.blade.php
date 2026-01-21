@extends('dashboard.layout')

@section('css')
{{-- 
<!-- DataTables CSS -->
<link href="{{ asset('css/dataTables/dataTables.bootstrap.css') }}" rel="stylesheet">
<!-- DataTables Responsive CSS -->
<link href="{{ asset('css/dataTables/dataTables.responsive.css') }}" rel="stylesheet">
--}}
@endsection

@section('main')

    <script>
        console.log(@json($description));

        window.description = @json($description);
    </script> 

    <div class="description">
    </div>       

@endsection

@section('js')
<!-- DataTables JavaScript -->
{{-- 
<script src="{{ asset('js/dataTables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/dataTables/dataTables.bootstrap.min.js') }}"></script>
--}}

<script src="{{ mix('js/description.js') }}"></script>

<script>
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
        
</script>
@endsection
