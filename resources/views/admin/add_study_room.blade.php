@include('components.admin_header')


<div class="flex items-center justify-center h-screen">
    <div class="bg-gray-200 p-8 rounded shadow-md">
        <h1 class="text-2xl font-bold mb-4">Etüt Odası Ekle</h1>
        <form action="{{route("admin.add_study_room.post")}}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="study_room">Etüt Oda Numarası</label>
                <input name="study_room" required
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                       id="study_room" type="text" placeholder="Çalışma odasının numarasını giriniz...">
            </div>
            <div class="flex items-center justify-end">
                <button
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                    type="submit">
                    Gönder
                </button>
            </div>
        </form>
    </div>
</div>


@include('components.admin_footer')
