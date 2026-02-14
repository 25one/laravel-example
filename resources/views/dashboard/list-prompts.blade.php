@extends('dashboard.layout')

@section('css')

@endsection

@section('main')

    <script>
        console.log(@json($project));

        window.project = @json($project);
    </script> 

    <div class="list-prompts">
    </div>       

@endsection

@section('js')
<script src="{{ mix('js/prompt.js') }}"></script>

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
