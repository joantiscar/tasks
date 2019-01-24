@component('mail::message')
# Tasca actualitzada

S'ha modificat la tasca: {{$task->name}}

@component('mail::button', ['url' => url('/tasques')])
Veure la tasca
@endcomponent

Gracies,<br>
{{ config('app.name') }}
@endcomponent
