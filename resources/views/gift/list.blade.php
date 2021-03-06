@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Gift List for {{ $user->name }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <a href="/gift/newForSomeone/{{$user->id}}">Add a gift they don't have listed</a>
                    @if ($gifts->isEmpty())
                        <p>This person doesn't have any gifts listed yet</p>
                    @else
                        <gift-list
                            gifts="{{ $gifts }}"
                            show-claims="{{ json_encode($currentUser !== $user->id) }}"
                            user="{{$user->id}}"
                            filter="receiver_id"
                        />
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
