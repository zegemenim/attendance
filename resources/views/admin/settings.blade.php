@include('components.admin_header')

<script src="https://cdn.tiny.cloud/1/47qz9a670p4cfyudfsu7ldei8tnqsnamdrssq5migw4yz5z8/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: 'textarea',
        plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
    });
</script>

<main class="p-4 flex flex-col gap-4">

    <div class="gap-4 grid grid-cols-1 md:grid-cols-4"><script>
            function confirmAction() {
                return confirm('Bu işlemi gerçekleştirmek istediğinize emin misiniz?');
            }
        </script>

        <a href="{{route("admin.delete_attendances")}}"
           class="h-16 w-full bg-slate-200 shadow-lg rounded-xl flex items-center justify-center"
           onclick="return confirmAction();">
            <span>Tüm yoklama verilerini temizle!</span>
        </a>

        <a href="{{route("admin.delete_floors")}}"
           class="h-16 w-full bg-slate-200 shadow-lg rounded-xl flex items-center justify-center"
           onclick="return confirmAction();">
            <span>Tüm katları temizle!</span>
        </a>

        <a href="{{route("admin.delete_rooms")}}"
           class="h-16 w-full bg-slate-200 shadow-lg rounded-xl flex items-center justify-center"
           onclick="return confirmAction();">
            <span>Tüm odaları temizle!</span>
        </a>

        <a href="{{route("admin.delete_study_rooms")}}"
           class="h-16 w-full bg-slate-200 shadow-lg rounded-xl flex items-center justify-center"
           onclick="return confirmAction();">
            <span>Tüm çalışma odalarını temizle!</span>
        </a>

        <a href="{{route("admin.delete_users")}}"
           class="h-16 w-full bg-slate-200 shadow-lg rounded-xl flex items-center justify-center"
           onclick="return confirmAction();">
            <span>Tüm öğrencileri temizle!</span>
        </a>

        <a href="{{route("admin.delete_sessions")}}"
           class="h-16 w-full bg-slate-200 shadow-lg rounded-xl flex items-center justify-center"
           onclick="return confirmAction();">
            <span>Tüm oturumları kapat!</span>
        </a>
    </div>
    <form action="" method="post" class="flex flex-col gap-4 m-4">
        @csrf
        <input type="hidden" name="id" value="{{$announcement->id}}">
        <input type="text" name="title" id="" placeholder="Anasayfa Başlığı" class="rounded-xl outline-none border-2 border-red-600 p-2 text-center" value="{{$announcement->title}}">
        <textarea class="border-1 outline-none border-red-400 ring-red-400 ring-1 rounded-xl p-2" name="announcement" id="" cols="30" rows="10" placeholder="İçerik">{{$announcement->announcement}}</textarea>
        <button type="submit">Gönder</button>
    </form>

</main>

@include('components.admin_footer')
