@extends('layouts.php')

@section('content')
    @if($region)

    <p>
        <a href=" {{ route('cabinet.adverts.create.advert', [$category, $region]) }}" class="btn btn-success">Add Advert for {{ $region->name }}</a>
    </p>
    
    <@else>
    
    <p>
        <a href=" {{ route('cabinet.adverts.create.advert', [$category]) }}" class="btn btn-success">Add Advert for all region</a>
    </p>
    
    @endif
    
    <p>Or choose nested region:</p>
    
    <ul>
        @foreach($region as $item) {
            <li> 
              <a href=" {{ route('cabinet.adverts.create.region'), [$category, $region] }} ">{{ $item->name }}</a>
           </li>
        }
        @endforeach
    </ul>

    @include('cabinet.adverts.create._categories', ['categories' => $categories])

@endsection