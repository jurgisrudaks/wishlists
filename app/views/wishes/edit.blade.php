<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	<h4 class="modal-title" id="addNewWish">Rediģēt vēlmi</h4>
</div>

{{ Form::open(array('id' => 'editWishForm', 'class' => 'form-horizontal', 'role' => 'form')) }}
	<div class="modal-body">
		<div id="validation-errors" class="alert alert-danger" style="display: none"></div>
		<div class="form-group">
			{{ Form::label('title', 'Nosaukums', array('class'=>"col-sm-2 control-label")) }}
			<div class="col-sm-10">
				{{ Form::hidden('wishlistId', $wish->wishlist_id) }}
				{{ Form::text('title', $wish->title, array('class'=>"form-control", 'required'=>"required")) }}
			</div>
		</div>

		<!-- Text input-->
		<div class="form-group">
			{{ Form::label('description', 'Apraksts', array('class'=>"col-sm-2 control-label")) }}
			<div class="col-sm-10">
				{{ Form::textarea('description', $wish->description, array('class'=>"form-control", 'required'=>"required")) }}	
			</div>
		</div>
		<div class="form-group">
			{{ Form::label('link', 'Saite', array('class'=>"col-sm-2 control-label")) }}
			<div class="col-sm-10">
				{{ Form::text('link', $wish->link, array('class'=>"form-control", 'placeholder'=>"Saite, kur iegūt plašāku informāciju")) }}
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<div class="pull-right">
					{{ Form::button('Atcelt', array('data-dismiss'=>"modal", 'class'=>"btn btn-default")) }}
					{{ Form::button('Saglabāt', array('type'=>"submit", 'id'=>"loadingButton", 'data-loading-text'=>"Saglabā...", 'class'=>"btn btn-primary")) }}
				</div>
			</div>
		</div>
	</div>
{{ Form::close() }}

<script type="text/javascript">
	$(document).ready(function() {
		ajaxForm('editWishForm', '/wishes/{{ $wish->id }}', 'PUT', true);
	});
</script>