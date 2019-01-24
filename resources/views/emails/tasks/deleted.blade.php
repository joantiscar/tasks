@component('mail::message')
# Tasca esborrada

S'ha borrat la tasca: {{$task->name}}

@component('mail::button', ['url' => url('/tasques')])
Veure la tasca
@endcomponent

Gracies,<br>
{{ config('app.name') }}
@endcomponent
