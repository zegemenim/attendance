@include("components.admin_header")
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
            <th class="">Düzenle</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <td class="">{{$user->id}}</td>
                <td class="">{{$user->name}}</td>
                <td class="">{{$user->username}}</td>
                <td class="">{{$user->room}}</td>
                <td class="">{{$user->floor_id}}</td>
                <td class="">{{$user->study_room}}</td>
                <td class="">@if($user->rank == 300) Öğrenci @endif @if($user->rank == 200) Öğretmen @endif @if($user->rank == 100) Yönetici @endif @if($user->rank == 0) Geliştirici @endif</td>
                <td class="text-blue-900 hover:text-blue-600"><a class="text-blue-900 hover:text-blue-600" href="{{route("admin.edit_user")}}/{{$user->id}}">Düzenle</a></td>
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
