<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	<h4 class="modal-title" id="editWishlistModal">Rediģēt sarakstu</h4>
</div>

{{ Form::open(array('id' => 'editWishlistForm', 'class' => 'form-horizontal', 'role' =>'form')) }}
	<div class="modal-body">
		<div id="validation-errors" class="alert alert-danger" style="display: none"></div>
		<div class="form-group">
			{{ Form::label('title', 'Nosaukums', array('class'=>"col-sm-2 control-label")) }}
			<div class="col-sm-10">
				{{ Form::text('title', $wishlist->title, array('class'=>"form-control", 'placeholder'=>"Mans foršais vēlmju saraksts", 'required'=>"required")) }}
			</div>
		</div>

		<div class="form-group">
			{{ Form::label('description', 'Apraksts', array('class'=>"col-sm-2 control-label")) }}
			<div class="col-sm-10">
			{{ Form::textarea('description', $wishlist->description, array('class'=>"form-control", 'placeholder'=>"Mans foršais vēlmju saraksta apraksts", 'required'=>'required')) }}
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<div class="pull-right">
					{{ Form::button('Atcelt', array('data-dismiss'=>"modal", 'class'=>"btn btn-default")) }}
					<button id="loadingButton" type="submit" data-loading-text="Saglabā..." class="btn btn-primary">Saglabāt</button>
				</div>
			</div>
		</div>
	</div>
{{ Form::close() }}

<script type="text/javascript">
	$(document).ready(function() {
		ajaxForm('editWishlistForm', '/wishlists/{{ $wishlist->id }}', 'PUT', true);
	});
</script>