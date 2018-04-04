@extends('layouts.app')
@section('nav')
    <li class="nav-item dropdown">
	<a class="nav-link" href="#" id="filter_button" role="button" aria-haspopup="true" aria-expanded="false">
	    Фильтры
        </a>
    </li>
    <li class="nav-item dropdown">
	<a class="nav-link" href="#" id="find_button" role="button" aria-haspopup="true" aria-expanded="false">
	    Быстрый поиск
        </a>
    </li>
@endsection


@section('content')
<div class="container" style="margin-top:20px">
    <div class="row justify-content-center">
	@include('article.filters', ['withoutAuthor' => 'true'])
        <div class="col-md-12" style="margin-top:30px">
            <div class="card">
    		<div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
		    <div class="container card-title">
    			<h2 align="center">{{$user->name}}</h2>
		    </div>
		    <p class="card-text">{{$user->text}}</p>
		    <div style="margin-top:20px">
			@if ($isSubscribed)

			@else
			<a href="{{route('subscribe_on_user', ['id' => $user->id])}}"  class="btn btn-success clickable" data-effect="fadeOut">
	    		    <span aria-hidden="true">Подписаться</span>
	    		</a>
			@endif
			@if ($isAdmin)
			    <a href="{{route('edit_user', ['id' => $user->id])}}"  class="btn btn-primary clickable" data-effect="fadeOut">
	    		    	<span aria-hidden="true">Редактировать</span>
			    </a>
			    @if ($user->status)
				<a href="{{route('lock_user', ['id' => $user->id])}}"  class="btn btn-warning clickable" data-effect="fadeOut">
	    		    	    <span aria-hidden="true">Заблокировать</span>
				</a>
			    @else
				<a href="{{route('unlock_user', ['id' => $user->id])}}"  class="btn btn-warning clickable" data-effect="fadeOut">
	    		    	    <span aria-hidden="true">Разблокировать</span>
				</a>
			    @endif
			    @if ($user->id != Auth::user()->id)
			    	<a href="{{route('remove_user', ['id' => $user->id])}}"  class="btn btn-danger clickable" data-effect="fadeOut">
	    		    	    <span aria-hidden="true">Удалить</span>
			    	</a>
			    @endif
			@endif
		    </div>
		</div>
	    </div>
	    <h2 align="center" style="margin-top:20px">Лучшие статьи пользователя</h2>
	    @include('article.ajax', ['page' => '', 'articles' => $maxArticles])
	    <h2 align="center" style="margin-top:20px">Статьи пользователя({{$user->count}})</h2>
	    
	    @include('article.list')
		
        </div>
    </div>
</div>
@endsection
