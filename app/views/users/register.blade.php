@extends('layouts.master')

@section('stylesheets')
	{{ HTML::style('css/auth.css') }}
@stop

@section('content')
{{ HTML::image('/img/login_bg.jpg', 'bg', array('class'=>"bg responsive-image")) }}
<div class="container">

	{{ Form::open(array('id' => 'registerForm', 'class' => 'form-signin')) }}
		<h1 class="form-signin-heading text-muted">Reģistrēties</h1>
		@if(Session::has('message'))
			<div id="success-message" class="alert alert-success alert-dismissable">
				{{ Form::button('&times;',array('class'=>"close",'data-dismiss'=>"alert", 'aria-hidden'=>"true")) }}
				{{ Session::get('message') }}
			</div>
		@endif
		<div id="validation-errors" class="alert alert-danger" style="display: none"></div>

		{{ Form::text('first_name', null, array('class'=>"form-control", 'placeholder'=>"Vārds", 'required'=>"", 'autofocus'=>"")) }}
		{{ Form::text('last_name', null, array('class'=>"form-control", 'placeholder'=>"Uzvārds", 'required'=>"")) }}
		{{ Form::email('email', null, array('class' => "form-control", 'placeholder'=>"E-pasta adrese", 'required'=>"")) }}
		{{ Form::password('password',array('class'=>"form-control", 'placeholder'=>"Parole", 'required'=>"")) }}
		{{ Form::password('password_confirmation',array('class'=>"form-control", 'placeholder'=>"Vēlreiz parole", 'required'=>"")) }}
		{{ Form::button('Reģistrēties',array('type'=>"submit",'class'=>"btn btn-lg btn-primary btn-block")) }}
	{{ Form::close() }}

</div>

<!-- Static Modal -->
<div class="modal modal-static fade" id="processing" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center">
                    <img src="http://www.travislayne.com/images/loading.gif" class="icon" />
                    <h4>Reģistrēju...</h4>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
	
@stop

@section('scripts')
	{{ HTML::script('js/validator.js') }}
	<script type="text/javascript">
		$(document).ready(function() {
			ajaxForm('registerForm', '/user', 'POST', false);
			$('body').on('hidden.bs.modal', '.modal', function () {
	            $(this).removeData('bs.modal');
	        });
		});
	</script>
@stop