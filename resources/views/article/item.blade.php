

<div class="col-sm-4"  style="margin-top:30px">
    <div class="card">
	<div class="size" style="height:650px">
	<img class="card-img-top"  src="/{{$article->foto->name}}" alt="{{$article->name}}" >
<div class="card-body">
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
<div class="row container">
    @if (session('status'))
    	<div class="alert alert-success">
            {{ session('status') }}
       	</div>
    @endif
    <div class="container row card-title">
    	<a href="{{ route('articles') }}/{{$article->id}}" class="card-link">
	    <h4>{{$article->name}}</h4>
    	</a>
    </div>
    <p class="card-text">{{$article->date}} 
	от <a href="{{route('users')}}/{{$article->author->id}}">{{$article->author->name}}</a> 
	в категории <a href="{{ route('categories') }}/{{$article->category->id}}">{{$article->category->name}}</a>
    </p>
    <div class="row container">
	Теги :
	<span class="categories">
	@foreach ($article->tags as $tag)
	    <a href="{{route('home')}}?tags[]={{$tag->id}}">{{$tag->name}}</a>
	@endforeach
	</span>
    </div>
    <p class="card-text" >{{$article->description}}</p>
</div>
</div>
</div>
    <a href="{{ route('articles') }}/{{$article->id}}" class="btn btn-primary">Читать далее&ensp;({{$article->comments_count}})</a>

</div>
</div>
