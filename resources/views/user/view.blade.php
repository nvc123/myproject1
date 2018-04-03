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
