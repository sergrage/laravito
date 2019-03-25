@extends('layouts.app')

@section('content')
    @include('admin.adverts.categories._nav')

    <p><a href="{{ route('admin.adverts.categories.create') }}" class="btn btn-success">Add Category</a></p>

    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>Name</th>
            <th>Slug</th>
        </tr>
        </thead>
        <tbody>

        @foreach ($categories as $category)
            <tr>
                @if ($category->depth == 0)
                    <td class="table-primary">
                @else
                    <td>
                @endif
                    @for ($i = 0; $i < $category->depth; $i++) &mdash; @endfor
                    <a href="{{ route('admin.adverts.categories.show', $category) }}">{{$category->parent_id}}  - {{$category->name }}</a>
                </td>
                @if ($category->depth == 0)
                    <td class="table-primary">
                @else
                    <td>
                @endif
                    {{ $category->slug }}
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>
@endsection