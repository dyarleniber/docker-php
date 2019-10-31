$(function(){
	$(document).on('click', '.deletePost', function(){
		var post_id = $(this).data('post');

		$.post('http://localhost/popularnetwork/core/ajax/deletePosts.php', {showpopup:post_id}, function(data){
			$('.popupPost').html(data);
			$('.close-repost-popup,.cancel-it').click(function(){
				$('.repost-popup').hide();
			});
		});
	});

	$(document).on('click','.delete-it', function(){
		var post_id = $(this).data('post');

		$.post('http://localhost/popularnetwork/core/ajax/deletePosts.php', {deletePost:post_id}, function(){
			$('.repost-popup').hide();
			window.location = window.location.href;
		});
	});

	$(document).on('click', '.deleteComment', function(){
		var post_id    = $(this).data('post');
		var commentID   = $(this).data('comment');

		$.post('http://localhost/popularnetwork/core/ajax/deleteComment.php', {deleteComment:commentID,post_id:post_id});
		$.post('http://localhost/popularnetwork/core/ajax/popupposts.php', {showpopup:post_id}, function(data){
			$('.popupPost').html(data);
			$('.post-show-popup-box-cut').click(function(){
				$('.post-show-popup-wrap').hide();
			});
		});
	});
});