<?php 

class book extends CI_model 
{
// REGISTER AND LOGIN
	public function register($userdata)
	{	
		$errors = array();
		if(strpbrk($userdata['name'], "~!@#$%^&*()_+-=[]{};:<>/?"))
		{
			$errors[] = "Please provide name without any special characters (ie: ~!@#$%^&*()_+-=[]{};:<>/?)";
		}
		
		if(filter_var($userdata["email"], FILTER_VALIDATE_EMAIL) != true)
		{
			$errors[] = "Please provide a valid email";
		}

		if(strlen($userdata["password"]) < 8)
		{
			$errors[] = "Password must be at least 8 characters";
		}
		
		if($userdata["password"] != $userdata["confirm_password"])
		{
			$errors[] = "Passwords do not match";
		}

		if(empty($userdata["name"]) || empty($userdata["alias"]) || empty($userdata["email"]) || empty($userdata["password"]) || empty($userdata["confirm_password"]))
		{
			$errors[] = "All fields are Required";
		}
		
		$email = $userdata["email"];
		$email_check = $this->db->query("SELECT * FROM users WHERE email = '$email'")->result_array();
		
		if(!empty($email_check))
		{
			$errors[] = "Email is taken";
		}

		if($userdata["password"] != $userdata["confirm_password"])
		{
			$errors[] = "Passwords do not match";
		}
		if(!empty($errors))
		{
			return $errors;
		}
		else
		{
			$name = $userdata['name'];
			$password = md5($userdata["password"]);
			$ailais = $userdata["alias"];
			$query = "INSERT INTO users (name, alias, email, password, created_at) VALUES (?,?,?,?,?)";
			$values = array($name, $ailais, $email, $password, date("Y-m-d H:i:s"));
			$this->db->query($query, $values);
			$user = $this->db->query("SELECT id, name FROM users WHERE email = '$email' AND password = '$password'")->result_array();
			$this->session->set_userdata('logged_in', TRUE);
			$this->session->set_userdata("user", $user);
		}
	}

	public function login($userdata)
	{
		$email = $userdata["email"];
		$password = md5($userdata["password"]);
		$result = $this->db->query("SELECT id, name FROM users WHERE email = '$email' AND password = '$password'")->result_array();
		if(!empty($result))
		{
			$this->session->set_userdata('logged_in', TRUE);
			$this->session->set_userdata("user", $result);
		}
		else
		{
			$errors = array();
			$errors[] = "Email or Password is incorrect";
			return $errors;
		}
	}
// ADD BOOK AND REVIEW
	public function add($userdata)
	{
		if(empty($userdata["book_title"]) || empty($userdata["review"]) || empty($userdata["review"]) || empty($userdata["rating"]))
		{
			$errors = array();
			$errors[] = "All fields are required";
			return $errors;
		}
		else
		{
			if($userdata["author1"] == '' && !empty($userdata["author2"]))
			{
				$author = $userdata["author2"];
			}
			else if($userdata["author1"] != '' && empty($userdata["author2"]))
			{
				$author = $userdata["author1"];
			}
			elseif($userdata["author1"] != '' && !empty($userdata["author2"]))
			{
				$errors = array();
				$errors[] = "Please specify an author";
				return $errors;
			}
			elseif($userdata["author1"] == '' && empty($userdata["author2"]))
			{
				$errors = array();
				$errors[] = "Please specify an author";
				return $errors;
			}
			$title = $userdata["book_title"];
			$review = $userdata["review"];
			$rating = $userdata["rating"];
			$user = $this->session->userdata("user")[0]["id"];
			$does_author_exist = $this->db->query("SELECT id FROM authors WHERE name = '$author'")->result_array();

			if($does_author_exist)
			{
				$author_id = $does_author_exist[0]["id"];
			}
			else
			{
				$query = "INSERT INTO authors (name, created_at) VALUES (?,?)";
				$values = array($author, date("Y-m-d H:i:s"));
				$this->db->query($query, $values);
				$result1 = $this->db->query("SELECT LAST_INSERT_ID()")->result_array();
				$author_id = $result1[0]["LAST_INSERT_ID()"];
			}
			$query2 = "INSERT INTO books (title, author_id, user_id, created_at) VALUES (?,?,?,?)";
			$values2 = array($title, $author_id, $user, date("Y-m-d H:i:s"));
			$this->db->query($query2, $values2);
		$result2 = $this->db->query("SELECT LAST_INSERT_ID()")->result_array();
		$book_id = $result2[0]["LAST_INSERT_ID()"];
			$query3 = "INSERT INTO reviews (user_id, book_id, review, star, created_at) VALUES (?,?,?,?,?)";
			$values3 = array($user, $book_id, $review, $rating, date("Y-m-d H:i:s"));
			$this->db->query($query3, $values3);
			return $book_id;
		}
	}
// GET BOOK 

	public function get_book($id)
	{
		return $this->db->query("SELECT books.title, reviews.id AS review_id, reviews.star, reviews.review, users.name AS user_name, users.id AS users_id, reviews.created_at, authors.name as author_name, books.id AS books_id FROM books 
		LEFT JOIN authors ON authors.id = books.author_id 
		LEFT JOIN reviews ON reviews.book_id = books.id
		LEFT JOIN users ON users.id = reviews.user_id WHERE books.id = '$id'")->result_array();
	}

// ADD REVIEW 
	public function add_review($userdata)
	{
		$user = $this->session->userdata("user")[0]["id"];
		$query = "INSERT INTO reviews (user_id, book_id, review, star, created_at) VALUES (?,?,?,?,?)";
		$values = array($user, $userdata["book"], $userdata["review"], $userdata["rating"], date("Y-m-d H:i:s"));
		$this->db->query($query, $values);
	}
// DELETE REVIEW

	public function delete_review($id)
	{
		$this->db->query("DELETE FROM reviews WHERE id = '$id'");

	}
// SEE USER
	public function user_data($id)
	{
		return $this->db->query("SELECT users.name AS user_name, users.alias AS user_alias, users.email AS email, books.title AS title, books.id AS book_id
		FROM users 
		LEFT JOIN reviews ON reviews.user_id = users.id 
		LEFT JOIN books on reviews.book_id = books.id
		WHERE users.id = '$id'")->result_array();
	}
// SELECT 3 most recent reviews + SELECT all books with reviews that aren't the three above
	public function recent_reviews()
	{
		$results = array();
		$results[] = $this->db->query("SELECT reviews.review AS review, books.id AS book_id, books.title AS book_title, users.id AS user_id, users.name AS user_name, reviews.star AS review_rating, reviews.created_at AS created_at FROM reviews
		LEFT JOIN users ON users.id = reviews.user_id
		LEFT JOIN books ON reviews.book_id = books.id
		ORDER BY reviews.created_at DESC
		LIMIT 3")->result_array();
		$except = "";
		for($i=0;$i<3;$i++)
		{
			$except .= $results[0][$i]["book_id"];
			if($i!=2)
			{
				$except .= ",";
			}

		}
		$results[] = $this->db->query("SELECT books.title AS book_title, books.id AS book_id FROM reviews LEFT JOIN books ON reviews.book_id = books.id WHERE books.id NOT IN ($except)")->result_array();
		return $results;
	}

// SELECT all authors' names
	public function authors()
	{
		return $this->db->query("SELECT name FROM authors ORDER BY name")->result_array();
	}

}
