@include("components.header")

<main class="p-4 flex flex-col gap-4">
    @if(!$study_type)
        <div class="gap-4 grid grid-cols-1 md:grid-cols-4">
            @foreach($study_types as $study_type_item)
                <a href="{{url()->full()}}/{{$study_type_item["id"]}}"
                   class="h-16 w-full bg-slate-200 shadow-lg rounded-xl flex items-center justify-center">
                    <span>{{$study_type_item["id"]}}. Etüt Saati</span>
                </a>
            @endforeach
        </div>
    @endif
    @if($study_type && !$study_room)
        <a href="{{route("attendance.study")}}"
           class="h-16 w-full bg-slate-300 shadow-lg rounded-xl flex items-center justify-center">
            <span>GERİ GEL</span>
        </a>
        <div class="gap-4 grid grid-cols-1 md:grid-cols-4">
            @foreach($study_rooms as $study_room_item)
                <a href="{{url()->full()}}/{{$study_room_item->id}}"
                   class="h-16 w-full bg-slate-200 shadow-lg rounded-xl flex items-center justify-center">
                    <span>ETÜT {{$study_room_item->id}}</span>
                </a>
            @endforeach
        </div>
    @endif

    @if($study_room && $study_type)
        <a href="{{route("attendance.study")}}/{{$study_type}}"
           class="h-16 w-full bg-slate-300 shadow-lg rounded-xl flex items-center justify-center">
            <span>GERİ GEL</span>
        </a>
            <button onclick="toggleAll()"
                    class="h-16 w-full bg-slate-300 shadow-lg rounded-xl flex items-center justify-center">
                <span>HEPSİNİ SEÇ</span>
            </button>
        <form action="{{ route("attendance.study.post", [$study_type, $study_room]) }}" method="POST">
            <div class="gap-4 grid grid-cols-1 md:grid-cols-4">

                @csrf
                @foreach($users as $user)
                    <label for="{{$user->id}}"
                           class="h-16 w-full bg-slate-200 shadow-lg rounded-xl flex items-center">
                        <input type="checkbox" name="user_id[]" @if($user->attendance) checked
                               @endif value="{{$user->id}}"
                               class="form-checkbox h-5 w-5 text-blue-500 mx-4" id="{{$user->id}}">
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
            <input type="hidden" name="study_type" value="{{$study_type}}">
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
