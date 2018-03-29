<div class="card">
    <div class="card-body">
	@if (session('status'))
            <div class="alert alert-success">
        	{{ session('status') }}
            </div>
	@endif
	<div class="container row card-title">
	    <a href="{{ route('users') }}/{{$comment->author->id}}" class="card-link">
	    	<h4>{{$comment->author->name}}</h4>
    	    </a>
    	</div>
	<p class="card-text" style="margin-top:-20px">{{$comment->date}}</p>
	<p class="card-text" style="margin-top:20px">{{$comment->text}}</p>
    </div>
</div>