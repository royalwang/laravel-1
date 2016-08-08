@extends('layouts.app')

@section('htmlheader_title')
	Manger User
@endsection

@section('style')
@parent
<link href="{{ asset('/css/user.css') }}" rel="stylesheet">
@endsection

@section('main-content')
	
	
<div class="c-container row">	
	<div class="col-md-9">
		<table class="form-table">	
			<thead>
				<tr>
					<th width="35"></th>
					<th width="180">date</th>
					<th>ID</th>
					<th>balance</th>
					<th>information</th>
					<th>user</th>
					<th>status</th>
					<th></th>
				</tr>
			</thead>
			<tbody class="user-form">
			</tbody>
		</table>
	</div>
	<div class="col-md-3">
		<div class="add-user-form">
        <form name="add-account">
        	<div class="row">
	        	<div class="col-md-5">
	        		<div class="form-group has-feedback">
		                <input type="text" class="form-control" placeholder="ID" name="id" value="{{ old('id') }}"/>
		                <span class="glyphicon glyphicon-link form-control-feedback"></span>
		            </div>
		            <div class="form-group has-feedback">
		                <input type="number" class="form-control" placeholder="Money" name="Money"/>
		                <span class="glyphicon glyphicon-usd form-control-feedback"></span>
		            </div>
	        	</div>
	        	<div class="col-md-7">
	        		<div class="form-group has-feedback">
		                <textarea class="form-control" placeholder="information" name="note"></textarea>
		                <span class="glyphicon glyphicon-book form-control-feedback"></span>
		            </div>
	        	</div>
        	</div>

            <div class="form-group">
                    <button id="add-user" onclick="addUser();return false;" type="submit" class="btn btn-primary btn-block btn-flat">submit</button>
            </div>
        </form>
        </div>
	</div>
</div>	

<script type="text/template" name="users-form">  
<tr>  
    <td></td>  
    <td>{created_at}</td>  
    <td>{id}</td>  
    <td>{money}</td> 
    <td>{note}</td>
    <th>{user}</th>
    <th>{statu}</th>
    <td>
    	<span><a href=""><i class="fa fa-key fa-fw"></i></a></span>
    	<span><a href=""><i class="fa fa-table"></i></a></span>
    	<span><a href=""><i class="fa fa-usd"></i></a></span>
    </td>	
</tr>  
</script> 


<script type="text/javascript">


getUsers();


function formatTemplate(dta, tmpl) {  
    var format = {  
        name: function(x) {  
            return x  
        }  
    };  
    return tmpl.replace(/{(\w+)}/g, function(m1, m2) {  
        if (!m2)  
            return "";  
        return (format && format[m2]) ? format[m2](dta[m2]) : dta[m2];  
    });  
} 

function getUsers(){
	$.ajax({  
	    url:  '{{ asset('/ajax/users') }}',  
	    type: 'post',  
	    dataType: "json",  
	    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, 
	    success: function(d) { 
	    	if (!d || !d['d'] || d['d'].length <= 0 || d['e'] ==1 ) {  
	            return;  
	        }  
	  
	        var html = $('script[name="users-form"]').html();  
	        var arr = [];  

	        $.each(d['d'], function(i, o) {   
	            arr.push(formatTemplate(o, html));  
	        });  
	        $('.user-form').html(arr.join(''));  
	    }  
	}); 
}

function addUser(){
	$.ajax({  
	    url: '{{ asset('/ajax/users/add') }}',  
	    type: 'post',  
	    data: $('form').serialize(),  
	    dataType: "json",  
	    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} ,
	    success: function(d) {  
	    	if (!d || !d['d'] || d['d'].length <= 0 || d['e'] ==1 ) {  
	            return;  
	        }  
	   
	        var html = $('script[name="users-form"]').html();  
	        var arr = [];  

	        $.each(d['d'], function(i, o) {   
	            arr.push(formatTemplate(o, html));  
	        });    
	        $('.user-form').prepend(arr.join(''));  
	    }  
	}); 	
}

</script>
	
@endsection
