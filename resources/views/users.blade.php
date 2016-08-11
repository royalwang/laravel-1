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
					<th>name</th>
					<th></th>
				</tr>
			</thead>
			<tbody class="user-form">
			</tbody>
		</table>
	</div>
	<div class="col-md-3">
		<div class="user-right">
			<div class="row">
				<div class="col-md-12">
			        <form name="add-user">
				        <h4>add_new_account</h4>
			            <div class="form-group has-feedback">
			                <input type="text" class="form-control" placeholder="Name" name="name" value="{{ old('name') }}"/>
			                <span class="glyphicon glyphicon-user form-control-feedback"></span>
			            </div>
			            <div class="form-group has-feedback">
			                <input type="password" class="form-control" placeholder="Password" name="password"/>
			                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
			            </div>
			            <div class="form-group has-feedback">
			                <input type="password" class="form-control" placeholder="Password Confirmation" name="password_confirmation"/>
			                <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
			            </div>
			            <div class="form-group">
			                    <button id="add-user" onclick="addUser();return false;" type="submit" class="btn btn-primary btn-block btn-flat">submit</button>
			            </div>  
			        </form>
				       
			    </div>    
	        </div>
	        <div class="row">
		    	<div class="col-md-12">
		    		<h4>user_bat</h4>
		    		<div class="row">
			    		<div class="col-md-6">
			    			<button id="add-user" onclick="delUser();return false;" type="submit" class="btn btn-primary btn-block btn-flat">删除所有用户</button>
			    		</div>	
			    		<div class="col-md-6">	
			    			<button id="add-user" onclick="resetUser();return false;" type="submit" class="btn btn-primary btn-block btn-flat">重置用户权限</button>
			    		</div>	
		    		</div>	
		    	</div>
		    </div>
	    </div>
	</div>
</div>	

<script type="text/template" name="users-form">  
<tr>  
    <td></td>  
    <td>{created_at}</td>  
    <td>{name}</td>  
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
