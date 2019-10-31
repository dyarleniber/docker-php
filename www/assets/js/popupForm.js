$(function(){
	$(document).on('click', '.addPostBtn', function(){
		$('.status').removeClass().addClass('status-removed');
		$('.hash-box').removeClass().addClass('hash-removed');
		$('#count').attr('id', 'count-removed');

		$.post('http://localhost/popularnetwork/core/ajax/postForm.php', function(data){
			$('.popupPost').html(data);
			$('.closePostPopup').click(function(){
				$('.popup-post-wrap').hide();
				$('.status-removed').removeClass().addClass('status');
				$('.hash-removed').removeClass().addClass('hash-box');
				$('#count-removed').attr('id', 'count');
			});
		});
	});
 	$(document).on('submit','#popupForm', function(e){
		e.preventDefault();
		var formData = new FormData($(this)[0]);
		formData.append('file', $('#file')[0].files[0]);
		$.ajax({
			url: "http://localhost/popularnetwork/core/ajax/addPost.php",
			type: "POST",
			data: formData,
			success: function(data){
				result = JSON.parse(data);
				if(result['error']){
					$('<div class="error-banner"><div class="error-banner-inner"><p id="errorMsg">'+result.error+'</p></div></div>').insertBefore('.header-wrapper');
					$('.error-banner').hide().slideDown(300).delay(5000).slideUp(300);
					$('.popup-post-wrap').hide();
				}else if (result['success']){
					$('<div class="error-banner"><div class="error-banner-inner"><p id="errorMsg">'+result.success+'</p></div></div>').insertBefore('.header-wrapper');
					$('.error-banner').hide().slideDown(300).delay(5000).slideUp(300);
					$('.popup-post-wrap').hide();
				}
			},
			cache: false,
			contentType: false,
			processData: false
		});
	});
});
