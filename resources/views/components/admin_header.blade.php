@php
    $url = url('/');
@endphp
    <!doctype html>
<html lang="tr">
<head>
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function () {
                navigator.serviceWorker.register('/service-worker.js')
                    .then(function (registration) {
                        console.log('ServiceWorker registration successful with scope: ', registration.scope);
                    }, function (err) {
                        console.log('ServiceWorker registration failed: ', err);
                    });
            });
        }
    </script>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite("resources/css/app.css")
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <title>Cedide Abalıoğlu Anadolu İmam Hatip Lisesi Pansiyon Yoklama Sistemi</title>
    <link rel="icon" type="image/jpeg" href="{{asset("images/caihl.jpg")}}">
    <link href="{{asset("css/app.css")}}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>

</head>
<body class="min-h-screen">
<header class="shadow-md border-gray-500 border-b-2 w-full mb-2">
    <div class="flex mx-4 my-2 justify-between ">
        <a href="{{URL::to("/")}}/">
                <span class="flex text-center justify-center items-center ">
                    <img src="{{asset("images/caihl.jpg")}}" width="80"/> <h1 class="hidden md:flex">Cedide Abalıoğlu Anadolu İmam Hatip Lisesi Pansiyon Yoklama Sistemi</h1>
                </span>
        </a>
        <span class="flex">
                    <ul class="flex mx-4 justify-center items-center">
                        @if(auth()->user()->rank == 0 || auth()->user()->rank == 100)

                            <li class="mx-2 text-xs md:mx-8 hover:text-blue-600 md:text-xl text-center md:text-left @if(url()->full() == route("admin.home")) text-blue-800 @endif"><a
                                    href="{{route("admin.home")}}/">Raporlar</a></li>
                            <li class="mx-2 text-xs md:mx-8 hover:text-blue-600 md:text-xl text-center md:text-left @if(url()->full() == route("admin.users")) text-blue-800 @endif"><a
                                    href="{{route("admin.users")}}/">Öğrenciler</a></li>
                            <li class="mx-2 text-xs md:mx-8 hover:text-blue-600 md:text-xl text-center md:text-left @if(url()->full() == route("admin.floors")) text-blue-800 @endif"><a
                                    href="{{route("admin.floors")}}/">Katlar</a></li>
                            <li class="mx-2 text-xs md:mx-8 hover:text-blue-600 md:text-xl text-center md:text-left @if(url()->full() == route("admin.rooms")) text-blue-800 @endif"><a
                                    href="{{route("admin.rooms")}}/">Odalar</a></li>
                            <li class="mx-2 text-xs md:mx-8 hover:text-blue-600 md:text-xl text-center md:text-left @if(url()->full() == route("admin.study_rooms")) text-blue-800 @endif"><a
                                    href="{{route("admin.study_rooms")}}/">Çalışma Odaları</a></li>
                            <li class="mx-2 text-xs md:mx-8 hover:text-blue-600 md:text-xl text-center md:text-left @if(url()->full() == route("admin.settings")) text-blue-800 @endif"><a
                                    href="{{route("admin.settings")}}/">Ayarlar</a></li>
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
