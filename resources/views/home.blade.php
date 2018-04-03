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
	<h1 class="bd-title" id="content" style="text-align:center">Главная страница</h1>

	@include('article.filters')
	@include('article.list')

    </div>
</div>
@endsection
