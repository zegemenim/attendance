@include("components.admin_header")
<a href="{{route("admin.add_user")}}" class="bg-gray-50 shadow-lg border-2 border-blue-900 rounded-md p-1 hover:bg-blue-500 mx-2 mt-4 hover:text-white">Yeni Kullanıcı</a>
<main class="h-auto text-center w-full rounded-md p-4 bg-gray-50">
    <table id="myTable" class="text-center hover">
        <thead>
        <tr>
            <th>#</th>
            <th>Adı Soyadı</th>
            <th>T.C. Kimlik No.</th>
            <th>Oda</th>
            <th>Kat</th>
            <th>Çalışma Odası</th>
            <th>Seviye</th>
            <th>Raporu İncele</th>
            <th class="">Düzenle</th>
            <th class="">Sil</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <td class="">{{$user->id}}</td>
                <td class="">{{$user->name}}</td>
                <td class="">{{$user->username}}</td>
                <td class="">{{$user->room}}</td>
                <td class="">@if(isset(\App\Models\Room::where("id", $user->room)->first()->floor_id)){{\App\Models\Room::where("id", $user->room)->first()->floor_id}}@else Bulunamadı!@endif</td>
                <td class="">{{$user->study_room}}</td>
                <td class="">@if($user->rank == 300) Öğrenci @endif @if($user->rank == 200) Öğretmen @endif @if($user->rank == 100) Yönetici @endif @if($user->rank == 0) Geliştirici @endif</td>
                <td class="text-blue-900 hover:text-blue-600"><a class="text-blue-900 hover:text-blue-600" href="{{route("admin.home")}}?user_id={{$user->id}}">Raporu İncele</a></td>
                <td class="text-blue-900 hover:text-blue-600"><a class="text-blue-900 hover:text-blue-600" href="{{route("admin.edit_user")}}/{{$user->id}}">Düzenle</a></td>
                <td class="text-blue-900 hover:text-blue-600"><a class="text-blue-900 hover:text-blue-600" href="{{route("admin.delete_user")}}/{{$user->id}}" onclick="alert('{{$user->name}} isimli kullanıcıyı silmek istediğine emin misin?')">Sil</a></td>
            </tr>
        @endforeach
        </tbody>
    </table>

</main>

<script>
    $(document).ready(function () {
        $('#myTable').DataTable({
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

@include("components.admin_footer")
