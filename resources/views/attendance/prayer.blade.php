@include("components.header")

<main class="p-4 flex flex-col gap-4">

    @if(!$floor)
        <div class="gap-4 grid grid-cols-1 md:grid-cols-4">
            @foreach($floors as $flooritem)
                <a href="{{url()->full()}}/{{$flooritem->id}}"
                   class="h-16 w-full bg-slate-200 shadow-lg rounded-xl flex items-center justify-center">
                    <span>KAT {{$flooritem->id}}</span>
                </a>
            @endforeach
        </div>
    @endif

    @if(isset($floor))
        <a href="{{route("attendance.prayer")}}"
           class="h-16 w-full bg-slate-300 shadow-lg rounded-xl flex items-center justify-center">
            <span>GERİ GEL</span>
        </a>
        <form action="{{ route("attendance.prayer.post") }}" method="POST">
            <select name="prayer_type" id="prayer_type"
                    class="h-16 w-full bg-slate-300 shadow-lg rounded-xl flex items-center text-center justify-center mb-4">
                <option value="1">Sabah Namazı</option>
                <option value="2">Öğle Namazı</option>
                <option value="3">İkindi Namazı</option>
                <option value="4">Akşam Namazı</option>
                <option value="5">Yatsı Namazı</option>
            </select>
            <div class="gap-4 grid grid-cols-1 md:grid-cols-4">

                @csrf
                @foreach($users as $user)
                    <label for="{{$user->id}}"
                           class="h-16 w-full bg-slate-200 shadow-lg rounded-xl flex items-center justify-center">
                        <input type="checkbox" name="user_id[]" value="{{$user->id}}"
                               class="form-checkbox h-5 w-5 text-blue-500 mx-2" id="{{$user->id}}">
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
