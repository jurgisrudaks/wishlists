<div class="modal-header">
	{{ Form::button('x', array('class'=>"close", 'data-dismiss'=>"modal", 'aria-hidden'=>"true")) }}
	<h4 class="modal-title" id="changeProfileImageModal">Mainīt vāka attēlu</h4>
</div>

<div class="modal-body">
	<div id="validation-errors" class="alert alert-danger" style="display: none"></div>
	<div id="success" class="alert alert-success" style="display: none"></div>
	{{ Form::open(array('id' => 'changeCover', 'class' => 'dropzone','files' => true)) }}
</div>
<div class="modal-footer">
		{{ Form::button('Atcelt', array('data-dismiss'=>"modal", 'class'=>"btn btn-default")) }}
		{{ Form::button('Mainīt', array('type'=>"submit", 'id'=>"coverImageSubmit", 'data-loading-text'=>"Maina...", 'class'=>"btn btn-primary")) }}
	{{ Form::close() }}
</div>

<script type="text/javascript">
	Dropzone.options.changeCover = {

		paramName: 'cover',
		autoProcessQueue: false,
		uploadMultiple: false,
		parallelUploads: 1,
		maxFiles: 1,
		maxFilesize: 10,
		addRemoveLinks: true,
		acceptedFiles: 'image/*',
		dictDefaultMessage: 'Noklikšķini vai vienkārši ievelc bildi šeit',
		dictRemoveFile: 'Noņemt',
		dictCancelUploadConfirmation: 'Vai tiešām atcelt bildes ielādi?',
		dictCancelUpload: 'Atcelt',
		dictMaxFilesExceeded: 'Var pievienot tikai vienu bildi',
		dictFileTooBig: 'Bildes izmērs pārāk liels',
		dictInvalidFileType: 'Var pievienot tikai bildes',
		headers: {
			'X-CSRF-Token': $('input[name="_token"]').attr('value')
		},

		init: function() {
			var myDropzone = this;
			var btn = $('#coverImageSubmit')
			var errorDiv = "#validation-errors";
			var succDiv = "#success";

			document.querySelector("button[id=coverImageSubmit]").addEventListener("click", function(e) {
				e.preventDefault();
				e.stopPropagation();
				myDropzone.processQueue();
			});

			this.on("sending", function() {
				btn.button('loading')
			});
			this.on("success", function(files, response) {
				$('#changeCoverModal').modal('hide');
				$('#processingImage').modal('show');
				location.reload();
			});
			this.on("error", function(files, response) {
				location.reload();
			});
		}

	}
	var myDropzone = new Dropzone("form#changeCover", { url: '/changeCover'});
</script>