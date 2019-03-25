@extends('layouts.app')

@section('content')
    <ul class="nav nav-tabs mb-3">
        <li class="nav-item"><a class="nav-link active" href="{{ route('cabinet.home') }}">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('cabinet.profile.home') }}">Profile</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('cabinet.adverts.index') }}">Adverts</a></li>

    </ul>
@endsection