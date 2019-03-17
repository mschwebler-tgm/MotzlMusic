@extends('layouts.app')

@section('content')
    <div id="root">
        <v-app dark>
            <v-content class="grey darken-4 login-background">
                <v-layout align-center justify-center row fill-height>
                    <auth-login csrf="{{ csrf_token() }}"
                                :errors="{{ $errors }}"
                                old-email="{{ old('email') }}">
                    </auth-login>
                </v-layout>
            </v-content>
            <v-footer app color="primary darken-4">
                <v-layout justify-center row align-center>
                    <div class="text-xs-center">
                        &copy;2019 - <strong>motzlmusic</strong>
                    </div>
                </v-layout>
                <v-btn flat
                       tag="a"
                       href="https://github.com/mschwebler-tgm/MotzlMusic"
                       target="_blank"
                       right
                       absolute>
                    {{--<v-icon left>mdi-github-circle</v-icon>--}}
                    Github
                </v-btn>
            </v-footer>
        </v-app>
    </div>
@endsection
