<?php
	require_once("model/base.php");
	require_once("model/item.php");
	require_once("model/user.php");

	class Cart extends Model {
		var $user_id;
		var $is_paid;
		var $session_hash;

		public function get_absolute_url(){
			global $documentRoot;
			return "$documentRoot/admin/cart/$this->id/";
		}

		public function add_item($book_id, $quantity = 1){
			$item = new Item();
			$item->book_id = $book_id;
			$item->cart_id = $this->id;
			$item->quantity = $quantity;
			$item->save();
		}

		public function add_items($books){
			for ($book=0; $book < sizeof($books); $book++) { 
				$this->add_item($books[$book][0], $books[$book][1]);
			}
		}
		
		public function remove_item($book_id){
			$item = new Item();
			$item->get(
				"book_id = $book_id AND cart_id = ".$this->id
			);
			$item->delete();
		}

		public function remove_items($books){
			for ($book=0; $book < sizeof($books); $book++) { 
				$this->remove_item($books[$book]);
			}
		}

		public function remove_all_items(){
			$items = $this->items();
			foreach ($items as $key => $item) {
				$item->delete();
			}
		}

		public function items(){
			$item = new Item();
			return $item->filter(
				"cart_id = ".$this->id
			);
		}

		public function total(){
			$items = $this->items();
			$total = 0;
			foreach ($items as $key => $item) {
				$total += $item->getBook()->price;
			}
			return $total;
		}

        public function getUser(){
            $user = new User();
            return $user->get(
                "id = ".$this->user_id
            );
        }

        public function city(){
        	return $this->getUser()->city;
        }

        public function address(){
        	return $this->getUser()->address;
        }
        
        public function cep(){
        	return $this->getUser()->cep;
        }
	}
?>