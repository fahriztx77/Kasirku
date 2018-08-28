@extends('website.template')

@section('title')Login | {{ $__CONFIG->name }}@endsection

@section('header')
@endsection

@section('content')
<div class="login-box">
	<div class="login-logo">
		<a href="{{ base_url() }}"><b>LOGIN</b></a>
	</div>
	<div class="login-box-body msg-login" style="display: none;">
		<h1><i class="fa fa-spinner fa-spin"></i> Silakan Tunggu</h1>
	</div>
	<div class="login-box-body body-login">
		<p class="login-box-msg">Sign in to start your session</p>
		<form id="form-data" action="{{ base_url('account/login/submit') }}" method="post">
			<div class="form-group has-feedback">
		    	<input type="email" class="form-control" name="email" placeholder="Email" required="">
		    	<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
		 	</div>
		  	<div class="form-group has-feedback">
		    	<input type="password" class="form-control" name="password" placeholder="Password" required="">
		    	<span class="glyphicon glyphicon-lock form-control-feedback"></span>
		  	</div>
		  	<div class="row">
		  		<div class="col-xs-8">
		  			<label style="margin-top: 10px;"><a href="#">I forgot my password</a></label>
		  		</div>
		    	<div class="col-xs-4">
		      		<button type="submit" class="btn btn-primary btn-block btn-flat">Login</button>
		    	</div>
		  	</div>
		</form>
	</div>
</div>
@endsection

@section('script')
<script type="text/javascript">
	$('#form-data').submit(function(e){

		e.preventDefault();

		$.ajax({
			url:$(this).attr('action'),
			method:'post',
			data:new FormData(this),
	  		processData: false,
	  		contentType: false,
			beforeSend:function(){
				$('.msg-login').html('<h1><i class="fa fa-spinner fa-spin"></i> Silakan Tunggu</h1>');
				$('.body-login').hide();
				$('.msg-login').show();
			}
		}).done(function(response){
			var data = response.data;
			if(response.status == true){
				$('.body-login').hide();
				$('.msg-login').show();
				$('.msg-login').html('<h4>'+data.message+'</h4>');
				window.location.href = data.url;
				return;
			}else{
				alert(data.message);
				return;
			}

		}).fail(function(response){
			var data = response.responseJSON.data;
			$('.body-login').show();
			$('.msg-login').hide();
			// console.log(response);
			$('.login-box-msg').html(data.message);
			return;
		})
	})
</script>
@endsection