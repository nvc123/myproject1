@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
	<h2 class="bd-title" id="content" align="center">{{$title}}</h2>
	@if ($isAdmin)
	<div class="container row" style="margin-top:10px">
	    <button onclick="edit(0, '')"  class="btn btn-success clickable" data-effect="fadeOut">
	    	<span aria-hidden="true">Добавить категорию</span>
	    </button>
	</div>
	@endif
	<div class="w-100" style="margin-top:30px">
	@foreach ($categories as $category)
            <div class="card w-100">
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
		    <a href="{{route('categories')}}/{{$category->id}}">{{$category->name}}</a>
		    @if ($isAdmin)
		    <div class="float-right">
		    	<button onclick="edit({{$category->id}}, '{{$category->name}}')" class="btn btn-warning clickable" style="margin-right:10px" data-effect="fadeOut">
	    		    <span aria-hidden="true">Редактировать</span>
	    	    	</button>
		    	<a href="{{route('remove_category', ['id' => $category->id])}}" class="btn btn-danger clickable" data-effect="fadeOut">
	    		    <span aria-hidden="true">Удалить</span>
	    	    	</a>
                    </div>
		    @endif
                </div>
            </div>
	@endforeach
	</div>
    </div>
</div>
@if($isAdmin)
<script type="text/javascript">
function edit(cid, cname){
    var text = prompt("Введите название категории", cname);
    if (text != null) {
	var newurl='{{route('categories')}}/'+cid+'/edit?name='+text;
	window.location.href = newurl;
    }
}
@if (session('message'))
    alert('{{session('message')}}');
@endif
</script>
@endif
@endsection
