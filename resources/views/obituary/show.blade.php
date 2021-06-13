@extends('layouts.custom_app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Obituaries') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                   <img src="{{ asset('images/jj_rawlings.png') }}" alt="{{$post->title}}" style="width: 100%">
                    <h2>{{$post->title}}</h2>
                    <p>{{ $post->desc }}</p>

                    <br><br>
                    <div class="mb-5">
                        @if (\Auth::user())
                            <comments-list :post_id={{$post->id}} :is_admin={{\Auth::user()->id}}></comments-list>
                        @else
                            <comments-list :post_id={{$post->id}}></comments-list>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
