(function($){
	$.AjaxLeftTabs = function(baseURL, startTab){
		var url   = location.href;
		var parts = url.split('#');

		if (parts[1] != null) {
			$('#'+ parts[1]).parent().addClass('active');
			$('#ajaxContent').html('<i class="fa fa-spinner fa-spin"></i>');
			$('#ajaxContent').load(baseURL + parts[1]);
		} else {
			$('#' + startTab).parent().addClass('active');
			$('#ajaxContent').html('<i class="fa fa-spinner fa-spin"></i>');
			$('#ajaxContent').load(baseURL + startTab);
		}
		$('.ajaxLink').click(function() {

			$('.ajaxLink').parent().removeClass('active');
			$(this).parent().addClass('active');

			var link = $(this).attr('id');
			$('#ajaxContent').html('<i class="fa fa-spinner fa-spin"></i>');
			$('#ajaxContent').load(baseURL + link);
		});
	}
})(jQuery);

(function($){
	$.fn.AjaxSubmit = function(options, responseDataCallBack){
		$(this).submit(function(event) {

			// Setup our default and override options.
			var opts = $.extend( {}, $.fn.AjaxSubmit.defaults, options );

			event.preventDefault();

			var formId = $(this).attr('id');

			$('#' + formId + ' .error').removeClass('error');
			$('#' + formId + ' #message').html('<i class="fa fa-spinner fa-spin"></i>');

			$.post(opts.path, $(this).serialize(), function(response) {
				if (response.status == 'success') {
					$('#' + formId + ' #message').html(opts.successMessage);

					if ( $.isFunction( responseDataCallBack ) && !jQuery.isEmptyObject(response.data)) {
						responseDataCallBack.call(this, response.data );
					}
				}

				if (response.status == 'error') {
					$('#' + formId + ' #message').empty();
					$.each(response.errors, function (key, value) {
						$('#' + formId + ' #' + key).addClass('error');
						$('#' + formId + ' #message').append('<span class="text-error">'+ value +'</span><br />');
					});
				}
			})
			.fail(function (){
				$('#' + formId + ' #message').html('<span class="text-error">' + opts.failMessage + '</span>');
			});
		});
	}

	// Ajax submit default options.
	$.fn.AjaxSubmit.defaults = {
		path: "/",
		successMessage: "The update was successful.",
		failMessage: "An error occurred, please try again."
	};
})(jQuery);