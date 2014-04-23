<div class="modal-header">
	{{ Form::button('x', array('class'=>"close", 'data-dismiss'=>"modal", 'aria-hidden'=>"true")) }}
	<h4 class="modal-title" id="addWishlistModal">Pievienot jaunu sarakstu</h4>
</div>

{{ Form::open(array('id' => 'addWishlistForm', 'class' => 'form-horizontal', 'role' =>'form')) }}
	<div class="modal-body">
		<div id="validation-errors" class="alert alert-danger" style="display: none"></div>
		<div class="form-group">
			{{ Form::label('title', 'Nosaukums', array('class'=>"col-sm-2 control-label")) }}
			<div class="col-sm-10">
				{{ Form::text('title', null, array('class'=>"form-control", 'placeholder'=>"Mans foršais vēlmju saraksts", 'required'=>"required")) }}
			</div>
		</div>

		<div class="form-group">
			{{ Form::label('description', 'Apraksts', array('class'=>"col-sm-2 control-label")) }}
			<div class="col-sm-10">
				{{ Form::textarea('description', null, array('class'=>"form-control", 'placeholder'=>"Mans foršais vēlmju saraksta apraksts", 'required'=>'required')) }}
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<div class="pull-right">
					{{ Form::button('Atcelt', array('data-dismiss'=>"modal", 'class'=>"btn btn-default")) }}
					{{ Form::button('Pievienot', array('type'=>"submit", 'id'=>"loadingButton", 'data-loading-text'=>"Pievieno...", 'class'=>"btn btn-primary")) }}
				</div>
			</div>
		</div>
	</div>
{{ Form::close() }}

<script type="text/javascript">
	$(document).ready(function() {
		ajaxForm('addWishlistForm', '/wishlists', 'POST', true);
	});
</script>