<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Login</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script type="text/javascript">
        // Fix for Firefox autofocus CSS bug
        // See: http://stackoverflow.com/questions/18943276/html-5-autofocus-messes-up-css-loading/18945951#18945951
    </script>
    <script type="text/javascript" src={{ asset('js/app.js') }} defer></script>
    <script src="https://kit.fontawesome.com/e93bc86ff0.js" crossorigin="anonymous"></script>
</head>

<body>

    <main class="mx-auto flex flex-col min-h-screen w-full items-center justify-center bg-gray-900 text-white">

        <a class="text-3xl font-bold font-heading" href="{{ route('home') }}">
            <div style="transform: scale(0.9);">
                <svg width="288" height="104" viewBox="0 0 288 104" class="css-1j8o68f">
                    <defs id="SvgjsDefs1018">
                        <linearGradient id="SvgjsLinearGradient1027">
                            <stop id="SvgjsStop1028" stop-color="#6d7cff" offset="0"></stop>
                            <stop id="SvgjsStop1029" stop-color="#ff51ff" offset="1"></stop>
                        </linearGradient>
                    </defs>
                    <g id="SvgjsG1020" transform="matrix(1.1904761243989865,0,0,1.1904761243989865,17.952381883468824,59.738095880846224)" fill="#a3b4fd">
                        <path d="M12.32 18.28 l0 1.72 l-10.6 0 l0 -14.36 l10.46 0 l0 1.72 l-8.52 0 l0 4.4 l7.86 0 l0 1.72 l-7.86 0 l0 4.8 l8.66 0 z M23.372 17.88 l4.06 -12.24 l2.18 0 l-5.24 14.36 l-2.06 0 l-5.24 -14.36 l2.16 0 l4.1 12.24 l0.04 0 z M45.664 18.28 l0 1.72 l-10.6 0 l0 -14.36 l10.46 0 l0 1.72 l-8.52 0 l0 4.4 l7.86 0 l0 1.72 l-7.86 0 l0 4.8 l8.66 0 z M61.056000000000004 17.240000000000002 l0 -11.6 l1.88 0 l0 14.36 l-2.18 0 l-7.3 -11.6 l-0.04 0 l0 11.6 l-1.88 0 l0 -14.36 l2.3 0 l7.18 11.6 l0.04 0 z M68.06800000000001 7.359999999999999 l0 -1.72 l11.66 0 l0 1.72 l-4.86 0 l0 12.64 l-1.94 0 l0 -12.64 l-4.86 0 z M95.34000000000002 9.84 l-1.82 0 c-0.1 -2.22 -1.94 -2.92 -3.56 -2.92 c-1.22 0 -3.28 0.34 -3.28 2.52 c0 1.22 0.86 1.62 1.7 1.82 l4.1 0.94 c1.86 0.44 3.26 1.56 3.26 3.84 c0 3.4 -3.16 4.34 -5.62 4.34 c-2.66 0 -3.7 -0.8 -4.34 -1.38 c-1.22 -1.1 -1.46 -2.3 -1.46 -3.64 l1.82 0 c0 2.6 2.12 3.36 3.96 3.36 c1.4 0 3.76 -0.36 3.76 -2.42 c0 -1.5 -0.7 -1.98 -3.06 -2.54 l-2.94 -0.68 c-0.94 -0.22 -3.06 -0.88 -3.06 -3.38 c0 -2.24 1.46 -4.44 4.94 -4.44 c5.02 0 5.52 3 5.6 4.58 z M119.84400000000001 5.640000000000001 l1.94 0 l0 9.32 c0 2.94 -1.84 5.42 -5.78 5.42 c-3.86 0 -5.52 -2.48 -5.52 -5.16 l0 -9.58 l1.94 0 l0 9.04 c0 3.12 1.9 3.98 3.64 3.98 c1.78 0 3.78 -0.82 3.78 -3.94 l0 -9.08 z M130.336 7.300000000000001 l0 4.98 l3.86 0 c1.74 0 2.92 -0.64 2.92 -2.58 c0 -1.82 -1.24 -2.4 -2.84 -2.4 l-3.94 0 z M130.336 13.940000000000001 l0 6.06 l-1.94 0 l0 -14.36 l6.46 0 c2.66 0 4.26 1.72 4.26 4.04 c0 2 -1.14 4.26 -4.26 4.26 l-4.52 0 z M156.12800000000001 12.82 c0 -3.38 -1.88 -5.84 -5 -5.84 s-5 2.46 -5 5.84 s1.88 5.84 5 5.84 s5 -2.46 5 -5.84 z M158.12800000000001 12.82 c0 3.1 -1.64 7.56 -7 7.56 s-7 -4.46 -7 -7.56 s1.64 -7.56 7 -7.56 s7 4.46 7 7.56 z M165.94 13.84 l0 6.16 l-1.94 0 l0 -14.36 l6.64 0 c2.36 0 4.72 0.82 4.72 3.86 c0 2.12 -1.08 2.9 -2 3.44 c0.82 0.34 1.64 0.7 1.72 2.7 l0.12 2.6 c0.02 0.8 0.12 1.1 0.72 1.44 l0 0.32 l-2.38 0 c-0.28 -0.88 -0.34 -3.06 -0.34 -3.6 c0 -1.18 -0.24 -2.56 -2.56 -2.56 l-4.7 0 z M165.94 7.300000000000001 l0 4.88 l4.5 0 c1.42 0 2.92 -0.36 2.92 -2.48 c0 -2.22 -1.62 -2.4 -2.58 -2.4 l-4.84 0 z M180.292 7.359999999999999 l0 -1.72 l11.66 0 l0 1.72 l-4.86 0 l0 12.64 l-1.94 0 l0 -12.64 l-4.86 0 z M208.344 12.82 c0 -3.38 -1.88 -5.84 -5 -5.84 s-5 2.46 -5 5.84 s1.88 5.84 5 5.84 s5 -2.46 5 -5.84 z M210.344 12.82 c0 3.1 -1.64 7.56 -7 7.56 s-7 -4.46 -7 -7.56 s1.64 -7.56 7 -7.56 s7 4.46 7 7.56 z"></path>
                    </g>
                    <g id="SvgjsG1021" transform="matrix(2.8616847981000504,0,0,2.8616847981000504,75.13831520189996,-1.2337027847892443)" fill="url(#SvgjsLinearGradient1027)">
                        <path d="M1 20 l0 -11.98 c0 -0.5 0.1 -0.6 0.26 -0.6 l8.76 0 c0.14 0 0.26 0.1 0.26 0.24 l0 2.26 c0 0.14 -0.12 0.26 -0.26 0.26 l-5.92 0 l0 2.08 l3.74 0 c0.14 0 0.26 0.12 0.26 0.26 l0 2.24 c0 0.14 -0.12 0.26 -0.26 0.26 l-3.74 0 l0 2.14 l5.9 0 c0.14 0 0.26 0.12 0.26 0.26 l0 2.24 c0 0.14 -0.12 0.26 -0.26 0.26 l-8.74 0 c-0.16 0 -0.26 -0.12 -0.26 0.08 z M16.54 20 c-0.1 0 -0.2 -0.06 -0.24 -0.16 l-4 -12 c-0.04 -0.08 -0.02 -0.16 0.02 -0.24 c0.06 -0.06 0.14 -0.1 0.22 -0.1 l2.8 0 c0.1 0 0.2 0.06 0.24 0.18 l2.38 7.82 l2.4 -7.82 c0.04 -0.12 0.14 -0.18 0.24 -0.18 l2.68 0 c0.08 0 0.16 0.04 0.22 0.1 c0.04 0.08 0.06 0.16 0.02 0.24 l-4.06 12 c-0.04 0.1 -0.12 0.16 -0.24 0.16 l-2.68 0 z"></path>
                    </g>
                    <g id="SvgjsG1022" transform="matrix(2.8391168644450415,0,0,2.8391168644450415,143.16088398167773,-0.7823372889008304)" fill="#ffffff">
                        <path d="M6.22 20 c-1.08 0 -1.86 -0.22 -2.68 -0.66 c-0.8 -0.44 -1.44 -1.06 -1.88 -1.88 c-0.44 -0.8 -0.66 -1.76 -0.66 -2.86 l0 -7.04 c0 -0.14 0.12 -0.24 0.26 -0.24 l2.6 0 c0.14 0 0.24 0.1 0.24 0.24 l0 7.04 c0 0.8 0.22 1.42 0.64 1.86 s0.8 0.66 1.5 0.66 s1.06 -0.22 1.46 -0.64 c0.4 -0.44 0.6 -1.08 0.6 -1.88 l0 -7.04 c0 -0.14 0.12 -0.24 0.26 -0.24 l2.6 0 c0.14 0 0.26 0.1 0.26 0.24 l0 7.04 c0 1.1 -0.22 2.06 -0.66 2.86 c-0.42 0.82 -1.06 1.44 -1.86 1.88 s-1.6 0.66 -2.68 0.66 z M13.66 20 c-0.14 0 -0.24 -0.12 -0.24 -0.26 l0 -11.98 c0 -0.14 0.1 -0.26 0.24 -0.26 l4.9 0 c1.52 0 2.72 0.38 3.56 1.16 c1.24 1.12 1.66 3.24 1.06 4.8 c-0.22 0.56 -0.6 1.08 -1.08 1.46 c-1.62 1.26 -3.64 1.14 -5.58 1.14 l0 3.68 c0 0.14 -0.12 0.26 -0.26 0.26 l-2.6 0 z M16.52 13.280000000000001 c0 0 2.52 0.28 3.4 -0.3 c0.34 -0.22 0.54 -0.76 0.54 -1.16 c-0.02 -0.44 -0.24 -0.9 -0.6 -1.18 c-0.38 -0.32 -1.32 -0.42 -1.8 -0.42 l-1.54 0.04 l0 3.02 z"></path>
                    </g>
                </svg>
            </div>
        </a>

        <form method="POST" action="{{ route('login') }}" class="flex w-[30rem] flex-col space-y-10">
            {{ csrf_field() }}
            <div class="text-center text-4xl font-medium">Log In</div>

            <div class="w-full transform border-b-2 bg-transparent text-lg duration-300 focus-within:border-indigo-500">
                <input type="email" name="email" value="{{ old('email') }}" required placeholder="Email" class="w-full border-none bg-transparent outline-none placeholder:italic focus:outline-none">
                @if ($errors->has('email'))
                <span class="error">
                    {{ $errors->first('email') }}
                </span>
                @endif
            </div>

            <div class="w-full transform border-b-2 bg-transparent text-lg duration-300 focus-within:border-indigo-500">
                <input type="password" name="password" required placeholder="Password" class="w-full border-none bg-transparent outline-none placeholder:italic focus:outline-none">
                @if ($errors->has('password'))
                <span class="error">
                    {{ $errors->first('password') }}
                </span>
                @endif
            </div>

            @if (Session::has('ban'))
            <div class="error text-danger text-center">
                {{ Session::get('ban') }}
                <a href="{{ route('appeal', Session::get('userid')) }}" class="font-medium text-indigo-500 underline-offset-4 hover:underline">here.</a>
            </div>
            @endif

            @if ($errors->has('deleted'))
            <div class="error text-danger text-center">
                {{ $errors->first('deleted') }}
            </div>
            @endif

            <button class="transform rounded-sm bg-indigo-600 py-2 font-bold duration-300 hover:bg-indigo-400">
                LOG IN
            </button>

            <a href="{{route('login.google')}}" class="flex items-center bg-white justify-center w-full px-4 py-2 text-sm text-white text-gray-700 border border-gray-300 rounded-lg hover:border-gray-500 focus:border-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="w-4 h-4 mr-2" viewBox="0 0 48 48">
                    <defs>
                        <path id="a" d="M44.5 20H24v8.5h11.8C34.7 33.9 30.1 37 24 37c-7.2 0-13-5.8-13-13s5.8-13 13-13c3.1 0 5.9 1.1 8.1 2.9l6.4-6.4C34.6 4.1 29.6 2 24 2 11.8 2 2 11.8 2 24s9.8 22 22 22c11 0 21-8 21-22 0-1.3-.2-2.7-.5-4z" />
                    </defs>
                    <clipPath id="b">
                        <use xlink:href="#a" overflow="visible" />
                    </clipPath>
                    <path clip-path="url(#b)" fill="#FBBC05" d="M0 37V11l17 13z" />
                    <path clip-path="url(#b)" fill="#EA4335" d="M0 11l17 13 7-6.1L48 14V0H0z" />
                    <path clip-path="url(#b)" fill="#34A853" d="M0 37l30-23 7.9 1L48 0v48H0z" />
                    <path clip-path="url(#b)" fill="#4285F4" d="M48 48L17 24l-4-3 35-10z" />
                </svg>Google
            </a>

            <p class="text-center text-lg">
                No account?
                <a href="{{ route('register') }}" class="font-medium text-indigo-500 underline-offset-4 hover:underline">Create One</a>
            </p>

            <p class="text-center text-lg">
                Did you forget your password?
                <a href="{{ route('forgot_password') }}" class="font-medium text-indigo-500 underline-offset-4 hover:underline">Reset Password</a>
            </p>
        </form>
    </main>

    <script src="https://unpkg.com/flowbite@1.5.4/dist/flowbite.js"></script>
</body>

</html>