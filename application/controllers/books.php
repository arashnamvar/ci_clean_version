<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class books extends CI_Controller 
{

	public function __construct()
	{
		parent::__construct();
		$this->output->enable_profiler();
		$this->load->model('book');
	}
// INDEX, LOGIN, LOGOUT, REGISTER
	public function index()
	{
		if($this->session->userdata("logged_in") == 1)
		{
			$results = $this->book->recent_reviews();
			$this->load->view("home.php", array("data" => $results));
		}
		else
		{
		$this->load->view("login_register.php");
		}
	}

	public function register()
	{
		$result = $this->book->register($this->input->post());
		if(!empty($result))
		{
			$this->session->set_flashdata("errors", $result);	
		}
		redirect("/");
	}

	public function logout()
	{
		$this->session->unset_userdata("logged_in");
		$this->session->unset_userdata("user");
		redirect("/");
	}

	public function login()
	{
		$result = $this->book->login($this->input->post());
		if(!empty($result))
		{
			$this->session->set_flashdata("errors", $result);	
		}
		redirect("/");
	}
// ADD BOOK + REVIEW

	public function add()
	{
		$authors = $this->book->authors();
		$this->load->view("add.php", array("aut" => $authors));
	}

	public function add_book()
	{
		$result = $this->book->add($this->input->post());
		if(is_array($result))
		{
			$this->session->set_flashdata("errors", $result);	
		}
		elseif(is_string($result))
		{
			$lol = "/book/" . $result;
			redirect($lol);	
		}
	}
// VIEW BOOK

	public function book($id)
	{
		$data = $this->book->get_book($id);
		$this->load->view("book", array('all_data' => $data));
	}


// ADD REVIEW (ON BOOK PAGE)

	public function add_review($id)
	{
		$this->book->add_review($this->input->post());
		$redirect = "/book/" . $id;
		redirect($redirect);
	}

// DELETE REVIEW

	public function delete_review($id, $id2)
	{
		$this->book->delete_review($id);
		$redirect = "/book/" . $id2;
		redirect($redirect);
	}
// VIEW USER

	public function user($id)
	{
		$data = $this->book->user_data($id);
		$this->load->view("user", array("all_data" => $data));
	}
}

//end of main controller