<div class="modal-header">
	{{ Form::button('x', array('class'=>"close", 'data-dismiss'=>"modal", 'aria-hidden'=>"true")) }}
	<h4 class="modal-title" id="changeUrlModal">Mainīt profila saiti</h4>
</div>
{{ Form::open(array('id' => 'changeProfileUrlForm', 'class' => 'form-horizontal', 'role' => 'form')) }}
	<div class="modal-body">
		<div id="url-validation-errors" class="alert alert-danger" style="display: none"></div>
			<p>Lai nomainītu profila saiti, ievadi to zemāk redzamajā laukā</p>
		<div class="input-group">
            <span class="input-group-addon">http://esvelos.lv/</span>
			{{ Form::text('url', $slug, array('id'=>"profileUrl", 'type'=>"text", 'class'=>"form-control")) }}
        </div>
	</div>
	<div class="modal-footer">
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<div class="pull-right">
					{{ Form::button('Atcelt', array('data-dismiss'=>"modal", 'class'=>"btn btn-default")) }}
		{{ Form::button('Mainīt', array('type'=>"submit", 'id'=>"loadingButton", 'data-loading-text'=>"Apstrādā...", 'class'=>"btn btn-primary")) }}
				</div>
			</div>
		</div>
	</div>
{{ Form::close() }}
<script type="text/javascript">
		ajaxForm('changeProfileUrlForm', '/changeUrl', 'POST', true, '#url-validation-errors');
</script>