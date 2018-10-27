<?php
class clean{

 	private function clean_input_function($dirty){
 //	$data = filter_input(INPUT_GET, $dirty, FILTER_SANITIZE_SPECIAL_CHARS);
    $data = $dirty;
    return $data;
 	}

	 public function clean_tomdate($tomdate){
		$clean_tomdate = $this->clean_input_function($tomdate);
		return $clean_tomdate;
	}
	public function clean_tomweek($tomweek){
		$clean_tomweek = $this->clean_input_function($tomweek);
		return $clean_tomweek;
	}
	 public function clean_count($count){
		$clean_count = $this->clean_input_function($count);
		return $clean_count;
	}

 	public function clean_category($category){
 		$clean_category = $this->clean_input_function($category);
		 return $clean_category;
	 }

	 public function clean_description($description){
		$clean_description = $this->clean_input_function($description);
		return $clean_description;
	}
	 
 	public function clean_keywords($keywords){
 		$clean_keywords = $this->clean_input_function($keywords);
 		return $clean_keywords;
	 }
 	public function clean_url($url){
		$clean_url = $this->clean_input_function($url);
		return $clean_url;
	}
}
?>
