<?php
	require_once("config/config.php");

	class Model {
		var $id = NULL;

		protected function _cls(){
			return get_class($this);
		}

		protected function _table(){
			return strtolower(get_class($this));
		}
		
		protected function _db(){
			global $DB;
			return $DB;
		}

		public function filter($condition = NULL, $join = NULL, $fields = "*"){
			return $this->_db()->select(
				$this->_cls(), 
				$this->_table(), 
				$fields, 
				$condition,
				$join
			);
		}

		public function all($fields = "*"){
			return $this->filter(NULL, NULL, $fields);
		}

		public function get($condition, $fields = "*"){
			return $this->_db()->get(
				$this->_cls(), 
				$this->_table(), 
				$fields, 
				$condition
			);
		}

		public function get_or_create($condition){
			$query = "";

            $numItems = count($condition);
            $i = 0;
            foreach($condition as $key => $value) {
                if (!empty($value)){
                    $query .= "$key = '$value'";
                    if($i+1 < $numItems) {
						$query .= " AND ";
                    }
                }
                $i++;
            }
			
			try {
				$cart = $this->get($query);
				$created = FALSE;
			} catch (Exception $e) {
				foreach ($condition as $key => $value) {
					$this->$key = $value;
				}
				$cart = $this->save();
				$created = TRUE;
			}
			return Array(
				$cart,
				$created
			);
		}

		public function save(){
			$data = (array) $this;
			if ($this->id == NULL){
				return $this->_db()->insert(
					$this->_cls(), 
					$this->_table(),
					$data
				);
			}else{
				return $this->_db()->update(
					$this->_cls(), 
					$this->_table(),
					$data,
					"id = ".$this->id
				);
			}
		}

		public function delete(){
			return $this->_db()->delete(
				$this->_cls(),
				$this->_table(),
				"id = ".$this->id
			);
		}
	}
?>