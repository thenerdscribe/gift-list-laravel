@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Home</div>

                <div class="card-body">
        @csrf
        @if ( isset($gift) )
            <gift-create method="patch" url="/gift/{{ $gift->id }}" gift="{{ $gift }}" ></gift-create>
        @else
            <gift-create method="post" url="/gift/create/" gift=""></gift-create>
        @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
