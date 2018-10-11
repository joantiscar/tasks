@extends('layouts.app')

@section('content')
<h1>Edita una tasca</h1>
{{--LARAVEL BLADE--}}

            <form action="/tasks/{{$task->id}}" method="POST">
                @csrf
                {{ method_field('PUT') }}
                <input name="name" type="text" value="{{$task->name}}">
                @if ( $task->completed )
                <input name="completed" type="checkbox" value="" checked>
                @else
                <input name="completed" type="checkbox" value="" >
                @endif
                <button>Editar</button>




            </form>


@endsection