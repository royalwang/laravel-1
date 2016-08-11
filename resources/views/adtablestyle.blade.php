@extends('layouts.app')

@section('htmlheader_title')
	Manger User
@endsection

@section('style')
@parent
<link href="{{ asset('/css/adtablestyle.css') }}" rel="stylesheet">
@endsection

@section('main-content')
	
	
<div class="cover">
	<div class="cover-bg"></div>
	<div class="cover-content">
		<span></span>
	</div>
</div>	
<div class="container">
	
	<div class="row">
		<div class="col-md-12">
			<h3> {{ trans('adtable.ad_table_style') }}</h3>
		</div>	

		<div class="col-md-3">
			<div class="default-col">
				@foreach($style as $k=>$v)
				<span>{{ trans('adtable.'.$v) }}<div>A{{ $k }}:</div></span>
				@endforeach
			</div>
		</div>
		<div class="col-md-9">
			
			<div class="table_style">
				<form name="col_table">
					<table class="form-table">
						<thead>
							<tr>
								<th>{{ trans('adtable.ad_table_style_colname') }}</th>
								<th>{{ trans('adtable.ad_table_style_colvalue') }}</th>
								<th width="160">{{ trans('adtable.ad_table_style_colsort') }}</th>
							</tr>
						</thead>
						<tbody id="style-col-body">	
						</tbody>
						<tfoot>
							<tr>
								<td colspan="3">
									<a class="help"><i class="fa fa fa-info"></i></a>
									<button onclick="return colAdd();">add_new</button>
									<button onclick="return saveForm();">save</button>
								</td>
							</tr>
						</tfoot>
					</table>
				</form>	
			</div>
		</div>
		
	</div>


</div>




<script type="text/template" name="style-form">  
<tr>
	<td><input name="name[]" value="{name}"></td>
	<td><input name="value[]" value="{value}"></td>
	<td>
		<a class="up" onclick="colUpDown(this,'long-up')"><i class="fa fa-long-arrow-up" ></i></a>
		<a class="up" onclick="colUpDown(this,'up')"><i class="fa fa-arrow-up"></i></a>
		<a class="down" onclick="colUpDown(this,'down')"><i class="fa fa-arrow-down"></i></a>
		<a class="down" onclick="colUpDown(this,'long-down')"><i class="fa fa-long-arrow-down"></i></a>
		<a onclick="colDel(this)"><i class="fa fa-close"></i></a>
	</td>
</tr>
</script> 


<script type="text/javascript">

var $cover = $('.cover');
var $cover_bg = $('.cover-bg');
var $cover_content = $('.cover-content');

var $styleColBody = $('#style-col-body');
var styleColhtml = $('script[name=style-form]').html();
var loading_img = '<img src="{{ asset('img/loading.gif') }}">';

getForm();


coverInit()
$(window).resize(coverInit);


function coverShow(html ='',sw = true){
    if(sw == true)
        $cover.addClass('show');
    else
        $cover.removeClass('show');
    $cover_content.children('span').html(html);
}

function coverInit(){
    

    var cover_width = $cover.next().outerWidth(true);
    var cover_height = $cover.next().outerHeight(true);

    var content_width = $('.cover-content').outerWidth();
    var content_height = $('.cover-content').outerHeight();

    $cover_bg.css({
        'width':cover_width,
        'height':cover_height,
    });

    $cover_content.css({
        'left': (cover_width-content_width)/2 + 'px',
        'top': (cover_height-content_height)/2-100 + 'px',
    })

}


function formatTemplate(dta, tmpl) {  
    var format = {  
        toKey : function(x){
        	if(keyJson[x] != undefined ){
        		return keyJson[x];
        	}
        	return x;
        },
        status : function(x){
        	alert(x);
        }
    };  

    return tmpl.replace(/{(.*)}/g, function(m1, m2) {  

        if(!m2) return "";  
        return dta[m2]; 

    });  
} 

function colUpDown(obj,statu = 'up'){
	var $objTr = $(obj).parents('tr');
	if(statu == 'up'){
		$prevTr = $objTr.prev();
		$objTr.insertBefore($prevTr);
	}else if(statu == 'long-up'){
		$objTr.prependTo($styleColBody);
	}else if(statu == 'down'){
		$nextTr = $objTr.next();
		$objTr.insertAfter($nextTr);
	}else if(statu == 'long-down'){
		$objTr.appendTo($styleColBody);
	}

}

function colDel(obj){
	var $objTr = $(obj).parents('tr').remove();
}

function colAdd(){
	$styleColBody.append(styleColhtml);
	return false;
}

function fillTable($data){
	var html = $('script[name="style-form"]').html();  
    var arr = [];  
    $.each($data, function(i, o) {   
        arr.push(formatTemplate(o, html));  
    });  

    $styleColBody.html(arr.join(''));

}

function getForm(){
	ajaxForm();
	return false;
}

function saveForm(){
	ajaxForm($("form[name=col_table]").serialize());
	return false;
}

function ajaxForm($data = ''){
	coverShow(loading_img,true);
	$.ajax({
		url: "{{ asset('/ajax/adtablestyle') }}",
		data: $data,
		type: "post",
		dataType: "json",
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} ,
		success: function(d){
			if(!d  || d['e'] == 1) return false;
			fillTable(d['d'])
		},
		complete:function(){
			coverShow('',false)
		}
	});
}

</script>
	
@endsection
