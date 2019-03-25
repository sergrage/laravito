@extends('layouts.app')

@section('content')
    @include('admin.adverts.categories._nav')

    <p><a href="{{ route('admin.adverts.categories.create') }}" class="btn btn-success">Add Category</a></p>

    <div class="container">

    <div class="row align-items-start">
        @for ($i = 0; $i < $catCount[0]; $i++)    
            

            @if($categories[$i]->depth == 0 && $i!=0)
                </ul>
                </div>
            @endif  

            @if ($categories[$i]->depth == 0)
            <div class="col-md-4" style="padding-bottom: 20px;">
                <ul class="list-group">
            @endif  
                
                @if ($categories[$i]->depth == 0)
                    <li class="list-group-item list-group-item-info">
                @else
                    <li class="list-group-item">
                @endif
                    @for ($j = 0; $j < $categories[$i]->depth; $j++) &mdash; @endfor
                        <a href="{{ route('admin.adverts.categories.show', $categories[$i]) }}">{{$categories[$i]->name }} </a>
                    <div class="d-flex flex-row">
                        <form method="POST" action="{{ route('admin.adverts.categories.first', $categories[$i]) }}" class="mr-1">
                            @csrf
                            <button class="btn btn-sm btn-outline-primary p-0 px-1"><span class="fa fa-angle-double-up fa-xs"></span></span></button>
                        </form>
                        <form method="POST" action="{{ route('admin.adverts.categories.up', $categories[$i]) }}" class="mr-1">
                            @csrf
                            <button class="btn btn-sm btn-outline-primary p-0 px-1"><span class="fa fa-angle-up fa-xs"></span></button>
                        </form>
                        <form method="POST" action="{{ route('admin.adverts.categories.down', $categories[$i]) }}" class="mr-1">
                            @csrf
                            <button class="btn btn-sm btn-outline-primary p-0 px-1"><span class="fa fa-angle-down fa-xs"></span></button>
                        </form>
                        <form method="POST" action="{{ route('admin.adverts.categories.last', $categories[$i]) }}" class="mr-1">
                            @csrf
                            <button class="btn btn-sm btn-outline-primary p-0 px-1"><span class="fa fa-angle-double-down fa-xs"></span></span></button>
                        </form>
                         <form method="POST" action="{{ route('admin.adverts.categories.destroy', $categories[$i]) }}" class="mr-1">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger p-0 px-1"><span class="fa fa-trash fa-xs"></span></button>
                        </form> 
                    </div>
                   
                    </li>
                
            @if ($i == 127)
                </ul>
            </div>
            @endif
        @endfor 
    </div>
</div>

@endsection