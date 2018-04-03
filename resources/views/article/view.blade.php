@extends('layouts.app')

@section('content')
<style type="text/css">
ul {
    list-style: none outside none;
    padding-left: 0;
}
.gallery li {
    display: block;
    float: left;
    margin-bottom: 6px;
    margin-right: 6px;
}
.gallery li a img {
    max-width: 126px;
}
.test {
    background: none repeat scroll 0 0 #fff;
    left: 500px;
    position: absolute;
    top: 100px;
}
</style>
<div class="container" style="margin-top:20px">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
    		<div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
		    <div class="container row card-title">
    	    		<h2>{{$article->name}}</h2>
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
		    <div class="row container" align="center">
    		    	<img src="/{{$article->foto->name}}" alt="{{$article->name}}">
    		    </div>
		    <p class="card-text">{{$article->text}}</p>
		    <h3 align="center">Галерея</h3>
		    <div class="row container" style="margin-top:50px">
			@foreach ($article->imgs as $img0)
				<a href="/{{$img0->name}}" data-toggle="lightbox" data-gallery="example-gallery" style="margin-bottom:12px;margin-right:12px">
                		    <img src="/{{$img0->name}}" class="img-fluid"  width="126px">
            			</a>
			@endforeach
		    </div>
		    @if(count($article->files))
		    <div style="margin-top:50px">
			<h3 align="center">Файлы</h3>
			@each('file.file', $article->files, 'file')
		    </div>
		    @endif
		    @if ($isOwner || $isModerator)
		    <div style="margin-top:50px">
			<h3 align="center">Управление</h3>
			@if ($isOwner)
			    @if ($article->status=='new')
			    	<a href="{{route('moderated', ['id' => $article->id])}}" class="btn btn-primary">Отправить на модерацию</a>
			    @endif
			@endif
			@if ($isModerator)
			    @if ($article->status=='moderated')
			    	<a href="{{route('published', ['id' => $article->id])}}" class="btn btn-primary">Опубликовать</a>
			    	<button onclick="notPublished()" class="btn btn-primary">Снять с публикации</button>
			    @endif
			    @if ($article->status=='published')
			    	<button onclick="lock()" class="btn btn-warning">Заблокировать статью</button>
			    @endif
			@endif
			<a href="{{route('article_edit', ['id' => $article->id])}}" class="btn btn-success">Редактировать</a>
			<a href="{{route('article_remove', ['id' => $article->id])}}" class="btn btn-danger">Удалить</a>
		    </div>
		    @endif
                </div>
            </div>
	    <div style="margin-top:20px">
		<h4 align="center" >Похожие статьи:</h4>
		@include('article.ajax', ['page' => '', 'articles' => $likeArticles])
	    </div>
	    <h2 align="center" style="margin-top:20px">Комментарии:</h2>
	    <div style="margin-top:20px">
		@each('comment.view', $article->comments, 'comment')
		<div class="card">
    		    <div class="card-body">
			<div class="container row card-title ">
			    <h4>Ваш комментарий:</h4>
    			</div>
			<form method="POST" action="{{ route('articles') }}/{{$article->id}}">
                        @csrf
                        <div class="form-group row">
                            
                            <div class="col-md-12">
                                <textarea id="text" class="form-control{{ $errors->has('text') ? ' is-invalid' : '' }}" name="text" required></textarea>

                                @if ($errors->has('text'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('text') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    Отправить
                                </button>
                            </div>
                        </div>
                    </form>
		    </div>
		</div>
	    </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
                event.preventDefault();
                $(this).ekkoLightbox();
            });
function notPublished(){
    var text = prompt("Введите причину снятия с публикации");
    if (text != null) {
	var newurl='{{route('not_published', ['id' => $article->id])}}?text='+text;
	window.location.href = newurl;
    }
}
function lock(){
    var text = prompt("Введите причину блокировки");
    if (text != null) {
	var newurl='{{route('locked', ['id' => $article->id])}}?text='+text;
	window.location.href = newurl;
    }
}
</script>
@endsection
