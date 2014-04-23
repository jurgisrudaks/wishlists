function ajaxForm(formId, url, type, button, errorDiv) {
	if(!errorDiv) {
		errorDiv = "#validation-errors";
	}
	var btn = $('#loadingButton')
	$('form#' + formId).submit(function() {
		$.ajax({
			url: url,
			type: type,
			cache: false,
			dataType: 'json',
			data: $('form#' + formId).serialize(),
			headers: {
	            'X-CSRF-Token': $('input[name="_token"]').attr('value')
	        },
			beforeSend: function() {
				if(button) {
					btn.button('loading')
				} else {
					$('#processing').modal('show');
				}
				$(errorDiv).hide().empty();
				$("#success-message").remove();
			},
			success: function(data) {
				if(data.success == false)
				{
					var arr = data.errors;
					$.each(arr, function(index, value)
					{
						if (value.length != 0)
						{
							$(errorDiv).append('<strong>'+ value +'</strong><br/>');
						}
					});
					if(button) {
						btn.button('reset')
					} else {
						$('#processing').modal('hide');
					}
					$(errorDiv).show();
				} else {
					if(data.newUrl) {
						window.location.replace(data.newUrl);
					} else {
						location.reload();
					}
				}
			},
			error: function(xhr, textStatus, thrownError) {
				$(errorDiv).append('<strong>Kaut kas nogāja greizi, mēģini vēlreiz.</strong><br/>');
			}
		});
		return false;
	});
};