@include("components.header")

<main class="p-4 flex flex-col gap-4">

    @if(!$study_room)
        <div class="gap-4 grid grid-cols-1 md:grid-cols-4">
            @foreach($study_rooms as $study_room_item)
                <a href="{{url()->full()}}/{{$study_room_item->id}}"
                   class="h-16 w-full bg-slate-200 shadow-lg rounded-xl flex items-center justify-center">
                    <span>ETÜT {{$study_room_item->id}}</span>
                </a>
            @endforeach
        </div>
    @endif

    @if($study_room)
        <a href="{{route("attendance.study")}}"
           class="h-16 w-full bg-slate-300 shadow-lg rounded-xl flex items-center justify-center">
            <span>GERİ GEL</span>
        </a>
        <form action="{{ route("attendance.study.post") }}" method="POST">
            <div class="gap-4 grid grid-cols-1 md:grid-cols-4">

                @csrf
                @foreach($users as $user)
                    <label for="{{$user->id}}"
                           class="h-16 w-full bg-slate-200 shadow-lg rounded-xl flex items-center justify-center">
                        <input type="checkbox" name="user_id[]" value="{{$user->id}}"
                               class="form-checkbox h-5 w-5 text-blue-500" id="{{$user->id}}">
                        <span>{{$user->name}}</span>
                    </label>
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
    function completed() {
        alert("Yoklama kaydedildi.");
    }
</script>

@include("components.footer")
