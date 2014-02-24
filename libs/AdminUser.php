<?php
#require_once "facebook-php-sdk-3.2.2/src/facebook.php";
require_once "db.class.php";

class Media {
        protected $db;
        function __construct(){
                $config = new config("localhost", "root", "qwerty", "medialib", NULL, "mysql");
                $this->db = new db($config);
        }
//testing
	public function test() {
	  echo "Media.php here!";
	}
//end of test



//Audios Section
	public function getAllAudio(){
	
		$top_query = sprintf("SELECT * FROM audio");
                error_log($top_query);
                $top_sql = $this->db->query($top_query);
                $ret_arr = array();
                while($rows = $this->db->fetchAssoc($top_sql)){
                        $_arr = array();
                        $_arr  = $rows;
                        $ret_arr[] = $_arr;
                }
                $this->db->closeConnection();
                return $ret_arr;
	
	}

        public function getAudioById($id){
                $query_str = $this->db->escape($id);
                $top_query = sprintf("SELECT * from audio where id = '%s'", $query_str);
                error_log($top_query);
                $top_sql = $this->db->query($top_query);
                $ret_arr = array();
                while($rows = $this->db->fetchAssoc($top_sql)){
                        $_arr = array();
                        $_arr = $rows;
                        $ret_arr[] = $_arr;
                }
                $this->db->closeConnection();
                return $ret_arr;
        }

	
	public function getAudioByArtist($artist){
		
                $query_str = $this->db->escape($artist);
                $top_query = sprintf("SELECT * from audio where artist = '%s'", $query_str);
                error_log($top_query);
                $top_sql = $this->db->query($top_query);
                $ret_arr = array();
                while($rows = $this->db->fetchAssoc($top_sql)){
                        $_arr = array();
                        $_arr = $rows;
                        $ret_arr[] = $_arr;
                }
                $this->db->closeConnection();
                return $ret_arr;
	
	}	

	
	public function getAudioByAlbum($album){
		
                $query_str = $this->db->escape($album);
                $top_query = sprintf("SELECT * from audio where album = '%s'", $query_str);
                error_log($top_query);
                $top_sql = $this->db->query($top_query);
                $ret_arr = array();
                while($rows = $this->db->fetchAssoc($top_sql)){
                        $_arr = array();
                        $_arr = $rows;
                        $ret_arr[] = $_arr;
                }
                $this->db->closeConnection();
                return $ret_arr;
	
	}

	
	public function getAudioByGenre($genre){
		
                $query_str = $this->db->escape($genre);
                $top_query = sprintf("SELECT * from videos where genre = '%s'", $query_str);
                error_log($top_query);
                $top_sql = $this->db->query($top_query);
                $ret_arr = array();
                while($rows = $this->db->fetchAssoc($top_sql)){
                        $_arr = array();
                        $_arr = $rows;
                        $ret_arr[] = $_arr;
                }
                $this->db->closeConnection();
                return $ret_arr;
	
	}	

	public function getAudioByName($name) {
		$query_str = $this->db->escape($name);
                $top_query = sprintf("SELECT * FROM audio WHERE title LIKE '%s'", $query_str);
                error_log($top_query);
                $top_sql = $this->db->query($top_query);
                $ret_arr = array();
                while($rows = $this->db->fetchAssoc($top_sql)){
                        $_arr = array();
                        $_arr  = $rows;
                        $ret_arr[] = $_arr;
                }
                $this->db->closeConnection();
                return $ret_arr;
	}

	public function getRelatedVideo($title, $artist){
		$query_title = $this->db->escape($title);
		$query_artist = $this->db->escape($artist);

		$query_string = "$query_title $query_artist";

		$query_set = explode(" ",$query_string);	
	
		foreach($query_set as $key){
			$key = "%$key%";
	                $top_query = sprintf("SELECT * FROM videos WHERE title LIKE '%s'", $key);
	                error_log($top_query);
	                $top_sql = $this->db->query($top_query);
        	        $ret_arr = array();
		
                	while($rows = $this->db->fetchAssoc($top_sql)){
                        	$_arr = array();
	                        $_arr  = $rows;
	                        $ret_arr[] = $_arr;
	                }
		}
                $this->db->closeConnection();
                return $ret_arr;
	}


	public function getRelatedPosters($title, $artist){
		$query_title = $this->db->escape($title);
		$query_artist = $this->db->escape($artist);

		$query_string = "$query_title $query_artist";

		$query_set = explode(" ",$query_string);	
	
		foreach($query_set as $key){
			$key = "%$key%";
	                $top_query = sprintf("SELECT * FROM posters WHERE title LIKE '%s'", $key);
	                error_log($top_query);
	                $top_sql = $this->db->query($top_query);
        	        $ret_arr = array();
		
                	while($rows = $this->db->fetchAssoc($top_sql)){
                        	$_arr = array();
	                        $_arr  = $rows;
	                        $ret_arr[] = $_arr;
	                }
		}
                $this->db->closeConnection();
                return $ret_arr;
	}

	public function addAudio($title, $path, $artist, $album, $lyrics, $album_art, $duration) {
		$query_title = $this->db->escape($title);
		$query_path = $this->db->escape($path);
		$query_artist = $this->db->escape($artist);
		$query_album = $this->db->escape($album);
		$query_lyrics = $this->db->escape($lyrics);
		$query_art = $this->db->escape($album_art);
		$query_dur = $this->db->escape($duration);
		$top_query = sprintf("select id from audio where title='%s' and path='%s'", $query_title, $query_path);
		error_log($top_query);
		$top_sql = $this->db->query($top_query);
		while ($rows = $this->db->fetchAssoc($top_sql)) {
			#already exists
			return false;
		}

		if($lyrics && $album_art){
	                $top_query = sprintf("insert into audio (title, path, album, artist, lyrics, album_art, duration) values ('%s', '%s', '%s', '%s', '%s', '%s', '%s')", $query_title, $query_path, $query_album, $query_artist, $query_lyrics, $query_art, $query_dur);
		}else{
	                $top_query = sprintf("insert into audio (title, path, album, artist, duration) values ('%s', '%s', '%s', '%s', '%s')", $query_title, $query_path, $query_album, $query_artist, $query_dur);
		}

                error_log($top_query);
                $top_sql = $this->db->query($top_query);
		#will return true or false
                return $top_sql;
	}

        public function linkAudioToPoster($title, $aud_id, $poster){                                 
 
		$query_title = $this->db->escape($title);
		$query_id = $this->db->escape($aud_id);
		$query_path = $this->db->escape($poster);
                                                                                                      
                $top_query = sprintf("SELECT id FROM posters where title='%s' and path='%s'",$query_title, $query_path);
                error_log($top_query);                                                                
                $top_sql = $this->db->query($top_query);                                              
                
                $ret_arr = array();                                                                   
                while($rows = $this->db->fetchAssoc($top_sql)){                                       
                        $_arr = array();
                        $_arr  = $rows;
                        $ret_arr[] = $_arr;                                                           
                }       
                
                $poster_id = $ret_arr[0]["id"];                                                       
                
                $top_query = sprintf("UPDATE audio SET album_art = '%s' where id = '%s'",$poster_id, $query_id); 
                error_log($top_query);
                $top_sql = $this->db->query($top_query);                                              
                
                $this->db->closeConnection();
                return $ret_arr;                                                                      
                
        }  

	public function addPosterToAudio($title, $aud_id, $poster){

		$query_title = $this->db->escape($title);
		$query_id = $this->db->escape($aud_id);
		$query_path = $this->db->escape($poster);

		$top_query = sprintf("SELECT id from posters where title='%s' and path='%s'", $query_title, $query_path);
		error_log($top_query);
		$top_sql = $this->db->query($top_query);

		while ($rows = $this->db->fetchAssoc($top_sql)) {
			#already exists
			return false;
		}

		$top_query = sprintf("INSERT INTO posters(title, path, type) values ('%s','%s', 'audio')",$query_title, $query_path);
                error_log($top_query);
                $top_sql = $this->db->query($top_query);

		$this->linkAudioToPoster($title, $aud_id, $poster);
	}


//Videos Section


	public function getAllVideo(){
	
		$top_query = sprintf("SELECT * FROM videos");
                error_log($top_query);
                $top_sql = $this->db->query($top_query);
                $ret_arr = array();
                while($rows = $this->db->fetchAssoc($top_sql)){
                        $_arr = array();
                        $_arr  = $rows;
                        $ret_arr[] = $_arr;
                }
                $this->db->closeConnection();
                return $ret_arr;
	
	}

        public function getVideoById($id){
                $query_str = $this->db->escape($id);
                $top_query = sprintf("SELECT * from videos where id = '%s'", $query_str);
                error_log($top_query);
                $top_sql = $this->db->query($top_query);
                $ret_arr = array();
                while($rows = $this->db->fetchAssoc($top_sql)){
                        $_arr = array();
                        $_arr = $rows;
                        $ret_arr[] = $_arr;
                }
                $this->db->closeConnection();
                return $ret_arr;
        }

	
	public function getVideoByDir($director){
		
                $query_str = $this->db->escape($director);
                $top_query = sprintf("SELECT * from videos where director = '%s'", $query_str);
                error_log($top_query);
                $top_sql = $this->db->query($top_query);
                $ret_arr = array();
                while($rows = $this->db->fetchAssoc($top_sql)){
                        $_arr = array();
                        $_arr = $rows;
                        $ret_arr[] = $_arr;
                }
                $this->db->closeConnection();
                return $ret_arr;
	
	}	

	public function getVideoByName($name) {
		$query_str = $this->db->escape($name);
                $top_query = sprintf("SELECT * FROM videos WHERE title LIKE '%s'", $query_str);
                error_log($top_query);
                $top_sql = $this->db->query($top_query);
                $ret_arr = array();
                while($rows = $this->db->fetchAssoc($top_sql)){
                        $_arr = array();
                        $_arr  = $rows;
                        $ret_arr[] = $_arr;
                }
                $this->db->closeConnection();
                return $ret_arr;
	}


	public function getRelatedAudio($title, $artist){
		$query_title = $this->db->escape($title);
		$query_artist = $this->db->escape($artist);

		$query_string = "$query_title $query_artist";

		$query_set = explode(" ",$query_string);	
	
		foreach($query_set as $key){
			$key = "%$key%";
	                $top_query = sprintf("SELECT * FROM audio WHERE title LIKE '%s' OR artist LIKE '%s'", $key,$key);
	                error_log($top_query);
	                $top_sql = $this->db->query($top_query);
        	        $ret_arr = array();
		
                	while($rows = $this->db->fetchAssoc($top_sql)){
                        	$_arr = array();
	                        $_arr  = $rows;
	                        $ret_arr[] = $_arr;
	                }
		}
                $this->db->closeConnection();
                return $ret_arr;
	}


	public function addVideo($title, $path, $type, $lang, $director, $rel_date, $subt, $review, $poster) {
		$query_title = $this->db->escape($title);
		$query_type = $this->db->escape($type);
		$query_path = $this->db->escape($path);
		$query_lang = $this->db->escape($lang);
		$query_dir = $this->db->escape($director);
		$query_date = $this->db->escape($rel_date);
		$query_subt = $this->db->escape($subt);
		$query_rev = $this->db->escape($review);
		$query_post = $this->db->escape($poster);
		$top_query = sprintf("select id from videos where path='%s'", $query_path);
		error_log($top_query);
		$top_sql = $this->db->query($top_query);
		while ($rows = $this->db->fetchAssoc($top_sql)) {
			#already exists
			return false;
		}

		if($subt && $poster && $review){
	                $top_query = sprintf("insert into videos (title, path, type, language, director, rel_date, subtitle, review, poster) values ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')", $query_title, $query_path, $query_type, $query_lang, $query_dir, $query_date, $query_subt, $query_rev, $query_post);
		}else{
	                $top_query = sprintf("insert into videos (title, path, type, language, director, rel_date) values ('%s', '%s', '%s', '%s', '%s', '%s')", $query_title, $query_path, $query_type, $query_lang, $query_dir, $query_date);
		}

                error_log($top_query);
                $top_sql = $this->db->query($top_query);
		#will return true or false
                return $top_sql;
	}

	//Posters
	
	public function getAllPosters(){
	
		$top_query = sprintf("SELECT * FROM posters");
                error_log($top_query);
                $top_sql = $this->db->query($top_query);
                $ret_arr = array();
                while($rows = $this->db->fetchAssoc($top_sql)){
                        $_arr = array();
                        $_arr  = $rows;
                        $ret_arr[] = $_arr;
                }
                $this->db->closeConnection();
                return $ret_arr;
	
	}

        public function getPosterById($id){
                $query_str = $this->db->escape($id);
                $top_query = sprintf("SELECT * from posters where id = '%s'", $query_str);
                error_log($top_query);
                $top_sql = $this->db->query($top_query);
                $ret_arr = array();
                while($rows = $this->db->fetchAssoc($top_sql)){
                        $_arr = array();
                        $_arr = $rows;
                        $ret_arr[] = $_arr;
                }
                $this->db->closeConnection();
                return $ret_arr;
        }

	public function addPoster($title, $path, $type, $inf_id){
	
		$query_title = $this->db->escape($title);
		$query_path = $this->db->escape($path);
		$query_type = $this->db->escape($type);
		$query_inf_id = $this->db->escape($inf_id);
		$top_query = sprintf("select id from posters where path='%s'", $query_path);
		error_log($top_query);
		$top_sql = $this->db->query($top_query);
		while ($rows = $this->db->fetchAssoc($top_sql)) {
			#already exists
			return false;
		}

		if($inf_id){
			$top_query = sprintf("INSERT INTO posters(title, path, type, info_id) values ('%s','%s', '%s', '%s')",$query_title, $query_path, $query_type, $query_inf_id);
                	error_log($top_query);
	                $top_sql = $this->db->query($top_query);
		}else{
			$top_query = sprintf("INSERT INTO posters(title, path, type) values ('%s','%s', '%s')",$query_title, $query_path, $query_type);
                	error_log($top_query);
	                $top_sql = $this->db->query($top_query);
		}

		#will return true or false
                return $top_sql;
	}

}
?>
