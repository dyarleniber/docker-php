<?php
class Post extends User{
	protected $message;

 	public function __construct($pdo){
		$this->pdo = $pdo;
		// added new code for PHP 7
		$this->message  = new Message($this->pdo);
	}
 
	public function posts($user_ID, $num){
	    $stmt = $this->pdo->prepare("SELECT * FROM `posts` LEFT JOIN `users` ON `postBy` = `user_id` WHERE `postBy` = :user_ID AND `repostID` = '0' OR `postBy` = `user_id` AND `repostBy` != :user_ID AND `postBy` IN (SELECT `receiver` FROM `follow` WHERE `sender` =:user_ID) ORDER BY `postID` DESC LIMIT :num");
	    $stmt->bindParam(":user_ID", $user_ID, PDO::PARAM_INT);
	    $stmt->bindParam(":num", $num, PDO::PARAM_INT);
	    $stmt->execute();
	    $posts = $stmt->fetchAll(PDO::FETCH_OBJ);

	    foreach ($posts as $post) {
	      $likes = $this->likes($user_ID, $post->postID);
	      $repost = $this->checkRetweet($post->postID, $user_ID);
	      $user = $this->userData($post->repostBy);
	     
	      echo '<div class="all-post">
			      <div class="t-show-wrap">
			       <div class="t-show-inner">
			       '.(($repost['repostID'] === $post->repostID OR $post->repostID > 0) ? '
			      	<div class="t-show-banner">
			      		<div class="t-show-banner-inner">
			      			<span><i class="fa fa-retweet" aria-hidden="true"></i></span><span>'.$user->screenName.' Retweeted</span>
			      		</div>
			      	</div>'
			        : '').'

			        '.((!empty($post->repostMsg) && $post->postID === $repost['postID'] or $post->repostID > 0) ? '<div class="t-show-head">
			        <div class="t-show-popup" data-tweet="'.$post->postID.'">
			          <div class="t-show-img">
			        		<img src="'.BASE_URL.$user->profileImage.'"/>
			        	</div>
			        	<div class="t-s-head-content">
			        		<div class="t-h-c-name">
			        			<span><a href="'.BASE_URL.$user->username.'">'.$user->screenName.'</a></span>
			        			<span>@'.$user->username.'</span>
			        			<span>'.$this->timeAgo($repost['postedOn']).'</span>
			        		</div>
			        		<div class="t-h-c-dis">
			        			'.$this->getPostLinks($post->repostMsg).'
			        		</div>
			        	</div>
			        </div>
			        <div class="t-s-b-inner">
			        	<div class="t-s-b-inner-in">
			        		<div class="retweet-t-s-b-inner">
			            '.((!empty($post->postImage)) ? '
			        			<div class="retweet-t-s-b-inner-left">
			        				<img src="'.BASE_URL.$post->postImage.'" class="imagePopup" data-tweet="'.$post->postID.'"/>
			        			</div>' : '').'
			        			<div>
			        				<div class="t-h-c-name">
			        					<span><a href="'.BASE_URL.$post->username.'">'.$post->screenName.'</a></span>
			        					<span>@'.$post->username.'</span>
			        					<span>'.$this->timeAgo($post->postedOn).'</span>
			        				</div>
			        				<div class="retweet-t-s-b-inner-right-text">
			        					'.$this->getPostLinks($post->status).'
			        				</div>
			        			</div>
			        		</div>
			        	</div>
			        </div>
			        </div>' : '

			      	<div class="t-show-popup" data-tweet="'.$post->postID.'">
			      		<div class="t-show-head">
			      			<div class="t-show-img">
			      				<img src="'.$post->profileImage.'"/>
			      			</div>
			      			<div class="t-s-head-content">
			      				<div class="t-h-c-name">
			      					<span><a href="'.$post->username.'">'.$post->screenName.'</a></span>
			      					<span>@'.$post->username.'</span>
			      					<span>'.$this->timeAgo($post->postedOn).'</span>
			      				</div>
			      				<div class="t-h-c-dis">
			      					'.$this->getPostLinks($post->status).'
			      				</div>
			      			</div>
			      		</div>'.
			          ((!empty($post->postImage)) ?
			      		 '<!--tweet show head end-->
			            		<div class="t-show-body">
			            		  <div class="t-s-b-inner">
			            		   <div class="t-s-b-inner-in">
			            		     <img src="'.$post->postImage.'" class="imagePopup" data-tweet="'.$post->postID.'"/>
			            		   </div>
			            		  </div>
			            		</div>
			            		<!--tweet show body end-->
			          ' : '').'

			      	</div>').'
			      	<div class="t-show-footer">
			      		<div class="t-s-f-right">
			      			<ul>
			      				<li><button><i class="fa fa-share" aria-hidden="true"></i></button></li>
			      				<li>'.(($post->postID === $repost['repostID']) ? 
			      					'<button class="retweeted" data-tweet="'.$post->postID.'" data-user="'.$post->postBy.'"><i class="fa fa-retweet" aria-hidden="true"></i><span class="retweetsCount">'.(($post->repostCount > 0) ? $post->repostCount : '').'</span></button>' : 
			      					'<button class="retweet" data-tweet="'.$post->postID.'" data-user="'.$post->postBy.'"><i class="fa fa-retweet" aria-hidden="true"></i><span class="retweetsCount">'.(($post->repostCount > 0) ? $post->repostCount : '').'</span></button>').'
			      				</li>
			      				<li>'.(($likes['likeOn'] === $post->postID) ? 
			      					'<button class="unlike-btn" data-tweet="'.$post->postID.'" data-user="'.$post->postBy.'"><i class="fa fa-heart" aria-hidden="true"></i><span class="likesCounter">'.(($post->likesCount > 0) ? $post->likesCount : '' ).'</span></button>' : 
			      					'<button class="like-btn" data-tweet="'.$post->postID.'" data-user="'.$post->postBy.'"><i class="fa fa-heart-o" aria-hidden="true"></i><span class="likesCounter">'.(($post->likesCount > 0) ? $post->likesCount : '' ).'</span></button>').'
			      				</li>
			               
			                '.(($post->postBy === $user_ID) ? '
			              	    <li>
			      					<a href="#" class="more"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>
			      					<ul>
			      					  <li><label class="deleteTweet" data-tweet="'.$post->postID.'">Delete Tweet</label></li>
			      					</ul>
			      				</li>' : '').'

			      			</ul>
			      		</div>
			      	</div>
			      </div>
			      </div>
			      </div>';
	    }
	}
  
	public function getUserPosts($user_ID){
		$stmt = $this->pdo->prepare("SELECT * FROM `posts` LEFT JOIN `users` ON `postBy` = `user_ID` WHERE `postBy` = :user_ID AND `repostID` = '0' OR `repostBy` = :user_ID ORDER BY `postID` DESC");
		$stmt->bindParam(":user_ID", $user_ID, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_OBJ);
	}

	public function addLike($user_ID, $post_id, $get_id){
		$stmt = $this->pdo->prepare("UPDATE `posts` SET `likesCount` = `likesCount`+1 WHERE `postID` = :post_id");
		$stmt->bindParam(":post_id", $post_id, PDO::PARAM_INT);
		$stmt->execute();

		$this->create('likes', array('likeBy' => $user_ID, 'likeOn' => $post_id));
	
		if($get_id != $user_ID){
			//this fixed php 7 error for non static methods
			$this->message->sendNotification($get_id, $user_ID, $post_id, 'like');
		}
	}

	public function unLike($user_ID, $post_id, $get_id){
		$stmt = $this->pdo->prepare("UPDATE `posts` SET `likesCount` = `likesCount`-1 WHERE `postID` = :post_id");
		$stmt->bindParam(":post_id", $post_id, PDO::PARAM_INT);
		$stmt->execute();

		$stmt = $this->pdo->prepare("DELETE FROM `likes` WHERE `likeBy` = :user_ID and `likeOn` = :post_id");
		$stmt->bindParam(":user_ID", $user_ID, PDO::PARAM_INT);
		$stmt->bindParam(":post_id", $post_id, PDO::PARAM_INT);
		$stmt->execute(); 
	}

	public function likes($user_ID, $post_id){
		$stmt = $this->pdo->prepare("SELECT * FROM `likes` WHERE `likeBy` = :user_ID AND `likeOn` = :post_id");
		$stmt->bindParam(":user_ID", $user_ID, PDO::PARAM_INT);
		$stmt->bindParam(":post_id", $post_id, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}
	
	public function getTrendByHash($hashtag){
		$stmt = $this->pdo->prepare("SELECT * FROM `trends` WHERE `hashtag` LIKE :hashtag LIMIT 5");
		$stmt->bindValue(":hashtag", $hashtag.'%');
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_OBJ);
	}

	public function getMension($mension){
		$stmt = $this->pdo->prepare("SELECT `user_ID`,`username`,`screenName`,`profileImage` FROM `users` WHERE `username` LIKE :mension OR `screenName` LIKE :mension LIMIT 5");
		$stmt->bindValue("mension", $mension.'%');
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_OBJ);

	}

	public function addTrend($hashtag){
		preg_match_all("/#+([a-zA-Z0-9_]+)/i", $hashtag, $matches);
		if($matches){
			$result = array_values($matches[1]);
		}
		$sql = "INSERT INTO `trends` (`hashtag`, `createdOn`) VALUES (:hashtag, CURRENT_TIMESTAMP)";
		foreach ($result as $trend) {
			if($stmt = $this->pdo->prepare($sql)){
				$stmt->execute(array(':hashtag' => $trend));
			}
		}
	}

	public function addMention($status,$user_ID, $post_id){
		if(preg_match_all("/@+([a-zA-Z0-9_]+)/i", $status, $matches)){
			if($matches){
				$result = array_values($matches[1]);
			}
			$sql = "SELECT * FROM `users` WHERE `username` = :mention";
			foreach ($result as $trend) {
				if($stmt = $this->pdo->prepare($sql)){
					$stmt->execute(array(':mention' => $trend));
					$data = $stmt->fetch(PDO::FETCH_OBJ);
				}
			}

			if($data->user_ID != $user_ID){
				//This fixed PHP 7 error for non static methods
				$this->message->sendNotification($data->user_ID, $user_ID, $post_id, 'mention');
			}
		}
	}

	public function getPostLinks($post){
		$post = preg_replace("/(https?:\/\/)([\w]+.)([\w\.]+)/", "<a href='$0' target='_blink'>$0</a>", $post);
		$post = preg_replace("/#([\w]+)/", "<a href='http://localhost/popularnetwork/hashtag/$1'>$0</a>", $post);		
		$post = preg_replace("/@([\w]+)/", "<a href='http://localhost/popularnetwork/$1'>$0</a>", $post);
		return $post;		
	}

	public function getPopupPost($post_id){
		$stmt = $this->pdo->prepare("SELECT * FROM `posts`,`users` WHERE `postID` = :post_id AND `postBy` = `user_ID`");
		$stmt->bindParam(":post_id", $post_id, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_OBJ);
	}

	public function retweet($post_id, $user_ID, $get_id, $comment){
		$stmt = $this->pdo->prepare("UPDATE `posts` SET `repostCount` = `repostCount`+1 WHERE `postID` = :post_id AND `postBy` = :get_id");
		$stmt->bindParam(":post_id", $post_id, PDO::PARAM_INT);
		$stmt->bindParam(":get_id", $get_id, PDO::PARAM_INT);
		$stmt->execute();

		$stmt = $this->pdo->prepare("INSERT INTO `posts` (`status`,`postBy`,`repostID`,`repostBy`,`postImage`,`postedOn`,`likesCount`,`repostCount`,`repostMsg`) SELECT `status`,`postBy`,`postID`,:user_ID,`postImage`,`postedOn`,`likesCount`,`repostCount`,:repostMsg FROM `posts` WHERE `postID` = :post_id");
		$stmt->bindParam(":user_ID", $user_ID, PDO::PARAM_INT);
		$stmt->bindParam(":repostMsg", $comment, PDO::PARAM_STR);
		$stmt->bindParam(":post_id", $post_id, PDO::PARAM_INT);
		$stmt->execute();

		//This fixed PHP 7 error for non static methods
		$this->message->sendNotification($get_id, $user_ID, $post_id, 'retweet');

 	}

	public function checkRetweet($post_id, $user_ID){
		$stmt = $this->pdo->prepare("SELECT * FROM `posts` WHERE `repostID` = :post_id AND `repostBy` = :user_ID or `postID` = :post_id and `repostBy` = :user_ID");
		$stmt->bindParam(":post_id", $post_id, PDO::PARAM_INT);
		$stmt->bindParam(":user_ID", $user_ID, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}

	public function postPopup($post_id){
		$stmt = $this->pdo->prepare("SELECT * FROM `posts`,`users` WHERE `postID` = :post_id and `user_ID` = `postBy`");
		$stmt->bindParam(":post_id", $post_id, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_OBJ);
	}

	public function comments($post_id){
		$stmt = $this->pdo->prepare("SELECT * FROM `comments` LEFT JOIN `users` ON `commentBy` = `user_ID` WHERE `commentOn` = :post_id");
		$stmt->bindParam(":post_id", $post_id, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_OBJ);
	}

	public function countPosts($user_ID){
		$stmt = $this->pdo->prepare("SELECT COUNT(`postID`) AS `totalPosts` FROM `posts` WHERE `postBy` = :user_ID AND `repostID` = '0' OR `repostBy` = :user_ID");
		$stmt->bindParam(":user_ID", $user_ID, PDO::PARAM_INT);
		$stmt->execute();
		$count = $stmt->fetch(PDO::FETCH_OBJ);
		echo $count->totalPosts;
	}

	public function countLikes($user_ID){
		$stmt = $this->pdo->prepare("SELECT COUNT(`likeID`) AS `totalLikes` FROM `likes` WHERE `likeBy` = :user_ID");
		$stmt->bindParam(":user_ID", $user_ID, PDO::PARAM_INT);
		$stmt->execute();
		$count = $stmt->fetch(PDO::FETCH_OBJ);
		echo $count->totalLikes;
	} 

	public function trends(){
		$stmt = $this->pdo->prepare("SELECT *, COUNT(`postID`) AS `postsCount` FROM `trends` INNER JOIN `posts` ON `status` LIKE CONCAT('%#',`hashtag`,'%') OR `repostMsg` LIKE CONCAT('%#',`hashtag`,'%') GROUP BY `hashtag` ORDER BY `postID` LIMIT 10");
		$stmt->execute();	
		$trends = $stmt->fetchAll(PDO::FETCH_OBJ);
		echo '<div class="trend-wrapper"><div class="trend-inner"><div class="trend-title"><h3>Trends</h3></div><!-- trend title end-->';
		foreach ($trends as $trend) {
			echo '<div class="trend-body">
					<div class="trend-body-content">
						<div class="trend-link">
							<a href="'.BASE_URL.'hashtag/'.$trend->hashtag.'">#'.$trend->hashtag.'</a>
						</div>
						<div class="trend-posts">
							'.$trend->postsCount.' <span>posts</span>
						</div>
					</div>
				</div>';
		}
		echo '</div></div>';		
	} 

	public function getPostsByHash($hashtag){
		$stmt = $this->pdo->prepare("SELECT * FROM `posts` LEFT JOIN `users` ON `postBy` = `user_ID` WHERE `status` LIKE :hashtag OR `repostMsg` LIKE :hashtag");
		$stmt->bindValue(":hashtag", '%#'.$hashtag.'%', PDO::PARAM_STR);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_OBJ);
	}

	public function getUsersByHash($hashtag){
		$stmt = $this->pdo->prepare("SELECT DISTINCT * FROM `posts` INNER JOIN `users` ON `postBy` = `user_ID` WHERE `status` LIKE :hashtag OR `repostMsg` LIKE :hashtag GROUP BY `user_ID`");
		$stmt->bindValue(":hashtag", '%#'.$hashtag.'%', PDO::PARAM_STR);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_OBJ);
	}
}
?>	