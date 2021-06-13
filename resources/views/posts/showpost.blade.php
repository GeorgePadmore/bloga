@extends('layouts.custom_app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Posts') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                   {{-- {{ __('You are logged in!') }} --}}

                   <img src="{{ asset('images/jj_rawlings.png') }}" alt="{{$post->title}}" style="width: 100%">
                    <h2>{{$post->title}}</h2>
                    <p>{{ $post->desc }}</p>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
