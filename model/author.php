<?php
	require_once("model/base.php");
	require_once("model/book.php");

	class Author extends Model {
		var $name;
		var $born;

		public function get_absolute_url(){
			global $documentRoot;
			return "$documentRoot/autores/detalhe/$this->id/";
		}

		public function books(){ # ManyToMany
			$books = new Book();
			return $books->filter(
				"author.id = ".$this->id,
				"INNER JOIN bookauthor ON book.id = bookauthor.book_id
				 INNER JOIN author ON author.id = bookauthor.author_id"
			);
		}
	}
?>