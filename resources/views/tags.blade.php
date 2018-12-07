@extends('layouts.app')

@section('content')

    {{--<tasks :tasks="{{ $tasks }}"></tasks>--}}
    <v-container fluid>
        <v-layout>
            <v-flex class="ma-5">
        <tags :tags="{{ $tags }}"></tags>
            </v-flex>
        </v-layout>
    </v-container>

@endsection
