@component('mail::message')
# Tasca nova

S'ha creat la tasca: {{$task->name}}

@component('mail::button', ['url' => url('/tasques')])
Veure la tasca
@endcomponent

Gracies,<br>
{{ config('app.name') }}
@endcomponent
