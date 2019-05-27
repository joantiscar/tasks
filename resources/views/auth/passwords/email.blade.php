@extends('layouts.login')

@section('content')
    <v-content>
        <v-container fluid fill-height>
            <v-layout align-center justify-center>
                <v-flex xs12 sm8 md4>
                    <v-card class="elevation-12">

                        <recover-password csrf-token="{{csrf_token()}}"></recover-password>


                    </v-card>

                </v-flex>
            </v-layout>
        </v-container>
    </v-content>
@endsection
