@include('components.admin_header')


<div class="flex items-center justify-center h-screen">
    <div class="bg-gray-200 p-8 rounded shadow-md">
        <h1 class="text-2xl font-bold mb-4">Düzenle</h1>
        <form action="{{route("admin.edit_user.post")}}/{{$user->id}}" method="POST">
            @csrf
            <div class="mb-4 hidden">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="#">#</label>
                <input value="{{$user->id}}" name="id"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                       id="#" type="text" placeholder="#">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Ad Soyad</label>
                <input value="{{$user->name}}" name="name"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                       id="name" type="text" placeholder="Ad Soyad">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="username">T.C. Kimlik No.</label>
                <input value="{{$user->username}}" name="username"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                       id="username" type="text" placeholder="T.C. No.">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="room">Oda</label>
                <input value="{{$user->room}}" name="room"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                       id="room" type="text" placeholder="Oda">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="floor">Kat</label>
                <input value="{{$user->floor_id}}" name="floor"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                       id="floor" type="text" placeholder="Kat">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="study_room">Çalışma Odası</label>
                <input value="{{$user->study_room}}" name="study_room"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                       id="study_room" type="text" placeholder="Çalışma Odası">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="rank">Seviye</label>
                {{--                <input value="{{$user->study_room}}" name="study_room" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="study_room" type="text" placeholder="Çalışma Odası">--}}
                <select name="rank" id="rank"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    @php
                        $ranks = [
                            ["name"=>"Öğrenci", "id"=>300],
                            ["name"=>"Öğretmen", "id"=>200],
                            ["name"=>"Yönetici", "id"=>100],
                            ["name"=>"Geliştirici", "id"=>0],
]
                    @endphp
                    @foreach($ranks as $rank)
                        <option @if($user->rank == $rank["id"]) selected @endif value="{{$rank["id"]}}">{{$rank["name"]}}</option>
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
