(function($){
	$.Crud = function(options, responseDataCallBack){
		// Setup our default and override options.
		opts     = $.extend( {}, $.Crud.defaults, options );
		data     = opts.data;
		resource = data.resource;
		settings = opts.settings;

		if (opts.type == 'normal') {
			resourceId = (resource.hasOwnProperty('id') ? resource.id : resource.uniqueId);
		} else {
			resourceId = (data.main.hasOwnProperty('id') ? data.main.id : data.main.uniqueId);
		}

		if ( $.isFunction( responseDataCallBack )) {
			$.setUpNewRow();
			var results = {newColumns: newColumns, newRow: newRow, resourceId: resourceId};
			responseDataCallBack.call(this, results );
		}
	}

	// Crud default options.
	$.Crud.defaults = {
		type: 'normal',
		data: '',
		settings: '',
		rootPath: '',
	};

	$.setUpEditLink = function() {
		editLink = '<a href="javascript:void();" class="btn btn-xs btn-primary" onClick="editDetails(\''+ resourceId +'\');">Edit</a>';
	}

	$.setUpDeleteLink = function() {
		if (settings.deleteFlag == true) {
			deleteLink = '<a href="'+ rootPath + settings.deleteLink + resource[settings.deleteProperty] +'" class="confirm-remove btn btn-xs btn-danger">Delete</a>';
		} else {
			deleteLink = '';
		}
	}

	$.setUpDataTags = function() {
		dataTags = '';
		$.each(settings.formFields, function(key, details) {
			dataTags += 'data-'+ key.toLowerCase() +'="'+ resource[key] +'" ';
		});
	}

	$.setUpInput = function() {
		// Set up the data flags for the hidden input
		$.setUpDataTags();

		// Add the hidden input
		inputColumn = '<td style="display: none;"><input type="hidden" id="'+ resourceId +'" '+ dataTags +' /></td>';

		$.each(settings.displayFields, function(key, details) {

			// Handle links
			if (details.linkLocation != null) {
				if (details.linkLocation == 'mailto') {
					dataColumns += '<td><a href="mailto:'+ resource.email +'">'+ resource.email +'</a></td>';
				} else {
					var link = details.linkLocation;
						link += (typeof details.linkProperty != 'undefined' ? resource[details.linkProperty] : '');
					dataColumns += '<td><a href="'+ link +'">'+ ucwords(resource[key]) +'</a></td>';
				}

			} else {
				dataColumns += '<td>'+ ucwords(resource[key]) +'</td>';
			}
		});
	}

	$.setUpInputMulti = function() {
		inputColumn = '<td style="display: none;"><input type="hidden" id="'+ resourceId +'" data-multi=\''+ $.trim(data.main.multi) +'\' /></td>';

		dataColumns += '<td>'+ data.main[settings.multiViewDetails.name] +'</td>'+
			'<td>';

		$.each(resource, function() {
			dataColumns += this[settings.multiViewPropertyDetails.name] +'<br />';
		});

		dataColumns += '</td>';
	}

	$.setUpDataColumns = function() {
		// Add the data columns
		dataColumns = '';
		if (opts.type == 'normal') {
			// This handles the data tags, input and data columns
			$.setUpInput();
		} else {
			// This handles the data tags, input and data columns for multi view
			$.setUpInputMulti();
		}

		// Setup the edit and delete links
		$.setUpEditLink();
		$.setUpDeleteLink();
	}

	$.setUpNewRow = function() {
		$.setUpNewColumns();
		// Create the whole row
		newRow =
			'<tr data-sort="'+ resource[settings.sortProperty] +'">' +
				newColumns +
			'</tr>';
	}

	$.setUpNewColumns = function() {
		$.setUpDataColumns();
		// Put all the new columns in order
		newColumns = inputColumn +
			dataColumns +
			'<td class="text-center">' +
				'<div class="btn-group">' +
					editLink +
					deleteLink +
				'</div>' +
			'</td>';
	}
})(jQuery);