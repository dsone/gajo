@extends('index')
@section('title', $userName . ' - Profile - ' . config('app.name', ''))
@section('body-class', 'is-profile')

@section('content')
<div class="container">
    <div class="container-entries animated fadeIn fast"></div>
</div>
@endsection