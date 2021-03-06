<div id="filter" class="container row" style="display:none" >
    <div id="category_filter" class="w-100">
	<form method="GET" action="{{ $filterAction or Request::url() }}">
	@if (!isset($withoutAuthor))
	    <div class="form-group row">
                <label for="username" class="col-md-4 col-form-label text-md-right">Поиск по имени автора</label>
                <div class="col-md-6">
		    <input class="w-100" id="username" type="text" name="username" value="{{ $username or ''}}">
		    @if ($errors->has('username'))
                    	<span class="invalid-feedback">
                            <strong>{{ $errors->first('username') }}</strong>
                        </span>
                    @endif
		</div>
            </div>
	@endif
	@if (!isset($withoutCategory))
	    <div class="form-group row">
            	<label for="category" class="col-md-4 col-form-label text-md-right">Категория</label>

		<div class="col-md-6">
		    <select id="category" class="input-medium" name="category">
			<option value="">Любая</option>
			@foreach($categories as $category1)
			    @if ($category1->id == $category)
			    	<option value="{{$category1->id}}" selected="selected">{{$category1->name}}</option>
			    @else
				<option value="{{$category1->id}}">{{$category1->name}}</option>
			    @endif
		        @endforeach  	  
		    </select>
		</div>
	    </div>

	@endif
	@if (!isset($withoutTags))
	    <div class="form-group row">
		<label for="tags" class="col-md-4 col-form-label text-md-right">Тэги</label>

		<div class="col-md-6">            
            	    <select class="js-example-basic-multiple input-medium" name="tags[]" multiple="multiple">
			@foreach($alltags as $tag)
			    <option value="{{$tag->id}}">{{$tag->name}}</option>
			@endforeach  	  
		    </select>
		</div>
	    </div>

	@endif
	@if (!isset($withoutDate))
	    <div class="form-group row">
                <label for="daterange" class="col-md-4 col-form-label text-md-right">Дата публикации с/по</label>

                <div class="col-md-6">
		    <input class="w-100" id="daterange" type="text" name="daterange" value="{{ $daterange or ''}}">
		    @if ($errors->has('daterange'))
                    	<span class="invalid-feedback">
                            <strong>{{ $errors->first('daterange') }}</strong>
                        </span>
                    @endif
		</div>
            </div>
	@endif

            <div align="center" style="margin-top:20px">          
		<button type="submit" class="btn btn-primary" >
		    Применить фильтры
		</button>
	    </div>
        </form>
    </div>
</div>

@if (!isset($withoutName))
<div id="find_block" class="container row" style="display:none">
    	<form method="GET" class="w-100" action="{{ $filterAction or Request::url() }}">
	
	    <div class="form-group row">
                <label for="name" class="col-md-4 col-form-label text-md-right">Поиск по названию/описанию</label>

                <div class="col-md-6">
		    <input class="w-100" id="name" type="text" name="name" value="{{ $name or ''}}">
		    @if ($errors->has('name'))
                    	<span class="invalid-feedback">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
		</div>
            </div>

            <div align="center" style="margin-top:20px">          
		<button type="submit" class="btn btn-primary" >
		    Поиск
		</button>
	    </div>
        </form>
</div>
@endif

<script type="text/javascript">
    $(document).ready(function() {
	var tag=getUrlParameter('tags[]');
	var qcategory=getUrlParameter('category');
	var qusername=getUrlParameter('username');
	var qname=getUrlParameter('name');
	if(tag!=null || qcategory!=null || qusername!=null){
	    $('#filter').show();
	}else{
	    if(qname!=null){
		$('#find_block').show();
	    }
	}
	$('#filter_button').click(function(){
	    $('#find_block').hide();
    	    if($('#filter').is(':hidden')){
		$('#filter').show();
	    }else{
		$('#filter').hide();
	    }
	});
	$('#find_button').click(function(){
	    $('#filter').hide();
    	    if($('#find_block').is(':hidden')){
		$('#find_block').show();
	    }else{
		$('#find_block').hide();
	    }
	});
	var drinit='{{$daterange}}';
	$(function() {
    	    $('input[name="daterange"]').daterangepicker({
		autoUpdateInput: false,
		locale: {
        	    cancelLabel: 'Clear'
		}
	    });
	    $('input[name="daterange"]').on('apply.daterangepicker', function(ev, picker) {
	    	$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
  	    });

  	    $('input[name="daterange"]').on('cancel.daterangepicker', function(ev, picker) {
      	    	$(this).val('');
	    });
	});
    });
var valarr=[{{$texttags or ''}}];
$(document).ready(function() {
    $('.js-example-basic-multiple').select2({ width: '100%' });
    $('.js-example-basic-multiple').val(valarr);
    $('.js-example-basic-multiple').trigger('change');
});

</script>
