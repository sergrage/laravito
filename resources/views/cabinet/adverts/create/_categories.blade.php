<ul>
    @foreach($categories as $category)
    <li>
        <a href="{{ route('cabinet.adverts.create.region', $category) }}"> {{ $category->name }}  </a>
        
        @include('cabinet.adverts.create._categories', ['categories' => $categories->children])
    </li>
    
    
</ul>