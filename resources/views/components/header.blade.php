@php
    $url = url('/');
@endphp
<!doctype html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite("resources/css/app.css")
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <title>Hoş geldin!</title>
    <link href="{{asset("css/app.css")}}" rel="stylesheet">
</head>
<body class="min-h-screen">
<header class="shadow-md border-gray-500 border-b-2 w-full">
    <div class="flex mx-4 my-2 justify-between ">
        <a href="{{URL::to("/")}}/">
                <span class="flex text-center justify-center items-center ">
                    <img src="{{asset("images/caihl.jpg")}}" width="80"/> <h1 class="hidden md:flex">Cedide Abalıoğlu Anadolu İmam Hatip Lisesi Pansiyon Yoklama Sistemi</h1>
                </span>
        </a>
        <span class="flex">
                    <ul class="flex mx-4 justify-center items-center">
                        <li class="mx-2 text-xs md:mx-8 hover:text-blue-600 md:text-xl text-center md:text-left"><a
                                href="{{URL::to("/")}}/">Raporlar</a></li>
        <li class="mx-2 text-xs md:mx-8 hover:text-blue-600 md:text-xl text-center md:text-left"><a
                href="{{URL::to("/")}}/prayer-attendance">Namaz Yoklaması</a></li>
        <li class="mx-2 text-xs md:mx-8 hover:text-blue-600 md:text-xl text-center md:text-left"><a
                href="{{URL::to("/")}}/study-attendance">Etüt Yoklaması</a></li>
        <li class="mx-2 text-xs md:mx-8 hover:text-blue-600 md:text-xl text-center md:text-left"><a
                href="{{URL::to("/")}}/sleep-attendance">Yat Yoklaması</a></li>
        <li class="mx-2 text-xs md:mx-8 hover:text-blue-600 md:text-xl text-center md:text-left"><a
                href="{{URL::to("/")}}/logout">Çıkış</a></li>
        </ul>
                </span>
    </div>
</header>
