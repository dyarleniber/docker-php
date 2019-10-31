<?php 
    include '../init.php';
    if(isset($_POST['deleteTweet']) && !empty($_POST['deleteTweet'])){
      $post_ID  = $_POST['deleteTweet'];
      $user_ID   = $_SESSION['user_id'];
      //get post data from post id
      $post     = $getFromT->tweetPopup($post_ID);
      //create link for post image to delete from
      $imageLink = '../../'.$post->postImage;
      //delete the post from database
      $getFromT->delete('posts', array('postID' => $post_ID, 'tweetBy' => $user_ID));
      //check if post has image
      if(!empty($post->postImage)){
        //delete the file
        unlink($imageLink);
      }
     }

    if(isset($_POST['showpopup']) && !empty($_POST['showpopup'])){
       $post_ID  = $_POST['showpopup'];
       $user_ID   = $_SESSION['user_id'];
       $post     = $getFromT->tweetPopup($post_ID);
    
?>
<div class="retweet-popup"> 
  <div class="wrap5">
    <div class="retweet-popup-body-wrap">
      <div class="retweet-popup-heading">
        <h3>Are you sure you want to delete this Tweet?</h3>
        <span><button class="close-retweet-popup"><i class="fa fa-times" aria-hidden="true"></i></button></span>
      </div>
       <div class="retweet-popup-inner-body">
        <div class="retweet-popup-inner-body-inner">
          <div class="retweet-popup-comment-wrap">
             <div class="retweet-popup-comment-head">
              <img src="<?php echo BASE_URL.$post->profileImage;?>"/>
             </div>
             <div class="retweet-popup-comment-right-wrap">
               <div class="retweet-popup-comment-headline">
                <a><?php echo $post->screenName;?> </a><span>‏@<?php echo $post->username . ' ' . $post->postedOn;?></span>
               </div>
               <div class="retweet-popup-comment-body">
                 <?php echo $post->status . ' ' .$post->postImage;?>
               </div>
             </div>
          </div>
         </div>
      </div>
      <div class="retweet-popup-footer"> 
        <div class="retweet-popup-footer-right">
          <button class="cancel-it f-btn">Cancel</button><button class="delete-it" data-post="<?php echo $post->postID;?>" type="submit">Delete</button>
        </div>
      </div>
    </div>
  </div>
</div>
<?php }?>
