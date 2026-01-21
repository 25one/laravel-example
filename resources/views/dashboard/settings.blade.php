@extends('dashboard.layout')

@section('css')

@endsection

@section('main')

    <script>
        window.models = @json($models);
    </script> 

    <div class="settings-container">
    </div>                   

@endsection

@section('js')
<script src="{{ mix('js/settings.js') }}"></script>
@endsection
