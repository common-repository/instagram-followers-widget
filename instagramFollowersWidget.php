<?php
/**
 * @package red_instagramFollowersWidget
*/
/*
Plugin Name: Instagram Followers Widget
Plugin URI: http://crayfishseo.com
Description: Instagram Followers Widget for Wordpress.
Version: 1.0
Author: Charles Li
Author URI: http://crayfishseo.com
*/
class instagramFollowersWidget extends WP_Widget{
    public function __construct() {
        // Register style sheet.
		add_action( 'wp_enqueue_scripts', array( $this, 'register_plugin_styles' ) );
        $params = array(
            'description' => 'Instagram Followers Widget for Wordpress',
            'name' => 'Instagram Followers Widget'
        );
        parent::__construct('instagramFollowersWidget','',$params);
    }
    /**
    * Register and enqueue style sheet.
    */
    public function register_plugin_styles() {
        wp_register_style( 'instagramFollowersWidget', plugins_url( 'style.css' , __FILE__ ) );
        wp_enqueue_style( 'instagramFollowersWidget' );
    }
    public function form($instance) {
        extract($instance);
        ?>
<!--start configuration fields-->
<p>
    <label for="<?php echo $this->get_field_id('title');?>">Title : </label>
    <input
	class="widefat"
	id="<?php echo $this->get_field_id('title');?>"
	name="<?php echo $this->get_field_name('title');?>"
    value="<?php echo !empty($title) ? $title : "Instagram Followers Widget"; ?>" />
</p>
<p>
    <label for="<?php echo $this->get_field_id('instagramID');?>">Instagram User ID : </label>
    <input
	class="widefat"
	id="<?php echo $this->get_field_id('instagramID');?>"
	name="<?php echo $this->get_field_name('instagramID');?>"
    value="<?php echo !empty($instagramID) ? $instagramID : "25025320"; ?>" />
</p>
<p>
    <label for="<?php echo $this->get_field_id('accessToken');?>">Access Token : </label>
    <input
	class="widefat"
	id="<?php echo $this->get_field_id('accessToken');?>"
	name="<?php echo $this->get_field_name('accessToken');?>"
    value="<?php echo !empty($accessToken) ? $accessToken : "445731305.f59def8.b478a2249aca4adf955ee0ebbfa6b31a"; ?>" />
</p>
<p>
    <label for="<?php echo $this->get_field_id('limit');?>">No. of Followers : </label>
    <input
	class="widefat"
	id="<?php echo $this->get_field_id('limit');?>"
	name="<?php echo $this->get_field_name('limit');?>"
    value="<?php echo !empty($limit) ? $limit : "30"; ?>" />
</p>
<p>
    <label for="<?php echo $this->get_field_id('width');?>">Width : </label>
    <input
	class="widefat"
	id="<?php echo $this->get_field_id('width');?>"
	name="<?php echo $this->get_field_name('width');?>"
    value="<?php echo !empty($width) ? $width : "555"; ?>" />
</p>
<p>
<label for="<?php echo $this->get_field_id( 'supportAuthor' ); ?>">Support Author :</label> 
<select id="<?php echo $this->get_field_id( 'supportAuthor' ); ?>"
        name="<?php echo $this->get_field_name( 'supportAuthor' ); ?>"
        class="widefat" style="width:100%;">
	<option value="true" <?php if ($supportAuthor == 'true') echo 'selected="true"'; ?> > Yes</option>
	<option value="false" <?php if ($supportAuthor == 'false') echo 'selected="false"'; ?> >No</option>	
</select>
</p>
<p>
    <label for="<?php echo $this->get_field_id('moduleclass_sfx');?>">Widget Class Suffix : </label>
    <input
	class="widefat"
	id="<?php echo $this->get_field_id('moduleclass_sfx');?>"
	name="<?php echo $this->get_field_name('moduleclass_sfx');?>"
    value="<?php echo !empty($moduleclass_sfx) ? $moduleclass_sfx : " instagramFollowers"; ?>" />
</p>
<!--end of configuration fields-->
<!-- start displaying widget on website -->
<?php
    }
    public function widget($args, $instance) {
        extract($args);
        extract($instance);
        $title = apply_filters('widget_title', $title);
        $description = apply_filters('widget_description', $description);
        if(empty($title)) $title = "Instagram Followers Widget";
        if(empty($instagramID)) $instagramID = "25025320";
        if(empty($accessToken)) $accessToken = "445731305.f59def8.b478a2249aca4adf955ee0ebbfa6b31a";
		if(empty($limit)) $limit = "30";
        if(empty($width)) $width = "555";
        if(empty($supportAuthor)) $supportAuthor = "true";
        if(empty($moduleclass_sfx)) $moduleclass_sfx = " instagramFollowers";
        if( ini_get('allow_url_fopen') && function_exists('openssl_open') ) {
            $data = $this->instagramFollowers($instagramID, $accessToken, $limit, $supportAuthor);
        }else {
            $data = "Check your php.ini and make sure allow_url_fopen & openssl function is set to on.";
        }   
        echo $before_widget;
            echo $before_title . $title . $after_title;
            echo "
                <div class='red_instagramFollowersWidget$suffix'>
                    <div id='instagramFollowers' style='max-width: $width";
            echo"px;'>
                        $data
                    </div>";
            if ($supportAuthor == "true") :
                    echo "<div style='font-size: 9px; color: #808080; font-weight: normal; font-family: tahoma,verdana,arial,sans-serif; line-height: 1.28; text-align: right; direction: ltr;'><a href='http://www.empirepromos.com/' target='_blank' style='color: #808080;' title='click here'>Promotional Products</a></div>";
                endif;
                echo "</div>";
        echo $after_widget;
    }
    private function instagramFollowers($instagramID,$accessToken,$limit,$supportAuthor){
        if(empty($instagramID)) return false;
        $userInfo = $this->getUserInfo($instagramID, $accessToken);
        $userInfoData= $userInfo['data'];
        extract($userInfoData);
        $followedBy = $counts['followed_by'];
        $output = "";
        $output .= "
    		<div class='instagram-border'>
			<div id='followers'>
				<div class='followUs'>Follow us on Instagram</div>
				<div class='floatelement'>
					<div class='thumb-img'><a href='https://instagram.com/$username' target='_blank' title='$username'><img src='$profile_picture'/></a></div>
					<div class='right-text'><p class='title'><a href='https://instagram.com/$username' target='_blank' title='$username'>$full_name</a></p>
					<a href='https://instagram.com/$username' target='_blank' title='$username' class='followButton'>Follow</a></div>
					<div class='clr'></div>
				</div>
				<div class='imagelisting'>
					<p>$followedBy People following <span><a href='https://instagram.com/$username' target='_blank' title='$username'>$full_name</a></span></p>  		
    		";
        $followersInfo = $this->getFollowersInfo($instagramID, $accessToken);
        $followersInfoData= $followersInfo['data'];
        
        $output .= "
				<ul>";
				for($i=0;$i<$limit;$i++){
				$postUserName = $followersInfoData[$i]['username'];
				$postFullName = $followersInfoData[$i]['full_name'];
				$postProfilePicture = $followersInfoData[$i]['profile_picture'];
				$output .= "
					<li><a href='https://instagram.com/$postUserName' title='$postFullName' target='_blank'><img src='$postProfilePicture'></a></li>";
				}
				$output .= "<div class='clr'></div></ul></div>
			</div>
		</div>";
        return $output;
    }
	private function getUserInfo($instagramID,$accessToken){
		$instagramUserInfo = "https://api.instagram.com/v1/users/$instagramID/?access_token=$accessToken";
		$userInfo = json_decode(file_get_contents($instagramUserInfo),true);
		//if found any error than return false
		if(isset($userInfo->error)) return false;
		else return $userInfo;

	}
	private function getFollowersInfo($instagramID,$accessToken){
		$instagramFollowers = "https://api.instagram.com/v1/users/$instagramID/followed-by?access_token=$accessToken";
		$followersInfo = json_decode(file_get_contents($instagramFollowers),true);
		//if found any error than return false
		if(isset($followersInfo->error)) return false;
		else return $followersInfo;
	
	}
}
//end display widget
//registering the widget
add_action('widgets_init','register_red_instagramFollowersDisplay');
function register_red_instagramFollowersDisplay(){
    register_widget('instagramFollowersWidget');
}