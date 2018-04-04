@extends('layouts.app')

@section('content')
<div class="container" style="margin-top:50px">
    <div class="row justify-content-center">
        <div class="col-md-12">
	    <h1 class="bd-title" id="content" style="text-align:center">{{$title}}</h1>
	    @if ($isAdmin)
		<div class="container row" style="margin-top:10px">
		    <a href="{{route('create_user')}}"  class="btn btn-success clickable" data-effect="fadeOut">
		    	<span aria-hidden="true">Добавить пользователя</span>
		    </a>
		</div>
	    @endif
	
	    <div style="margin-top:20px">
	    	@each('user.user', $users, 'user')
	    </div>
	</div>
    </div>
</div>
@endsection
