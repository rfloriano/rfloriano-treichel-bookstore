<?php
	require_once("model/base.php");
	require_once("model/book.php");

	class Categorie extends Model {
	    var $name;

		public function get_absolute_url(){
			global $documentRoot;
			return "$documentRoot/categorias/detalhe/$this->id/";
		}

		public function books(){ # ManyToMany
			$books = new Book();
			return $books->filter(
				"categorie.id = ".$this->id,
				"INNER JOIN bookcategorie ON book.id = bookcategorie.book_id
				 INNER JOIN categorie ON bookcategorie.categorie_id = categorie.id"
			);
		}
	}
?>