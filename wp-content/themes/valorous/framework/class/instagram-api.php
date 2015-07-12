<?php

if ( ! class_exists( 'KT_Instagram' ) ) {
        
    class KT_Instagram{
        /*
         * Attributes
         */
        private $username, //Instagram username
                $access_token, //Your access token
                $userid; //Instagram userid
                
        /*
         * Constructor
         */
        function __construct(  ) {
            
            $this->access_token = get_option('kt_instagram_access');
            $this->username = get_option('kt_instagram_username');
            $this->userid = intval(get_option('kt_instagram_userid'));
            
        }
        
        /*
         * The api works mostly with user ids, but it's easier for users to use their username.
         * This function gets the userid corresponding to the username
         */
        public function getUserIDFromUserName(){
            if(strlen($this->username)>0 && strlen($this->access_token)>0){
                $useridquery = $this->queryInstagram('https://api.instagram.com/v1/users/search?q='.$this->username.'&access_token='.$this->access_token);
                if(!empty($useridquery) && $useridquery->meta->code=='200' && $useridquery->data[0]->id>0){
                    //Found
                    $this->userid = $useridquery->data[0]->id;
                    update_option('kt_instagram_userid', $this->userid);
                    
                } else {
                    //Not found
                    return 0;
                }
            } else {
                //empty username or access token
                return -1;
            }
        }
        /*
         * Get the most recent media published by a user.
         * you can use the $args array to pass the attributes that are used by the GET/users/user-id/media/recent method
         */
        public function getUserMedia($args=array()){
            
            //If no user id, get user id
            $this->getUserIDFromUserName();
                
            if( $this->userid > 0 && strlen($this->access_token) > 0 ){
                $qs='';
                if(!empty($args)){ $qs = '&'.http_build_query($args); } //Adds query string if any args are specified
                
                $query = $this->queryInstagram('https://api.instagram.com/v1/users/'.(int)$this->userid.'/media/recent?access_token='.$this->access_token.$qs );
                
                if($query->meta->code == '200'){
                    return $query->data;
                }else{
                    return false;
                }
                
            } else {
                //empty username or access token
                return false;
            }
        }
        
        /*
         * Common mechanism to query the instagram api
         */
        public function queryInstagram($url){
            //Execute and return query
            $query = json_decode(file_get_contents($url));
            return $query;
        }
        
        
        public function showInstagram($images, $column = 3){
            $output = '';
            
            $output .= '<ul class="instagram-'.$column.' clearfix">';
			foreach($images as $image){
				$output .= sprintf(
					'<li><a href="%1$s" target="_blank"><img src="%2$s" alt="%3$s" title="%3$s"></a></li>',
					esc_attr($image->link),
					esc_attr($image->images->thumbnail->url),
					esc_attr($image->caption->text)
				);
			}
            $output .= '</ul>';
            
            return $output;
        }
    }
}
