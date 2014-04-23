@extends('layouts.master')

@section('stylesheets')
	{{ HTML::style('css/auth.css') }}
@stop

@section('content')
{{ HTML::image('/img/login_bg.jpg', 'bg', array('class'=>"bg responsive-image")) }}
<div class="container">

	{{ Form::open(array('id' => 'loginForm', 'class' => 'form-signin')) }}
		<h1 class="form-signin-heading text-muted">Pieslēgties</h1>
		@if(Session::has('message'))
			<div id="success-message" class="alert alert-success alert-dismissable">
				{{ Form::button('&times;',array('class'=>"close",'data-dismiss'=>"alert", 'aria-hidden'=>"true")) }}
				{{ Session::get('message') }}
			</div>
		@endif
		@if(Session::has('error'))
			<div id="error-message" class="alert alert-danger alert-dismissable">
				{{ Form::button('&times;',array('class'=>"close",'data-dismiss'=>"alert", 'aria-hidden'=>"true")) }}
				{{ Session::get('error') }}
			</div>
		@endif
		<div id="validation-errors" class="alert alert-danger alert-dismissable" style="display: none"></div>
		{{ Form::email('email', null,array('class' => "form-control", 'placeholder'=>"E-pasta adrese", 'required'=>"", 'autofocus'=>"")) }}
		{{ Form::password('password', array('class'=>"form-control", 'placeholder'=>"Parole", 'required'=>"")) }}
		{{ Form::button('Pieslēgties',array('type'=>"submit",'class'=>"btn btn-lg btn-primary btn-block")) }}
		<center>
			<a id="resetPasswordBtn" style="color:#fff;" data-toggle="modal" data-target="#resetPasswordModal" href="/reset" title="Aizmirsi paroli?">Aizmirsi paroli?</a>
		</center>
	{{ Form::close() }}

</div>

<!-- Processing Modal -->
<div class="modal modal-static fade" id="processing" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center">
                    <img src="/img/loading.gif" class="icon" />
                    <h4>Pieslēdzos...</h4>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reset Password Modal -->
<div class="modal fade" id="resetPasswordModal" tabindex="-1" role="dialog" aria-labelledby="addWishlistModal" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
		</div>
	</div>
</div>
@stop

@section('scripts')
	{{ HTML::script('js/validator.js') }}
	<script type="text/javascript">
		$(document).ready(function() {
			ajaxForm('loginForm', false, 'POST', false);
			$('body').on('hidden.bs.modal', '.modal', function () {
	            $(this).removeData('bs.modal');
	        });
		});
	</script>
@stop