@include('components.admin_header')


<main class="p-4 flex flex-col gap-4">

    <div class="gap-4 grid grid-cols-1 md:grid-cols-4">
            <a href="{{route("admin.delete_attendances")}}"
               class="h-16 w-full bg-slate-200 shadow-lg rounded-xl flex items-center justify-center">
                <span>Tüm yoklama verilerini temizle!</span>
            </a>
            <a href="{{route("admin.delete_floors")}}"
               class="h-16 w-full bg-slate-200 shadow-lg rounded-xl flex items-center justify-center">
                <span>Tüm katları temizle!</span>
            </a>
            <a href="{{route("admin.delete_rooms")}}"
               class="h-16 w-full bg-slate-200 shadow-lg rounded-xl flex items-center justify-center">
                <span>Tüm odaları temizle!</span>
            </a>
            <a href="{{route("admin.delete_study_rooms")}}"
               class="h-16 w-full bg-slate-200 shadow-lg rounded-xl flex items-center justify-center">
                <span>Tüm çalışma odalarını temizle!</span>
            </a>
            <a href="{{route("admin.delete_users")}}"
               class="h-16 w-full bg-slate-200 shadow-lg rounded-xl flex items-center justify-center">
                <span>Tüm öğrencileri temizle!</span>
            </a>
            <a href="{{route("admin.delete_sessions")}}"
               class="h-16 w-full bg-slate-200 shadow-lg rounded-xl flex items-center justify-center">
                <span>Tüm oturumları kapat!</span>
            </a>
    </div>

</main>

@include('components.admin_footer')
