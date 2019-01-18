@extends('layouts.app')

@section('content')

    {{--<tasks :tasks="{{ $tasks }}"></tasks>--}}
                <tasques :tasks="{{ $tasks }}" :users="{{ $users }}" uri="{{ $uri }}" :tags="{{ $tags }}"></tasques>
    @endsection
