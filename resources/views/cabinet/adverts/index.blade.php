@extends('layouts.app')

@section('content')
	<ul class="nav nav-tabs mb-3">
		<li class="nav-item"> <a href="{{ route('cabinet.home') }}" class="nav-link">Dashboard</a> </li>
		<li class="nav-item"> <a href="{{ route('cabinet.profile.home') }}" class="nav-link">Profile</a> </li>
		<li class="nav-item"> <a href="{{ route('cabinet.adverts.index') }}" class="nav-link active">Adverts</a> </li>
	</ul>
	<div class="region-selector" data-selected={{json_encode((array)old('regions'))}} data-source="{{ route('ajax.regions')}}"></div>

@endsection