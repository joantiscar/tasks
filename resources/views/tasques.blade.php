@extends('layouts.app')

@section('content')

    {{--<tasks :tasks="{{ $tasks }}"></tasks>--}}
    <v-container fluid>
        <v-layout>
            <v-flex class="ma-5">
                <tasques :users="{{$users}}" :tasks="{{ $tasks }}"></tasques>
            </v-flex>
        </v-layout>
    </v-container>

    @endsection