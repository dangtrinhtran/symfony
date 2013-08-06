jQuery(document).ready(function($) {
	$('#post_file').uniform();
	
	/**
	 * Submit blog with ajax
	 * @author Rony
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
	
	/**
	 * Delete post with ajax
	 * @author Rony
	 */
	function removeFlash() {
		var $flash = $('div.alert-ajax');
		if ($flash.length > 0) {
			setTimeout(function() {
				$flash.fadeOut(500);
			}, 3000);
		}
	}
	var iIdPost = parseInt($("input[name='iIdPost']").val());
	removeFlash();
	$(".delete-post-ajax").on('click', function(e) {
		var sHtml = '';
		$.ajax({
			type: 'DELETE',
			url: Routing.generate('Likipe_DataAPI_Post_delete', {iIdPost: iIdPost}),
			contentType: 'application/json',
			success: function(data) {
				sHtml += '<div class="alert alert-success alert-ajax">';
				sHtml += '<button title="Close" class="close" data-dismiss="alert" type="button">×</button>'; 
				sHtml += data.success;
				sHtml += '</div>';
				$(".info-ajax").html(sHtml);
				removeFlash();
			}
		});
		e.preventDefault();
	});
	
});
