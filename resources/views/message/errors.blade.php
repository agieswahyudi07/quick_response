@if ($errors->any())
<div class="alert alert-danger">
<ul>
    @foreach ($errors->all() as $item)
        <li>
            {{ $item }}
        </li>
    @endforeach
</ul>   
</div>
@endif

@if (Session::has('success'))
    <div class="alert alert-success">{{ Session::get('success'); }}</div>
@endif

@if (Session::has('failed'))
    <div class="alert alert-danger">{{ Session::get('failed'); }}</div>
 @endif
    



