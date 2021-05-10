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
			$this->user = $post_row['pseudo'];
			$this->title_post = $post_row['title'];
			$this->text_post = $post_row['post_text'];
			$this->date_post = $post_row['post_date'];
			$this->id_post = $post_row['id_post'];
			$this->count_like = $post_row['count_like'];
			$this->count_answer = $post_row['count_answer'];
			$this->is_liked = $post_row['is_liked'];
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
		private $id_answer;
		private $reference;
		private $id_post;
		private $user;
		private $text_answer;
		private $date_answer;
		private $pseudo_post;
		private $answer_lvl;
		private $count_like;
		private $count_answer;
		private $is_liked;
		private $like_button;
		private $like_value;
		
		function __construct($answer_row, $id_post){
			$this->id_answer = $answer_row['id_answer'];
			$this->user = $answer_row['pseudo'];
			$this->text_answer = $answer_row['answer_text'];
			$this->date_answer = $answer_row['date'];
			$this->pseudo_post = $answer_row['parent_pseudo'];
			$this->id_post = $id_post;
			$this->reference = $answer_row['reference_answer'];
			if($this->reference == 0) {
				$this->answer_lvl = "answer_post";
			}else{
				$this->answer_lvl = "answer_answer";
			}
			$this->count_like = $answer_row['count_like'];
			$this->count_answer = $answer_row['count_answer'];
			$this->is_liked = $answer_row['is_liked'];
			if ($this->is_liked == 0) {
				$this->like_button = 'disliked_button';
				$this->like_value = 'Liker';
				
			}else{
				$this->like_button = 'liked_button';
				$this->like_value = 'Disliker';
			}
		}
		public function getReference(){
			return $this->reference;
		}
		public function getId(){
			return $this->id_answer;
		}
		public function afficherAnswer(){
			$gab = new Template("./");
			$gab->set_filenames(array("body" => "template.answer.html"));	
			$gab->assign_vars(array("user" => $this->user));
			$gab->assign_vars(array("text" => $this->text_answer));
			$gab->assign_vars(array("date" => $this->date_answer));
			$gab->assign_vars(array("pseudo_post" => $this->pseudo_post));
			$gab->assign_vars(array("answer_lvl" => $this->answer_lvl));			
			$gab->assign_vars(array("count_like" => $this->count_like));
			$gab->assign_vars(array("count_answer" => $this->count_answer));
			$gab->assign_vars(array("id_answer" => $this->id_answer));
			$gab->assign_vars(array("id_post" => $this->id_post));
			$gab->assign_vars(array("reference" => $this->reference));
			$gab->assign_vars(array("like_button" => $this->like_button));
			$gab->assign_vars(array("like_value" => $this->like_value));
			$gab->pparse("body");
		}
		public function afficherSons($pdo){
			$sons = new request_database($pdo, "SELECT a.id_answer, pseudo, answer_text, date, reference_answer, count_like, count_answer, is_liked, parent_pseudo
												FROM (
												SELECT a.id_answer, pseudo, answer_text, date, reference_answer, count_like, count_answer, COUNT(id_user) as is_liked
												FROM (
												SELECT imb.id_answer, pseudo, imb.answer_text, imb.date, imb.reference_answer, count_like, COUNT(a.id_answer) AS count_answer
												FROM (
												SELECT a.id_answer, u.pseudo, a.answer_text, a.date, a.reference_answer, COUNT(l.id_user) AS count_like  
												FROM user as u, answer AS a LEFT JOIN answer_like AS l ON l.id_answer=a.id_answer
												WHERE u.id_user=a.id_user AND a.reference_answer=".$this->id_answer."
												GROUP BY a.id_answer) AS imb 
												LEFT JOIN answer AS a ON a.reference_answer=imb.id_answer
												GROUP BY imb.id_answer) AS a LEFT JOIN (
												SELECT id_answer, id_user
												FROM answer_like
												WHERE id_user=".$_SESSION['id_user'].") AS b ON a.id_answer=b.id_answer
												GROUP BY a.id_answer
												ORDER BY count_like DESC) AS a, (
												SELECT pseudo AS parent_pseudo, id_answer
												FROM user AS u, answer AS a
												WHERE u.id_user=a.id_user) AS b
												WHERE a.reference_answer=b.id_answer");
			$sons->executer();
			if ($sons->existResult() == "true"){
				foreach ($sons->getResult() as $son){
					$answer = new Answer($son, $this->id_post);
					$answer->afficherAnswer();
					$answer->afficherSons($pdo);
					include("div.end.html");
				}
			}
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