@extends('app')

@section('content')
    @foreach($cages as $cage)
        <div class="form-group">
            <label for="cage-{{ $cage->id }}">{{ $cage->name }}</label>
            <select class="form-control" multiple id="cage-{{ $cage->id }}" >
                @foreach($cage->sheep as $sheep)
                    <option>{{ $sheep->name }}</option>
                @endforeach
            </select>
        </div>
    @endforeach

    <div class="form-group">
        <label>
            Sheep's count:
            <input class="form-control" type="text" id="sheep-count">
        </label>
        <button class="btn btn-primary" id="js-slaughter">Slaughter</button>
    </div>

    <div class="form-group">
        <button class="btn btn-primary" id="js-start">Start counter</button>
    </div>
    
    <div class="form-group">
        <a class="btn btn-primary" href="{{ route('report.generate') }}">Get report</a>
    </div>
@stop

@section('scripts')
    <script>
        function getSheepCount() {
            return $('#sheep-count').val();
        }

        $('#js-slaughter').on('click', function () {
            $.ajax({
                'url': '{{ route('cage.slaughter') }}',
                'method': 'POST',
                'data': {
                    'count': getSheepCount()
                },
            }).done(function (response) {
                console.log(response.message);
            }).fail(function (response) {
                console.log(response.responseJSON.message);
            });
        });

        $('#js-start').on('click', function () {
            $.ajax({
                'url': '{{ route('counter.start') }}',
                'method': 'POST'
            });
        });
    </script>
@stop