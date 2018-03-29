<div class="container">
<div id="preload" align="center" style="display:none">
    <div class="loader"></div>
</div>
<div id="items">
<div id="page{{$page or 0}}">
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
</div>
<div id="load" align="center" style="display:none">
    <div class="loader"></div>
</div>
</div>

<script type="text/javascript">
// TODO: Быдлокод
var isLoading=false;
var debug=false;
var enable={{$page or false}};
var first=true;
var page=getUrlParameter('page');
if(page===undefined){
    page='1';
}
if(enable){
    page=Number(page);
    $(window).on('scroll', function () {
            //console.log("scroll");
	    var top=$(window).scrollTop() ;
	    var nextp=findNextPage(page, top);
	    if(debug){
		alert(top);
		alert(nextp);
	    }
	    //var name='#page'+page;
	    //alert(name);
	    //var height=$(name).offset().top + $(name).height() - window.innerHeight;// $(document).height() - window.innerHeight - 10;
            if (!isLoading && nextp > page) {
		

		var next=$('#page'+(nextp)).height();
		if(next==null){
		    
                //alert(height);
		//page++;
		//$(document).documentElement.clientHeight
		    loadMore(nextp, true);
		}else{
			
		    page=nextp;
		    window.history.pushState("object or string", "Title", getUrlWithoutPage()+"page="+page);
		}
                //count++;
            }else{
		var prevp=findPrevPage(page, top);
		if (!isLoading && prevp < page){
		    var prev=$('#page'+(prevp)).height();
		    if(prev==null){
			//alert('prev'+prev)
			loadMore(prevp, false);
		    }else{
			page=prevp;
			window.history.pushState("object or string", "Title", getUrlWithoutPage()+"page="+page);
		    }
		}else{
		    if(!isLoading && !first && page == 1 && top <= 0){
			reload();
		    }
		}
	    }
	    first=false;
        }).scroll();
}
function loadMore(newPage, toEnd) {
	    isLoading=true;
            var url = getUrlWithoutPage() + "page=" + newPage;
            if (toEnd) {
                $('#load').show();
	    }else{
		$('#preload').show();
	    }
                $.ajax({
                    type: "GET",
                    url: url,
                    success: function (response) {
                        if (response) {
                            //didGetData = true;
			    isLoading=false;
			    if(toEnd){
				$('#items').append(response);
				//alert('load'+toEnd);
			    }else{
				$('#items').prepend(response);
				$("html,body").scrollTop($('#page'+(newPage+1)).offset().top);
			    }
			    page=newPage;
			    window.history.pushState("object or string", "Title", url);
			} else {
                            //didGetData = false;
			    isLoading=false;
			    
                        }
            		if (toEnd) {
            		    $('#load').hide();
	    		}else{
			    $('#preload').hide();
			}
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                        console.log(textStatus);
			console.log('error load');
			isLoading=false;
            		if (toEnd) {
            		    $('#load').hide();
	    		}else{
			    $('#preload').hide();
			}
                    }
                });
            //}
        }

function reload() {
	    isLoading=true;
            var url = getUrlWithoutPage() + "page=" + 1;
		$('#preload').show();
                $.ajax({
                    type: "GET",
                    url: url,
                    success: function (response) {
                        if (response) {
                            //didGetData = true;
			    isLoading=false;
				$('#items').html(response);
				//$("html,body").scrollTop($('#page'+(newPage+1)).offset().top);
			    page=1;
			    window.history.pushState("object or string", "Title", url);
			} else {
                            //didGetData = false;
			    isLoading=false;
			    
                        }
			$('#preload').hide();
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                        console.log(textStatus);
			console.log('error load');
			isLoading=false;
            		$('#preload').hide();
                    }
                });
            //}
        }

function findNextPage(index, top)
{
    var name='#page'+index;
    var next=$('#page'+(index)).height();
    if(next==null){
	return index;
    }
    var height=$(name).offset().top + $(name).height() - window.innerHeight;// $(document).height() - window.innerHeight - 10;
    if (height >10 && top >= height) {
	return findNextPage(index+1);
    }else{
	return index;
    }
}

function findPrevPage(index, top)
{
    var name='#page'+index;
    var next=$('#page'+(index)).height();
    if(next==null){
	return index;
    }
    if (index>1 && top < $(name).offset().top) {
	return findNextPage(index-1);
    }else{
	return index;
    }
}

function getUrlWithoutPage()
{
    var sPageURL = decodeURIComponent(window.location.search.substring(1));
    var sURLVariables = sPageURL.split('page=')
    var result=sURLVariables[0];
    if(result.indexOf('=')==-1){
	result+='?';
    }else{
	result='?' + result;
	if(sURLVariables.length==1){
	    result+='&';
	}
    }
    return result;
}
</script>

