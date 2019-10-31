$(function(){
	$(document).on('click', '#messagePopup', function(){
		var getMessages = 1;
		$.post('http://localhost/popularnetworks/core/ajax/messages.php', {showMessage:getMessages}, function(data){
			$('.popupPost').html(data);
			$('#messages').hide();
  		});
	});

	$(document).on('click', '.people-message', function(){
		var get_id = $(this).data('user');
		$.post('http://localhost/popularnetwork/core/ajax/messages.php', {showChatPopup:get_id}, function(data){
			$('.popupPost').html(data);
			if(autoscroll){
				scrollDown();
			}
			$('#chat').on('scroll', function(){
				if($(this).scrollTop() < this.scrollHeight - $(this).height()){
					autoscroll = false;
				}else{
					autoscroll = true;
				}
			});
		$('.close-msgPopup').click(function(){
			 clearInterval(timer);
		});
		});

		getMessages = function(){
			$.post('http://localhost/popularnetwork/core/ajax/messages.php', {showChatMessage:get_id}, function(data){
				$('.main-msg-inner').html(data);
				if(autoscroll){
					scrollDown();
				}
				$('#chat').on('scroll', function(){
					if($(this).scrollTop() < this.scrollHeight - $(this).height()){
						autoscroll = false;
					}else{
						autoscroll = true;
					}
				});
				$('.close-msgPopup').click(function(){
				   clearInterval(timer);
				});
			});
		}
		var timer = setInterval(getMessages, 5000);
		getMessages();

		autoscroll = true;
		scrollDown = function(){
			var chat  = $('#chat')[0];
 			if(chat !== undefined){
				$('#chat').scrollTop(chat.scrollHeight);
			}
		}

		$(document).on('click', '.back-messages', function(){
			var getMessages = 1;
			$.post('http://localhost/popularnetwork/core/ajax/messages.php', {showMessage:getMessages}, function(data){
				$('.popupPost').html(data);
				clearInterval(timer);
			});	
		});

		$(document).on('click', '.deleteMsg', function(){
			var messageID  = $(this).data('message');
			$('.message-del-inner').height('100px');

			$(document).on('click', '.cancel', function(){
				$('.message-del-inner').height('0px');
			});

			$(document).on('click', '.delete', function(){
				$.post('http://localhost/popularnetwork/core/ajax/messages.php', {deleteMsg:messageID}, function(data){
					$('.message-del-inner').height('0px');
					getMessages();
				})
			});

		});

	});
})
