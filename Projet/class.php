<?php
	include("template.class.php");
	
	class request_database{
		private $pdo;
		private $req;
		private $data;
		function __construct($pdo, $req){
			$this->pdo = $pdo;
			$this->req = $req;
		}
		public function executer(){
			$res = $this->pdo->prepare($this->req);
			$res->execute();
			$this->data = $res->fetchAll(PDO::FETCH_ASSOC);
		}
		public function existResult(){
			if (gettype(current(array_slice($this->data, 0, 1))) == "boolean"){
				return "false";
			}else{
				return "true";
			}
		}
		public function getResult(){
			return $this->data;
		}
		public function getIndex(){
			return current(array_slice(current(array_slice($this->data, 0, 1)), 0, 1));
		}
	}
	
	class Post {
		private $user;
		private $title_post;
		private $text_post;
		private $date_post;
		private $id_post;
		
		function __construct($post_row){
			$this->user = current(array_slice($post_row, 0, 1));
			$this->title_post = current(array_slice($post_row, 1, 1));
			$this->text_post = current(array_slice($post_row, 2, 1));
			$this->date_post = current(array_slice($post_row, 3, 1));
			$this->id_post = current(array_slice($post_row, 4, 1));
		}
		public function getID(){
			return $this->id_post;
		}
		public function afficherPost(){
			$gab = new Template("./");
			$gab->set_filenames(array("body" => "post.tpl.html"));	
			$gab->assign_vars(array("user" => $this->user));		
			$gab->assign_vars(array("title" => $this->title_post));
			$gab->assign_vars(array("text" => $this->text_post));
			$gab->assign_vars(array("date" => $this->date_post));
			$gab->assign_vars(array("id_post" => $this->id_post));
			$gab->pparse("body");
		}
		
	}
	
	class Answer {
		private $user;
		private $text_answer;
		private $date_answer;
		
		function __construct($answer_row){
			$this->user = current(array_slice($answer_row, 0, 1));
			$this->text_answer = current(array_slice($answer_row, 1, 1));
			$this->date_answer = current(array_slice($answer_row, 2, 1));
		}
		public function afficherAnswer(){
			$gab = new Template("./");
			$gab->set_filenames(array("body" => "answer.tpl.html"));	
			$gab->assign_vars(array("user" => $this->user));
			$gab->assign_vars(array("text" => $this->text_answer));
			$gab->assign_vars(array("date" => $this->date_answer));
			$gab->pparse("body");
		}
	}
	
	class FormData {
		private $post_data;

		function __construct($post_param) {
			$this->post_data = $post_param;
		}

		public function getPostData() {
			return $this->post_data;
		}
	}
?>