@extends('layouts.php')

@section('content')

    <form method="post" action=" {{ route('cabinet.adverts.create.advert.store', [$category, $region]) }} ">
        @csrf
        
        <div class="card mb-3">
            <div class="card-header">
                Common
            </div>
            <div class="card-body pb-2">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="title" class="col-form-label">Title</label>
                            <input type="text" id="title" class="form-controll{{ $errors->has('title') ? ' is-invalid' : '' }}"  name="title" value="{{ old('title') }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="price" class="col-form-label">Price</label>
                            <input type="text" id="price" class="form-controll{{ $errors->has('price') ? ' is-invalid' : '' }}"  name="price" value="{{ old('price') }}" required>
                            @if ($errors->has('price'))
                                <span class="invalide-feedback"><strong>  {{ $errors->first('price') }}  </strong></span>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="address" class="col-form-label">Address</label>
                    <input type="text" id="price" class="form-controll{{ $errors->has('address') ? ' is-invalid' : '' }}"  name="address" value="{{ old('address', $region->getAddress()) }}" required>
                    @if ($errors->has('address'))
                        <span class="invalide-feedback"><strong>  {{ $errors->first('address') }}  </strong></span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="сontent" class="col-form-label">Content</label>
                    <textarea type="text" id="сontent" class="form-controll{{ $errors->has('сontent') ? ' is-invalid' : '' }}"  name="сontent" value="{{ old('сontent') }}" required></textarea>
                    @if ($errors->has('сontent'))
                        <span class="invalide-feedback"><strong>  {{ $errors->first('сontent') }}  </strong></span>
                    @endif
                </div>
                
            </div>
            
            
        </div>
        
        <div class="card mb-3">
            <div class="card-header">
                Characteristics
            </div>
            <div class="card-body pb-2">
                @foreach($category->allAttributes() as $attribute)
                    
                @endforeach
            </div>
        </div>
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
    </form>

    @include('cabinet.adverts.create._categories', ['categories' => $categories])

@endsection