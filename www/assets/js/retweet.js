$(function(){
	$(document).on('click','.repost', function(){
		var post_id    = $(this).data('post');
		var user_id     = $(this).data('user');
	    $counter        = $(this).find(".repostCount");
	    $count          = $counter.text();
	    $button         = $(this);


		$.post('http://localhost/popularnetwork/core/ajax/repost.php', {showPopup:post_id,user_id:user_id}, function(data){
			$('.popupPost').html(data);
			$('.close-repost-popup').click(function(){
				$('.repost-popup').hide();
			})
		});
	});

	$(document).on('click', '.repost-it', function(){
		var post_id   = $(this).data('post');
		var user_id    = $(this).data('user');
	    var comment    = $('.repostMsg').val();


	    $.post('http://localhost/popularnetwork/core/ajax/repost.php', {repost:post_id,user_id:user_id,comment:comment}, function(){
	    	$('.repost-popup').hide();
	    	$count++;
	    	$counter.text($count);
	    	$button.removeClass('repost').addClass('reposted');
	    });

	});
});