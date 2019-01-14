@extends('layouts.app')

@section('content')
    <v-container fill-height>
        <v-layout align-start justify-center row fill-height>
            <v-flex xs6>
<h1>Tasques</h1>
{{--LARAVEL BLADE--}}


<v-card>
@foreach ($tasks as $task)
    <v-layout>
        <v-flex>
  <?php if ($task->completed == true): ?>
        <strike>
            <?php endif; ?>

                <?= $task->name; ?>
            <?php if ($task->completed == true): ?>
        </strike>
        <?php endif; ?>
        </v-flex>
      <v-layout align-center justify-end row fill-height>


        <form action="/tasks/{{ $task->id }}" method="POST">
            @csrf
            {{ method_field('PATCH') }}
            <button><v-btn color="primary">Completar</v-btn></button>
        </form>
        <form action="/tasks/{{ $task->id }}" method="POST">
            @csrf
            {{ method_field('DELETE') }}
            <button><v-btn color="error">Eliminar</v-btn></button>
        </form>
                <a href="/tasks_edit/{{ $task->id }}">
                    <button><v-btn color="secondary">Modificar</v-btn></button>
                </a>
      </v-layout>
        </v-layout>
@endforeach
</v-card>
<v-card>

<form action="/tasks" method="POST">
    {{--label--}}
    @csrf


    Nova tasca: <input name="name" type="text" placeholder="Nova Tasca">
    <input hidden name="token" type="text" value="MY_TOKEN">
    <button><v-btn color="success">Afegir</v-btn></button>
</form>
</v-card>
            </v-flex>
        </v-layout>
    </v-container>
    @endsection
