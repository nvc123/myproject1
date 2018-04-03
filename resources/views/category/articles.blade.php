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
<div class="container">
    <div class="row justify-content-center">
	<h2 class="bd-title" id="content" align="center">{{$title}}</h2>
	@include('article.filters', ['withoutCategory' => 'true'])
	<div>
	    <h2 align="center" style="margin-top:20px">Популярные статьи категории</h2>
	    @include('article.ajax', ['page' => '', 'articles' => $maxArticles])
	</div>
	<div>
	    <h2 align="center" style="margin-top:20px">Популярные авторы категории </h2>
	    @foreach ($users as $user)
	    	@include('user.user', ['user' =>$user])
	    @endforeach
	</div>
	<div>
	    <h2 align="center" style="margin-top:20px">Все статьи категории</h2>
	    @include('article.list')
	</div>
    </div>
</div>
@endsection
