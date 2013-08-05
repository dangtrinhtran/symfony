jQuery(document).ready(function($) {
	$('#post_file').uniform();
	
	/**
	 * Submit blog with ajax
	 * @type type
	 */
	var iIdBlog = parseInt($("input[name='iIdBlog']").val());
	$(".form-blog").submit(function(e) {
		var aBlogEdit = new Array();
		var description = $("#blog_description").val();
		var sContent = '{';
		sContent += '"title":"' + $("#blog_title").val() + '"';
		sContent += ', "description":"' + description.replace(/\n/g,"\\n") + '"';
		sContent += '}';
		aBlogEdit[0] = $.parseJSON(sContent);
		$.ajax({
			type: 'PUT',
			url: Routing.generate('Likipe_DataAPI_Blog_put', {iIdBlog: iIdBlog}),
			contentType: 'application/json',
			data: JSON.stringify(aBlogEdit),
			success: function(data) {

			}
		});
		e.preventDefault();
	});
	
});
