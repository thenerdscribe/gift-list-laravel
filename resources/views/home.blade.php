@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Home</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <a href="/gift/" class="btn btn-primary">Add gift</a>
                    <h2>Your List</h2>
                    @if ($gifts === "" || $gifts->isEmpty())
                        <p>You don't have any gifts on your list. Add a gift <a href="/gift/">here</a>.</p>
                    @else
                        <gift-list
                            gifts="{{ $gifts }}"
                            show-claims="false"
                            user="{{$currentUser}}"
                            filter="receiver_id"
                            ></gift-list>
                    @endif
                    <h2>Purchases</h2>
                    @if ($gifts === "" || $gifts->isEmpty())
                        <p>You haven't claimed any gifts on other people's lists yet</p>
                    @else
                        <gift-list
                            gifts="{{ $purchases }}"
                            show-claims="true"
                            ></gift-list>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
