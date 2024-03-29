@include("components.header")
@if(auth()->user()->rank > 200)
    @php $days = array(
    'Monday' => 'Pazartesi',
    'Tuesday' => 'Salı',
    'Wednesday' => 'Çarşamba',
    'Thursday' => 'Perşembe',
    'Friday' => 'Cuma',
    'Saturday' => 'Cumartesi',
    'Sunday' => 'Pazar'
) @endphp

    <div class="flex justify-center items-center text-center text-xl md:text-2xl min-w-screen my-4">
        <a href="{{route("reports.prayer")}}"
           class="w-1/3 md:w-1/6 border-2 border-gray-500 rounded-xl mx-4 bg-gray-100">Namaz
            Raporları</a>
        <a href="{{route("reports.study")}}"
           class="w-1/3 md:w-1/6 border-2 border-gray-500 rounded-xl mx-4 bg-gray-100">Etüt
            Raporları</a>
        <a href="{{route("reports.sleep")}}"
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
                    <th>1. Etüt Saati</th>
                    <th>2. Etüt Saati</th>
                    <th>Tarih</th>
                </tr>
                </thead>
                <tbody>
                @foreach($dates as $date)
                    @php($vals = [])
                    @foreach($attendances as $attendance)
                        @if($attendance[1] == $date)
                            @php($vals[] = $attendance[0])
                        @endif
                    @endforeach
                    <tr>
                        @if(in_array(1, $vals))
                            <td class="text-green-500">{{ "Var" }}</td>
                        @else
                            <td class="text-red-700">{{ "Yok" }}</td>
                        @endif
                        @if(in_array(2, $vals))
                            <td class="text-green-500">{{ "Var" }}</td>
                        @else
                            <td class="text-red-700">{{ "Yok" }}</td>
                        @endif
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

            var sortByColumn = 0; // Sabah sütunu


            if ('{{ $slug }}' == 'prayer') {
                sortByColumn = 5;
            } else if ('{{ $slug }}' == 'study') {
                sortByColumn = 2;
            } else if ('{{ $slug }}' == 'sleep') {
                sortByColumn = 1;
            }

            $('#myTable').DataTable({
                order: [[sortByColumn, "desc"]],
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
    <div class="md:mx-24 mx-2 text-black bg-slate-100 text-center pb-2">
        <span class="font-bold text-center text-red-600 text-lg md:text-3xl">{{\App\Models\Data::first()->title}}</span>
        <div class="m-2 md:m-8 text-xl text-center justify-center items-center">
            <div class="text-start mx-4">
                <?= $announcement = \App\Models\Data::first()->announcement ?>
{{--                @php($announcement = \App\Models\Data::first()->announcement)--}}
{{--                @php($announcement = explode("\n", $announcement))--}}

{{--                @foreach($announcement as $item)--}}
{{--                    <p class="text-left">{{$item}}</p>--}}
{{--                @endforeach--}}

{{--                <textarea name="" id="" cols="" rows="10" readonly class="outline-none bg-slate-300">{{\App\Models\Data::first()->announcement}}</textarea>--}}
            </div>
        </div>
    </div>
@endif
@include("components.footer")
