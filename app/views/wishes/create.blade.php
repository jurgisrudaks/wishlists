<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	<h4 class="modal-title" id="createWishModal">Pievienot jaunu vēlmi</h4>
</div>

{{ Form::open(array('id' => 'createWishForm', 'class' => 'form-horizontal', 'role' => 'form')) }}
	<div class="modal-body">
		<div id="validation-errors" class="alert alert-danger" style="display: none"></div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="textinput">Nosaukums</label>
			<div class="col-sm-10">
				<input type="hidden" name="wishlistId" value="{{ $wishlistId }}">
				<input id="title" type="text" placeholder="Jauns auto" class="form-control" name="title">
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-2 control-label" for="textinput">Apraksts</label>
			<div class="col-sm-10">
				<textarea id="description" class="form-control" placeholder="Jauns, ātrs sporta auto sarkanā krāsā..." name="description"></textarea>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="textinput">Saite</label>
			<div class="col-sm-10">
				<input id="link" type="text" placeholder="Saite, kur iegūt plašāku informāciju" class="form-control" name="link">
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<div class="pull-right">
					<button type="button" data-dismiss="modal" class="btn btn-default">Atcelt</button>
					<button id="loadingButton" type="submit" data-loading-text="Pievieno..." class="btn btn-primary">Saglabāt</button>
				</div>
			</div>
		</div>
	</div>
{{ Form::close() }}

<script type="text/javascript">
	$(document).ready(function() {
		ajaxForm('createWishForm', '/wishes', 'POST', true);
	});
</script>