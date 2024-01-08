@include("components.header")

<main class="p-4 flex flex-col gap-4">

    @if(!isset($floor))
        <div class="gap-4 grid grid-cols-1 md:grid-cols-4">
            @foreach($floors as $flooritem)
                <a href="{{url()->full()}}/{{$flooritem->id}}"
                   class="h-16 w-full bg-slate-200 shadow-lg rounded-xl flex items-center justify-center">
                    <span>KAT {{$flooritem->id}}</span>
                </a>
            @endforeach
        </div>
    @endif

    {{--    @if(isset($floor) && !isset($room))--}}
    {{--        <a href="{{route("attendance.sleep")}}"--}}
    {{--           class="h-16 w-full bg-slate-300 shadow-lg rounded-xl flex items-center justify-center">--}}
    {{--            <span>GERİ GEL</span>--}}
    {{--        </a>--}}
    {{--        <div class="gap-4 grid grid-cols-1 md:grid-cols-4">--}}
    {{--            @foreach($rooms as $roomitem)--}}
    {{--                <a href=" {{url()->full()}}/{{$roomitem->id}}"--}}
    {{--                   class="h-16 w-full bg-slate-200 shadow-lg rounded-xl flex items-center justify-center">--}}
    {{--                    <span>ODA {{$roomitem->id}}</span>--}}
    {{--                </a>--}}
    {{--            @endforeach--}}
    {{--        </div>--}}
    {{--    @endif--}}
    @if(isset($floor))
        <a href="{{route("attendance.sleep")}}/"
           class="h-16 w-full bg-slate-300 shadow-lg rounded-xl flex items-center justify-center">
            <span>GERİ GEL</span>
        </a>
            <button onclick="toggleAll()"
                    class="h-16 w-full bg-slate-300 shadow-lg rounded-xl flex items-center justify-center">
                <span>HEPSİNİ SEÇ</span>
            </button>
        <form action="{{ route("attendance.sleep.post", [$floor]) }}" method="POST">


            <div class="">
                @csrf
                @foreach($users_grouped as $room_number => $users_group)
                    <div class=" bg-slate-300 text-center p-4 rounded-xl my-4">
                        <span class="text-center font-bold">Oda: {{$room_number}}</span>
                        <div class="gap-4 grid grid-cols-1 md:grid-cols-4">
                            @foreach($users_group as $user)
                                <label for="{{$user->id}}"
                                       class="h-16 mt-2 w-full bg-slate-200 shadow-lg rounded-xl flex items-center">
                                    <input type="checkbox" name="user_id[]" @if($user->attendance) checked
                                           @endif value="{{$user->id}}"
                                           class="form-checkbox h-5 w-5 text-blue-500 mx-4" id="{{$user->id}}">
                                    <span>{{$user->name}}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>


            <br>
            <div class="flex justify-center">
                <button onclick="completed()" type="submit"
                        class="bg-slate-200 text-xl text-bold px-2 shadow-lg rounded-md flex items-center justify-center">
                    <span>KAYDET</span>
                </button>
            </div>
        </form>
    @endif

</main>

<script>
    let i = 0;
    function completed() {
        alert("Yoklama kaydedildi.");
    }
    function toggleAll() {
        var checkboxes = document.querySelectorAll('input[type="checkbox"]');

        if (i === 0) {
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = true;
            });
            i = 1;
        } else {
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = false;
            });
            i = 0;
        }
    }
</script>

@include("components.footer")
