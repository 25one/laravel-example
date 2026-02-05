@extends('dashboard.layout')

@section('css')

@endsection

@section('main')

    <script>
        //console.log(@json($description));

        window.description = @json($description);
    </script> 

    <div class="description">
    </div>       

@endsection

@section('js')
<script src="{{ mix('js/description.js') }}"></script>
@endsection
