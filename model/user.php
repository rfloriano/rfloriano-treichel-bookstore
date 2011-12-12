<?php
	require_once("model/base.php");
	require_once("model/cart.php");

	class User extends Model {
	    var $name;
	    var $username;
	    var $password;
	    var $admin = false;

		public function get_absolute_url(){
			global $documentRoot;
			return "$documentRoot/admin/user/$this->id/";
		}

		public function carts(){ # Many
			$carts = new Cart();
			return $carts->filter(
				"user_id = ".$this->id
			);
		}
	}
?>