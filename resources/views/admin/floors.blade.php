@include("components.admin_header")
<a href="{{route("admin.add_floor")}}" class="bg-gray-50 shadow-lg border-2 border-blue-900 rounded-md p-1 hover:bg-blue-500 mx-2 mt-4 hover:text-white">Yeni Kat</a>
<main class="h-auto text-center w-full rounded-md p-4 bg-gray-50 overflow-x-auto">
    <table id="myTable" class="text-center hover">
        <thead>
        <tr>
            <th>Kat Numarası</th>
            <th class="">Düzenle</th>
            <th class="">Sil</th>
        </tr>
        </thead>
        <tbody>
        @foreach($floors as $floor)
            <tr>
                <td class="">{{$floor->id}}</td>
                <td class="text-blue-900 hover:text-blue-600"><a class="text-blue-900 hover:text-blue-600" href="{{route("admin.edit_floor")}}/{{$floor->id}}">Düzenle</a></td>
                <td class="text-blue-900 hover:text-blue-600"><a class="text-blue-900 hover:text-blue-600" href="{{route("admin.delete_floor")}}/{{$floor->id}}" onclick="alert('{{$floor->id}} numaralı odayı silmek istediğine emin misin?')">Sil</a></td>
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
