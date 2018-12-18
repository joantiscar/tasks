@extends('layouts.app')

@section('content')

    {{--<tasks :tasks="{{ $tasks }}"></tasks>--}}
    <v-container fluid>
        <v-layout>
            <v-flex class="ma-5">
                <tasques :tasks="{{ $tasks }}" :users="{{ $users }}" uri="{{ $uri }}" :tags="{{ $tags }}"></tasques>
            </v-flex>
        </v-layout>
    </v-container>

    @endsection
