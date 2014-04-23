<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	<h4 class="modal-title" id="resetPasswordModal">Paroles atjaunošana</h4>
</div>
{{ Form::open(array('id' => 'resetPasswordForm', 'class' => 'form-horizontal', 'role' => 'form')) }}
	<div class="modal-body">
		<div id="reset-validation-errors" class="alert alert-danger" style="display: none"></div>
			<p>Lai atjaunotu paroli ievadi savu e-pasta adresi zemāk redzamajā laukā un spied pogu "Atjaunot".</p>
		<input id="title" type="email" placeholder="Ievadiet savu e-pasta adresi" class="form-control" name="email">
	</div>
	<div class="modal-footer">
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<div class="pull-right">
					<button type="button" data-dismiss="modal" class="btn btn-default">Atcelt</button>
					<button id="loadingButton" type="submit" data-loading-text="Apstrādā..." class="btn btn-primary">Atjaunot paroli</button>
				</div>
			</div>
		</div>
	</div>
{{ Form::close() }}
<script type="text/javascript">
		ajaxForm('resetPasswordForm', '/reset', 'POST', true, '#reset-validation-errors');
</script>