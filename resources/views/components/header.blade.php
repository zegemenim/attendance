@php
    $url = url('/');
@endphp
    <!doctype html>
<html lang="tr">
<head>
    <link rel="author" href="https://zegemenim-git-main-zegemenim.vercel.app/">
    <link rel="author" href="/zegemenim" content="Zahit Egemen İm"/>
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('/service-worker.js')
                    .then(function(registration) {
                        console.log('ServiceWorker registration successful with scope: ', registration.scope);
                    }, function(err) {
                        console.log('ServiceWorker registration failed: ', err);
                    });
            });
        }
    </script>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
{{--    @vite("resources/css/app.css")--}}
{{--    <link href="{{asset("build/assets/app-259881bb.css")}}" rel="stylesheet">--}}
{{--    <link href="{{asset("build/assets/app-259881bb-58aa5226.css")}}" rel="stylesheet">--}}
{{--    <script src="{{asset("build/assets/app-f63121b6.js")}}"></script>--}}
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <title>Cedide Abalıoğlu Anadolu İmam Hatip Lisesi Pansiyon Yoklama Sistemi</title>
    <link rel="icon" type="image/jpeg" href="{{asset("images/cedide.png")}}">
{{--    <link href="{{asset("css/app.css")}}" rel="stylesheet">--}}
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>

    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body class="min-h-screen">
<header class="shadow-md border-gray-500 border-b-2 w-full mb-2">
    <div class="md:mx-4 my-2 md:overflow-x-hidden">
        <a href="{{URL::to("/")}}/">
                <span class="flex text-center justify-center items-center ">
                    <img src="{{asset("images/caihl.jpg")}}" width="80"/>
                    <h1 class="hidden md:flex text-2xl @if(Illuminate\Http\Request::capture()->url() == route("reports")) text-blue-800 @endif">Cedide Abalıoğlu Anadolu İmam Hatip Lisesi Pansiyonu</h1>
                </span>
            <h1 class="block md:hidden text-xs text-center @if(Illuminate\Http\Request::capture()->url() == route("reports")) text-blue-800 @endif">Cedide Abalıoğlu Anadolu İmam Hatip Lisesi Pansiyonu</h1>
        </a>
        <span class="flex md:block my-8">
                    <ul class="flex mx-4 justify-center items-center">
                        <li class="mx-2 text-xs md:mx-8 hover:text-blue-600 md:text-xl text-center md:text-left"><a
                                href="@if(auth()->user()->rank < 300) {{route("admin.home")}} @else {{route("reports")}} @endif">Raporlar</a></li>
                        @if(auth()->user()->rank == 200 || auth()->user()->rank == 100 || auth()->user()->rank == 0)
                            <li class="mx-2 text-xs md:mx-8 hover:text-blue-600 md:text-xl text-center md:text-left @if(Illuminate\Http\Request::capture()->url() == route("attendance.prayer")) text-blue-800 @endif"><a
                                    href="{{URL::to("/")}}/prayer-attendance">Namaz Yoklaması</a></li>
                            <li class="mx-2 text-xs md:mx-8 hover:text-blue-600 md:text-xl text-center md:text-left @if(Illuminate\Http\Request::capture()->url() == route("attendance.study")) text-blue-800 @endif"><a
                                    href="{{URL::to("/")}}/study-attendance">Etüt Yoklaması</a></li>
                            <li class="mx-2 text-xs md:mx-8 hover:text-blue-600 md:text-xl text-center md:text-left @if(Illuminate\Http\Request::capture()->url() == route("attendance.sleep")) text-blue-800 @endif"><a
                                    href="{{URL::to("/")}}/sleep-attendance">Yat Yoklaması</a></li>
                        @endif
                        @if(auth()->user()->rank == 100 || auth()->user()->rank == 0)
                            <li class="mx-2 text-xs md:mx-8 hover:text-blue-600 md:text-xl text-center md:text-left"><a
                                    href="{{route("admin.home")}}">Yönetici</a></li>
                        @endif
                        <form id="logout-form" action="{{ route('logout') }}" method="POST">
                            @csrf
                            <li class="mx-2 text-xs md:mx-8 hover:text-blue-600 md:text-xl text-center md:text-left"><button
                                    type="submit">Çıkış</button></li>
                            </form>
        </ul>



                </span>
    </div>
</header>
