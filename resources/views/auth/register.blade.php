{{--<x-guest-layout>--}}
    {{--<x-auth-card>--}}
        {{--<x-slot name="logo">--}}
            {{--<a href="/">--}}
                {{--<x-application-logo class="w-20 h-20 fill-current text-gray-500" />--}}
            {{--</a>--}}
        {{--</x-slot>--}}

        {{--<!-- Validation Errors -->--}}
        {{--<x-auth-validation-errors class="mb-4" :errors="$errors" />--}}

        {{--<form method="POST" action="{{ route('register') }}">--}}
        {{--@csrf--}}

        {{--<!-- Name -->--}}
            {{--<div>--}}
                {{--<x-label for="firstname" :value="__('First Name')" />--}}

                {{--<x-input id="firstname" class="block mt-1 w-full" type="text" name="firstName" required autofocus />--}}
            {{--</div>--}}
            {{--<!-- Name -->--}}
            {{--<div>--}}
                {{--<x-label for="lastname" :value="__('Last Name')" />--}}

                {{--<x-input id="lastname" class="block mt-1 w-full" type="text" name="lastName" required />--}}
            {{--</div>--}}
            {{--<!-- Name -->--}}
            {{--<div>--}}
                {{--<x-label for="userName" :value="__('userName')" />--}}

                {{--<x-input id="userName" class="block mt-1 w-full" type="text" name="userName" required />--}}
            {{--</div>--}}

            {{--<!-- Email Address -->--}}
            {{--<div class="mt-4">--}}
                {{--<x-label for="email" :value="__('Email')" />--}}

                {{--<x-input id="email" class="block mt-1 w-full" type="email" name="email"  />--}}
            {{--</div>--}}

            {{--<!-- Password -->--}}
            {{--<div class="mt-4">--}}
                {{--<x-label for="password" :value="__('Password')" />--}}

                {{--<x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />--}}
            {{--</div>--}}

            {{--<!-- Confirm Password -->--}}
            {{--<div class="mt-4">--}}
                {{--<x-label for="password_confirmation" :value="__('Confirm Password')" />--}}

                {{--<x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />--}}
            {{--</div>--}}

            {{--<div class="flex items-center justify-end mt-4">--}}
                {{--<x-button>--}}
                    {{--{{ __('Register') }}--}}
                {{--</x-button>--}}
            {{--</div>--}}
        {{--</form>--}}
    {{--</x-auth-card>--}}
{{--</x-guest-layout>--}}

        <!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

    <title>Hello, world!</title>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col">

        </div>
        <div class="col">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">first name</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" name="firstName" aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">last name</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" name="lastName" aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">username</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" name="userName" aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" id="exampleInputPassword1">
                </div>

                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">confirm Password</label>
                    <input type="password" class="form-control" name="password_confirmation" id="exampleInputPassword1">
                </div>


                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
        <div class="col">

        </div>
    </div>
</div>


<!-- Optional JavaScript; choose one of the two! -->

<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

<!-- Option 2: Separate Popper and Bootstrap JS -->
<!--
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
-->
</body>
</html>
