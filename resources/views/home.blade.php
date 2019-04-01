@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
            @foreach($posts as $post)
            <div class="card">
                <div class="card-header">{{ $post->title }}</div>
                <p class="card-body">{{ $post->article }}
                </p>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
