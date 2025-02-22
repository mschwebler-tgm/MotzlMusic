@extends('layouts.app')

@section('content')
    <div id="root">
        <v-app dark>
            <v-content class="grey darken-4 register-background">
                <v-layout align-center justify-center row fill-height>
                    <auth-register csrf="{{ csrf_token() }}"
                                   :errors="{{ $errors }}"
                                   old-email="{{ old('email') }}"
                                   old-name="{{ old('name') }}">
                    </auth-register>
                </v-layout>
            </v-content>
            <v-footer app dark color="primary darken-4">
                <v-layout justify-center row align-center>
                    <div class="text-center">
                        &copy;2019 - <strong>motzlmusic</strong>
                    </div>
                </v-layout>
                <v-btn text
                       tag="a"
                       href="https://github.com/mschwebler-tgm/MotzlMusic"
                       aria-label="View on github"
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
