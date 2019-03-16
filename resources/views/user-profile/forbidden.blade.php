@extends('index')
@section('title', 'User Not Found - ' . config('app.name', ''))

@section('content')
<div class="container">
    <section class="hero">
        <div class="hero-body">
            <div class="container">
                <h1 class="title">User not found</h1>
                <p>
                    The user you've been looking for is not here. Sorry.
                </p>
            </div>
        </div>
    </section>
</div>
@endsection