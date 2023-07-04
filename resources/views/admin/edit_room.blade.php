@include('components.admin_header')


<div class="flex items-center justify-center h-screen">
    <div class="bg-gray-200 p-8 rounded shadow-md">
        <h1 class="text-2xl font-bold mb-4">Düzenle</h1>
        <form action="{{route("admin.edit_room.post")}}/{{$room->id}}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="room">Oda Numarası</label>
                <input required value="{{$room->id}}" name="room"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                       id="room" type="text" placeholder="Oda Numarası">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="floor">Kat Numarası</label>
                {{--                <input value="{{$user->study_room}}" name="study_room" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="study_room" type="text" placeholder="Çalışma Odası">--}}
                <select name="floor" id="floor"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    @foreach($floors as $floor)
                        <option @if($floor->id == $room->floor_id) selected @endif value="{{$floor->id}}">{{$floor->id}}</option>
                    @endforeach
                </select>
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
