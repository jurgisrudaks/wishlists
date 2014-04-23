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
				  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
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
									<label for="first_name">Vārds</label>
									<div class="input-group">
										<span class="input-group-addon">
											<span class="glyphicon glyphicon-user"></span>
										</span>
										<input name="first_name" type="text" class="form-control" id="first_name" value="{{ $user->first_name }}" required="required" />
									</div>
								</div> <!-- form-group -->
								<div class="form-group">
									<label for="name">Uzvārds</label>
									<div class="input-group">
										<span class="input-group-addon">
											<span class="glyphicon glyphicon-user"></span>
										</span>
										<input name="last_name" type="text" class="form-control" id="last_name" value="{{ $user->last_name }}" required="required" />
									</div>
								</div>
								<div class="form-group">
									<label for="email">E-pasts</label>
									<div class="input-group">
										<span class="input-group-addon">
											<span class="glyphicon glyphicon-envelope"></span>
										</span>
										<input name="email" type="email" class="form-control" id="email" value="{{ $user->email }}" required="required" />
									</div>
								</div>
							<div class="actions pull-right">
								<a id="changeprofilePicture" class="btn btn-primary" data-toggle="modal" data-target="#changeProfileImageModal" href="/changeProfilePicture" title="Mainīt bildi"><span class="glyphicon glyphicon-picture"></span> Mainīt profila bildi</a>
								<button type="submit" class="btn btn-primary" id="btnContactUs">Saglabāt</button>
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
								<label for="first_name">Pašreizējā parole</label>
								<div class="input-group">
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-lock"></span>
									</span>
									<input type="password" class="form-control" name="old_password" placeholder="Pašreizējā parole" required="required" />
								</div>
							</div> 
							<div class="form-group">
								<label for="name">Jaunā parole</label>
								<div class="input-group">
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-lock"></span>
									</span>
									<input type="password" class="form-control" name="password" placeholder="Jaunā parole" required="required" />
								</div>
							</div>
							<div class="form-group">
								<label for="email">Jaunā parole vēlreiz </label>
								<div class="input-group">
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-lock"></span>
									</span>
									<input type="password" class="form-control" name="password_confirmation" placeholder="Jaunā parole vēlreiz" required="required" />
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