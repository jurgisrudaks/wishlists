<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	<h4 class="modal-title" id="changeWishImageModal">Mainīt vēlmjes attēlu</h4>
</div>

<div class="modal-body">
	<div id="validation-errors" class="alert alert-danger" style="display: none"></div>
	<div id="success" class="alert alert-success" style="display: none"></div>
	{{ Form::open(array('id' => 'changeWishImage', 'class' => 'dropzone', 'method' => 'put','files' => true)) }}
	<input type="hidden" name="wishId" value="{{ $wishId }}">
	<input type="hidden" name="_method" value="PUT" />
</div>
<div class="modal-footer">
		<button type="button" data-dismiss="modal" class="btn btn-default">Atcelt</button>
		<button id="changeWishImageButton" type="submit" data-loading-text="Maina..." class="btn btn-primary">Mainīt</button>
	{{ Form::close() }}
</div>

<script type="text/javascript">
	Dropzone.options.changeWishImage = {

		paramName: 'wishImage',
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
			var btn = $('#changeWishImageButton')
			var errorDiv = "#validation-errors";
			var succDiv = "#success";

			document.querySelector("button[id=changeWishImageButton]").addEventListener("click", function(e) {
				e.preventDefault();
				e.stopPropagation();
				myDropzone.processQueue();
			});

			this.on("sending", function() {
				btn.button('loading')
			});
			this.on("success", function(files, response) {
				$('#editImgModal').modal('hide');
				$('#processingImage').modal('show');
				location.reload();
			});
			this.on("error", function(files, response) {
				btn.button('reset')
				$(errorDiv).append('<strong>'+ response +'</strong><br/>');
				$(errorDiv).show();
			});
		}

	}
	var myDropzone = new Dropzone("form#changeWishImage", { url: "{{ URL::route('wishes.update', $wishId) }}"});
</script>