@extends('layouts.app')
<link href="https://cdn.jsdelivr.net/npm/tailwindcss/dist/tailwind.min.css" rel="stylesheet"> {{--tailwinds--}}

@section('content')

    {{--<tasks :tasks="{{ $tasks }}"></tasks>--}}
    <v-layout align-center justify-center row fill-height>
                <tasks></tasks>
    </v-layout>

    @endsection