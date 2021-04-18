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
		private $count_like;
		private $count_answer;
		private $is_liked;
		private $like_button;
		private $like_value;
		
		function __construct($post_row){
			$this->user = current(array_slice($post_row, 0, 1));
			$this->title_post = current(array_slice($post_row, 1, 1));
			$this->text_post = current(array_slice($post_row, 2, 1));
			$this->date_post = current(array_slice($post_row, 3, 1));
			$this->id_post = current(array_slice($post_row, 4, 1));
			$this->count_like = current(array_slice($post_row, 5, 1));
			$this->count_answer = current(array_slice($post_row, 6, 1));
			$this->is_liked = current(array_slice($post_row, 7, 1));
			if ($this->is_liked == 0) {
				$this->like_button = 'disliked_button';
				$this->like_value = 'Liker';
				
			}else{
				$this->like_button = 'liked_button';
				$this->like_value = 'Disliker';
			}
		}
		public function getID(){
			return $this->id_post;
		}
		public function afficherPost(){
			$gab = new Template("./");
			$gab->set_filenames(array("body" => "template.post.html"));	
			$gab->assign_vars(array("user" => $this->user));		
			$gab->assign_vars(array("title" => $this->title_post));
			$gab->assign_vars(array("text" => $this->text_post));
			$gab->assign_vars(array("date" => $this->date_post));
			$gab->assign_vars(array("id_post" => $this->id_post));
			$gab->assign_vars(array("count_like" => $this->count_like));
			$gab->assign_vars(array("count_answer" => $this->count_answer));
			$gab->assign_vars(array("like_button" => $this->like_button));
			$gab->assign_vars(array("like_value" => $this->like_value));
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
			$gab->set_filenames(array("body" => "template.answer.html"));	
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