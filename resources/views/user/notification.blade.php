<div class="card">
    <div class="card-body">
	<a href="{{route('notifications')}}/{{$notification->id}}" class="btn btn-danger float-right clickable close-icon" data-effect="fadeOut">
	    <span aria-hidden="true">&times;</span>
	</a>
  
	@if (session('status'))
            <div class="alert alert-success">
        	{{ session('status') }}
            </div>
	@endif
	@php($jsonObj=json_decode($notification->payload, true))
	<p class="card-text">
	    @if ($notification->type==0)
		<div class="card-title">
		    <h4>Статус вашей статьи был изменён</h4>
    		</div>
		<a href="{{route('articles')}}/{{$jsonObj['article']}}">Ваша статья</a>
		@if ($jsonObj['status']=='published')
		     была опубликована
		@endif 
		@if ($jsonObj['status']=='not_published')
		     не была опубликована по причине: {{$jsonObj['text']}}
		@endif
		@if ($jsonObj['status']=='locked')
		     была заблокирована по причине: {{$jsonObj['text']}}
		@endif
	    @endif
	    @if ($notification->type==1)
		<div class="card-title">
		    <h4>Новые комментарии</h4>
    		</div>
		
		<a href="{{route('articles')}}/{{$jsonObj['article']}}">У вашей статьи появились новые комментарии</a>
	    @endif
	    @if ($notification->type==2)
		<div class="card-title">
		    <h4>Новая публикация</h4>
    		</div>
		
		<a href="{{route('articles')}}/{{$jsonObj['article']}}">Среди ваших подписок опубликована новая статья</a>
	    @endif
	</p>
    </div>
</div>