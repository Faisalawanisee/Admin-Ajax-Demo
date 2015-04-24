jQuery(document).ready(function($){
	$('#aad-ajax').submit(function() {
		$('#spinner').show();
		$('#add-submit').attr('disabled', true);
		var data = {
			action: 'aad_get_results',
			aad_nonce: aad_vars.aad_nonce
		};

		$.post(ajaxurl, data, function(responce) {
			$('#aad_responce').html(responce);
			$('#spinner').hide();
			$('#add-submit').attr('disabled', false);
		});

		return false;
	});
});
