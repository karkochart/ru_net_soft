<?php

	class postsModel extends baseModel{
		
		public function getEntries(){
			$return = array();
			$return[0] = array('title'=>'Test model data');

			return $return;
		}
	}
?>
