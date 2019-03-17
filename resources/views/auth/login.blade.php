@extends('layouts.app')

@section('content')
    <div id="root">
        <v-app dark>
            <v-content class="grey darken-4 login-background">
                <v-layout align-center justify-center row fill-height>
                    <auth-login csrf="{{ csrf_token() }}" :errors="{{ $errors }}">
                    </auth-login>
                </v-layout>
            </v-content>
            <v-footer app></v-footer>
        </v-app>
    </div>
@endsection
