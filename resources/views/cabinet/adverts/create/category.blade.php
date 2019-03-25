@extends('layouts.php')

@section('content')

    <p>Choose category:</p>

    @include('cabinet.adverts.create._categories', ['categories' => $categories])

@endsection