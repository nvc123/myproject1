<div id="page{{$page}}">
@php ($i=0)		
@foreach ($articles as $article)
    @if ($i == 0)
	<div class="row">
    @endif
    @include('article.item', ['article' => $article])
    @php ($i++)
    @if ($i == 3)
	</div>
	@php ($i=0)
    @endif
@endforeach
</div>
