@include('components.admin_header')
@php $days = array(
    'Monday' => 'Pazartesi',
    'Tuesday' => 'Salı',
    'Wednesday' => 'Çarşamba',
    'Thursday' => 'Perşembe',
    'Friday' => 'Cuma',
    'Saturday' => 'Cumartesi',
    'Sunday' => 'Pazar'
) @endphp
@if($user)
    <p class="mx-2">
        Öğrenci: #{{$user_id}} {{$user->name}}
    </p>
    <div class="flex justify-center items-center text-center text-xl md:text-2xl min-w-screen my-4">
        <a href="{{route("admin.home")}}?user_id={{$user_id}}&type=prayer"
           class="w-1/3 md:w-1/6 border-2 border-gray-500 rounded-xl mx-4 bg-gray-100">Namaz
            Raporları</a>
        <a href="{{route("admin.home")}}?user_id={{$user_id}}&type=study"
           class="w-1/3 md:w-1/6 border-2 border-gray-500 rounded-xl mx-4 bg-gray-100">Etüt
            Raporları</a>
        <a href="{{route("admin.home")}}?user_id={{$user_id}}&type=sleep"
           class="w-1/3 md:w-1/6 border-2 border-gray-500 rounded-xl mx-4 bg-gray-100">Yat
            Raporları</a>
    </div>
    <div
        class="px-4 md:px-16 items-center justify-center text-center min-h-screen min-w-screen pb-36 text-xl md:text-2xl">

        @if($slug == "prayer")
            <table id="myTable" class="text-center text-xs md:text-xl hover">
                <thead>
                <tr>
                    <th>Sabah</th>
                    <th>Öğle</th>
                    <th>İkindi</th>
                    <th>Akşam</th>
                    <th>Yatsı</th>
                    <th>Tarih</th>
                </tr>
                </thead>
                <tbody>
                @foreach($dates as $date)

                    @php $vals = []; @endphp
                    @foreach($attendances as $attendance)
                        @if($attendance[1] == $date)
                            @php $vals[] = $attendance[0]; @endphp
                        @endif
                    @endforeach
                    <tr>
                        @if(in_array(1, $vals))
                            <td class="text-green-500">{{ "Var" }}</td>
                        @else
                            <td class="text-red-700">{{ "Yok" }}</td>
                        @endif()
                        @if(in_array(2, $vals))
                            <td class="text-green-500">{{ "Var" }}</td>
                        @else
                            <td class="text-red-700">{{ "Yok" }}</td>
                        @endif()
                        @if(in_array(3, $vals))
                            <td class="text-green-500">{{ "Var" }}</td>
                        @else
                            <td class="text-red-700">{{ "Yok" }}</td>
                        @endif()
                        @if(in_array(4, $vals))
                            <td class="text-green-500">{{ "Var" }}</td>
                        @else
                            <td class="text-red-700">{{ "Yok" }}</td>
                        @endif()
                        @if(in_array(5, $vals))
                            <td class="text-green-500">{{ "Var" }}</td>
                        @else
                            <td class="text-red-700">{{ "Yok" }}</td>
                        @endif()
                        <td class="">{{ $date . " " . $days[date('l', strtotime($date))] }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
        @if($slug == "study")

            <table id="myTable" class="text-center hover">
                <thead>
                <tr>
                    <th>Durumu</th>
                    <th>Tarih</th>
                </tr>
                </thead>
                <tbody>
                @foreach($dates as $date)
                    <tr>
                        @if(in_array($date, $attendances))
                            <td class="text-green-500">{{ "Var" }}</td>
                        @else()
                            <td class="text-red-700">{{ "Yok" }}</td>
                        @endif()
                        <td class="">{{ $date . " " . $days[date('l', strtotime($date))] }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        @endif
        @if($slug == "sleep")

            <table id="myTable" class="text-center hover">
                <thead>
                <tr>
                    <th>Durumu</th>
                    <th>Tarih</th>
                </tr>
                </thead>
                <tbody>
                @foreach($dates as $date)
                    <tr>
                        @if(in_array($date, $attendances))
                            <td class="text-green-500">{{ "Var" }}</td>
                        @else()
                            <td class="text-red-700">{{ "Yok" }}</td>
                        @endif()
                        <td class="">{{ $date . " " . $days[date('l', strtotime($date))] }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        @endif
    </div>

    <script>
        $(document).ready(function () {
            $('#myTable').DataTable({
                order: [[1, "desc"]],
                lengthMenu: [7, 14, 21, 30],
                language: {
                    "emptyTable": "Tabloda herhangi bir veri mevcut değil",
                    "info": "_TOTAL_ kayıttan _START_ - _END_ arasındaki kayıtlar gösteriliyor",
                    "infoEmpty": "0 kayıttan 0 - 0 arasındaki kayıtlar gösteriliyor",
                    "infoFiltered": "(_MAX_ kayıt içerisinden filtrelendi)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "_MENU_ kayıt göster",
                    "loadingRecords": "Kayıtlar yükleniyor...",
                    "processing": "İşleniyor...",
                    "search": "Ara:",
                    "zeroRecords": "Eşleşen kayıt bulunamadı",
                    "paginate": {
                        "first": "İlk",
                        "last": "Son",
                        "next": "Sonraki",
                        "previous": "Önceki"
                    },
                    "aria": {
                        "sortAscending": ": artan sıralama",
                        "sortDescending": ": azalan sıralama"
                    }
                }
            });
        });

    </script>
@else
    <h2 class="text-center">Raporları görüntüleyebilmek için lütfen önce bir <a href="{{route("admin.users")}}" class="border-b-2 text-blue-800 hover:text-blue-500 hover:text-xl">öğrenci</a>
        seçiniz.</h2>
@endif
@include('components.admin_footer')
