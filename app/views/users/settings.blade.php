@extends('layouts.profile')

@section('content')
<div class="jumbotron jumbotron-sm">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-lg-12">
				<h1 class="h1 pull-right">Uzstādījumi</h1>
			</div>
		</div>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			@if(Session::has('message'))
				<div id="success-message" class="alert alert-success alert-dismissable">
					{{ Form::button('&times;', array('class'=>"close", 'data-dismiss'=>"alert", 'aria-hidden'=>"true")) }}
					{{ Session::get('message') }}
				</div>
			@endif
			<div id="validation-errors" class="alert alert-danger" style="display: none"></div>
		</div>
		<div class="col-md-6">
			<div class="well well-sm">
				<fieldset>
					<legend>Pamatinformācija</legend>
					{{ Form::open(array('id' => 'updateProfileInfo')) }}
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									{{ Form::label('first_name', 'Vārds') }}
									<div class="input-group">
										<span class="input-group-addon">
											<span class="glyphicon glyphicon-user"></span>
										</span>
										{{ Form::text('first_name', $user->first_name, array('class'=>"form-control", 'required'=>"required")) }}
									</div>
								</div> <!-- form-group -->
								<div class="form-group">
									{{ Form::label('name', 'Uzvārds') }}
									<div class="input-group">
										<span class="input-group-addon">
											<span class="glyphicon glyphicon-user"></span>
										</span>
										{{ Form::text('last_name', $user->last_name, array('class'=>"form-control", 'required'=>"required")) }}
									</div>
								</div>
								<div class="form-group">
									{{ Form::label('email', 'E-pasts') }}
									<div class="input-group">
										<span class="input-group-addon">
											<span class="glyphicon glyphicon-envelope"></span>
										</span>
										{{ Form::email('email', $user->email, array('class'=>"form-control", 'required'=>"required")) }}
									</div>
								</div>
							<div class="actions pull-right">
								<a id="changeprofilePicture" class="btn btn-primary" data-toggle="modal" data-target="#changeProfileImageModal" href="/changeProfilePicture" title="Mainīt bildi"><span class="glyphicon glyphicon-picture"></span> Mainīt profila bildi</a>
								{{ Form::button('Saglabāt', array('type'=>"submit", 'class'=>"btn btn-primary", 'id'=>"btnContactUs")) }}
							</div>
							</div> <!-- col-md-12 -->
						</div> <!-- row -->
					{{ Form::close() }}
				</fieldset>
			</div> <!-- well well-sm -->
		</div> <!-- col-md-6 -->
		<div class="col-md-6">
			<div class="well well-sm">
				<fieldset>
					<legend>Mainīt paroli</legend>
					{{ Form::open(array('id' => 'changePassword')) }}
						<div class="col-md-12">
							<div class="form-group">
								{{ Form::label('old_password', 'Pašreizējā parole') }}
								<div class="input-group">
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-lock"></span>
									</span>
									{{ Form::password('old_password', array('class'=>"form-control", 'placeholder'=>"Pašreizējā parole",'required'=>"required")) }}
								</div>
							</div> 
							<div class="form-group">
								{{ Form::label('password', 'Jaunā parole') }}
								<div class="input-group">
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-lock"></span>
									</span>
									{{ Form::password('password', array('class'=>"form-control", 'placeholder'=>"Jaunā parole",'required'=>"required")) }}
								</div>
							</div>
							<div class="form-group">
								{{ Form::label('password_confirmation', 'aunā parole vēlreiz') }}
								<div class="input-group">
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-lock"></span>
									</span>
									{{ Form::password('password_confirmation', array('class'=>"form-control", 'placeholder'=>"Jaunā parole vēlreiz",'required'=>"required")) }}
								</div>
							</div>
							<button type="submit" class="btn btn-primary pull-right" id="btnContactUs">Saglabāt</button>
						</div>
					{{ Form::close() }}
				</fieldset>
			</div> <!-- well well-sm -->
		</div> <!-- col-md-6 -->
	</div> <!-- row -->
</div><!-- container -->

<!-- Processing Modal -->
<div class="modal modal-static fade" id="processing" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center">
                    <img src="/img/loading.gif" class="icon" />
                    <h4>Mainu...</h4>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="changeProfileImageModal" tabindex="-1" role="dialog" aria-labelledby="changeProfileImageModal" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
		</div>
	</div>
</div>
@stop

@section('scripts')
	<script type="text/javascript">
		$(document).ready(function() {
			ajaxForm('updateProfileInfo', '/user/{{ $user->id }}', 'PUT', false);
			ajaxForm('changePassword', '/user/{{ $user->id }}', 'PUT', false);
		});
	</script>
@stop