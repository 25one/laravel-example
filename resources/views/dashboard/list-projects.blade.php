@extends('dashboard.layout')

@section('css')

@endsection

@section('main')

    <script>
        window.projects = @json($projects);
        window.countKeysActive = @json($countKeysActive);
        window.demoCount = @json($demoCount);
    </script> 

    <div class="list-projects">
    </div>       

@endsection

@section('js')
<script src="{{ mix('js/project.js') }}"></script>
@endsection
