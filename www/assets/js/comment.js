$(function(){
	$('#postComment').click(function(){
		var comment = $('#commentField').val();
		var post_id = $('#commentField').data('post');

		$.post('http://localhost/popularnetwork/core/ajax/comment.php', {comment:comment,post_id:post_id}, function(data){
			$('#comments').html(data);
			$('#commentField').val('');
		});
	});
});