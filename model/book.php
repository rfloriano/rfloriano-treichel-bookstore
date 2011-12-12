<?php
	require_once("model/base.php");
	require_once("model/author.php");
	require_once("model/categorie.php");

	class Book extends Model {
	    var $name;
	    var $description;
	    var $year;
	    var $edition;
	    var $cover;
	    var $price;

		public function get_absolute_url(){
			global $documentRoot;
			return "$documentRoot/livros/detalhe/$this->id/";
		}

		public function authors(){ # ManyToMany
			$author = new Author();
			return $author->filter(
				"book.id = ".$this->id,
				"INNER JOIN bookauthor ON author.id = bookauthor.author_id 
				 INNER JOIN book ON bookauthor.book_id = book.id"
			);
		}

		public function categories(){ # ManyToMany
			$categorie = new Categorie();
			return $categorie->filter(
				"book.id = ".$this->id,
				"INNER JOIN bookcategorie ON categorie.id = bookcategorie.categorie_id
				 INNER JOIN book ON bookcategorie.book_id = book.id"
			);
		}
	}
?>