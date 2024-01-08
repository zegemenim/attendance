<?php
//header("Content-type: application/vnd.ms-excel");
header("Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment; filename=CedidePansiyonuYoklamaListesi.xls");
?>

    <!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cedide Abalıoğlu Pansiyonu Günlük Yoklaması</title>
</head>
@php($time = explode("-", $time))
@php($time = $time[2].".".$time[1].".".$time[0])
@php($i = 1)
<body>
<table>
    <th style="font-size: 16px" colspan="9">Cedide Abalıoğlu Anadolu İmam Hatip Lisesi Pansiyon Günlük Yoklaması</th>
    <th style="font-size: 16px">{{$time}}</th>
    <tr>
        <td colspan="10"></td>
    </tr>
</table>
<table style="text-align: center" border="1">
        <thead>
        <tr>
            <th style="text-align: center">Oda No.</th>
            <th style="text-align: center" colspan="3">Öğrenci</th>
            <th style="text-align: center">Sabah</th>
            <th style="text-align: center">Akşam</th>
            <th style="text-align: center">Yatsı</th>
            <th style="text-align: center">Yat</th>
            <th style="text-align: center">Etüt 1</th>
            <th style="text-align: center">Etüt 2</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $users_grouped)
            @php($a = count($users_grouped)/2)
        <tr>
            <th rowspan="{{count($users_grouped)}}">{{$users_grouped[0]->room}}</th>
        @foreach($users_grouped as $user)

                <td style="font-weight: bold;" colspan="3"> {{$user->name}}</td>
                <th style="text-align: center">{{$user->prayer1 ? "+" : "Yok"}}</td>
                <th style="text-align: center" size="24px">{{$user->prayer4 ? "+" : "Yok"}}</td>
                <th style="text-align: center">{{$user->prayer5 ? "+" : "Yok"}}</td>
                <th style="text-align: center">{{$user->sleep ? "+" : "Yok"}}</td>
                <th style="text-align: center">{{$user->study1 ? "+" : "Yok"}}</td>
                <th style="text-align: center">{{$user->study2 ? "+" : "Yok"}}</td>
            </tr>
            @php($i++)
        @endforeach
        @endforeach
        </tbody>
</table>
</body>
</html>
@php(redirect()->route("admin.home"))
