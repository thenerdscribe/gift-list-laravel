@extends('layouts.app')

@section('content')
    <div class="container">
        @csrf
        @if ( isset($gift) )
            <gift-create method="patch" url="/gift/{{ $gift->id }}" gift="{{ $gift }}" ></gift-create>
        @else
            <gift-create method="post" url="/gift/create/" gift=""></gift-create>
        @endif
    </div>
@endsection
