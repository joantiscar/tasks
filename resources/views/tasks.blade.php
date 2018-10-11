@extends('layouts.app')

@section('content')
<h1>Tasques</h1>
{{--LARAVEL BLADE--}}
<ul>


@foreach ($tasks as $task)
    <li> <?php if ($task->completed == true): ?>
        <strike>
            <?php endif; ?>

            <?= $task->name; ?>
            <?php if ($task->completed == true): ?>
        </strike>
        <?php endif; ?>


        <form action="/tasks/{{ $task->id }}" method="POST">
            @csrf
            {{ method_field('PATCH') }}
            <button>Completar</button>
        </form>
        <form action="/tasks/{{ $task->id }}" method="POST">
            @csrf
            {{ method_field('DELETE') }}
            <button>Eliminar</button>
        </form>
                <a href="/tasks_edit/{{ $task->id }}">

            <button>Modificar</button>

                </a>
    </li>
@endforeach
</ul>

<form action="/tasks" method="POST">
    {{--label--}}
    @csrf
    Nova tasca: <input name="name" type="text" placeholder="Nova Tasca">
    <input hidden name="token" type="text" value="MY_TOKEN">
    <button>Afegir</button>
</form>
    @endsection