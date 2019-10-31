$(function(){
	$(document).on('click', '.t-show-popup', function(){
		var post_id = $(this).data('post');
		var user_id  = $(this).data('user');

		$.post('http://localhost/popularnetwork/core/ajax/popupposts.php', {showpopup:post_id,user_id:user_id}, function(data){
			$('.popupPost').html(data);
			$('.post-show-popup-box-cut').click(function(){
				$('.post-show-popup-wrap').hide();
			});
		});
	});
	$(document).on('click','.imagePopup', function(e){
		e.stopPropagation();
		var post_id = $(this).data('post');
		var user_id  = $(this).data('user');

		$.post('http://localhost/popularnetwork/core/ajax/imagePopup.php', {showImage:post_id,user_id:user_id}, function(data){
			$('.popupPost').html(data);
			$('.close-imagePopup').click(function(){
				$('.img-popup').hide();
			});

		});
	});
});