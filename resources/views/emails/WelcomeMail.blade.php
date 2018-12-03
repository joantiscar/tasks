@component('mail::message')
# Introduction

Hola {{$user->name}},
El pantano es de La Sénia, perque el pantano es troba a la pobla, que com tots sabem forma part de lo imperi senienc

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
