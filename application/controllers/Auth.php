
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller
{
	public $_data;
	public function __construct()
	{
		parent::__construct();

		$this->load->model('user_model');
    $this->_table = 'users';
	}

  	/**
   	* Display login form.
   	*/
  	public function index()
  	{
	  	if ($this->_is_logged_in() == TRUE)
	  	{
	  		$today = date('Y-m-d');
	  		$data['students'] = $this->db->where('re_status',1)->order_by('re_id','desc')->get('register')->result();
	  		$data['events'] = $this->db->where('ev_status',1)->where('ev_date >= ',$today)->order_by('ev_date','asc')->limit(5)->get('events')->result(); 

	  		$this->load->view('auth/admin_home',$data);
	  	}
	  	else
	  	{
	  		$data = array();
	  		$data['email'] = '';
	  		$this->load->view('auth/login', $data);
	  	}

  	}
  

  	/**
   	* Process user authentication.
   	*/
  	public function authenticate()
  	{
	  	if ($this->input->post())
	  	{
	      // Authenticate user.
	  		$userData = array('email' => $this->input->post('email'), 'password' => md5($this->input->post('password')));

	  		$user_id = $this->user_model->authenticate($userData);
	  		if ($user_id > 0)
	  		{
	        	// Create session var
	  			$user = $this->user_model->find_by_id($user_id);
	  			$this->create_login_session($user);

	  			$this->session->set_flashdata('flash_message', 'You are logged in.');

	  			redirect("dashboard");
	  		}
	  		else { 
	  			$data = array();
	  			$data['login_error'] = 'Incorrect Username/Password or check email to verify';
	  			$data['email'] = $this->input->post('uname'); 
	  			$this->load->view('auth/login', $data);
	  		}
	  	} 
	  	else 
	  	{
	  		$this->load->view('auth/login');
	  	}
  	}
  
  /**
   * Process user logout.
   */
  public function logout()
  {
  	$this->session->sess_destroy();
  	redirect('');
  }
  
  /**
   * Display forgot password view. Processes forgot password form.
   *
   * @return type 
   */
  public function forgotpassword()
  {

  	$this->load->view('admin/auth/forgot_password');
  }
  
  /**
   * Displays reset password view. Processes password reset.
   *
   * @param type $uuid 
   */
  public function recover_password()
  {

  	$this->load->library('form_validation');
  	$this->form_validation->set_rules('email_address',  'required|trim|xss_clean|callback_validate_credentials');

      //check if email is in the database
  	$email = $this->input->post('email_address');
			//$this->load->model('model_users');
  	if($this->db_mdl->admin_email_exists($email))
  	{
				//$them_pass is the varible to be sent to the user's email 
  		$temp_pass = md5(uniqid());
				//print_r($temp_pass);
				//send email with #temp_pass as a link
  		$this->load->library('email', array('mailtype'=>'html'));
  		$this->email->from('example@gmail.com', "Site");
  		$this->email->to($this->input->post('email_address'));
  		$this->email->subject("Reset your Password");

  		$message = "<p>This email has been sent as a request to reset our password</p>";
  		$message .= "<p><a href='".base_url()."admin/auth/reset_password/$temp_pass'>Click here </a>if you want to reset your password,
  		if not, then ignore</p>";
    //echo $message;  
  		$this->email->message($message);

  		if($this->email->send())
  		{
  			if($this->db_mdl->admin_temp_reset_password($temp_pass,$email))
  			{
  				$this->load->view('admin/auth/forgot_password_success');
  						//echo "check your email for instructions, thank you";
  			}
  		}
  		else
  		{
  			$this->load->view('admin/auth/forgot_psw_failed');
  		}

  	}
  	else
  	{
				//echo "your email is not in our database";
  		$this->load->view('admin/auth/db_error');
  	} 
			//$this->load->view('_admin/auth/forgot_password',$this->_data);
  }

  public function reset_password($temp_pass)
  {
		//$this->load->model('model_users');
  	if($this->db_mdl->admin_is_temp_pass_valid($temp_pass))
  	{
  		$this->_data['email_address'] = $this->db_mdl->select_where('user',$temp_pass);
  		$this->load->view('admin/auth/reset_password',$this->_data);
		//once the user clicks submit $temp_pass is gone so therefore I can't catch the new password and   //associated with the user...

  	}
  	else
  	{
  		echo "the key is not valid";    
  	}

  }

  public function update_password()
  {
  	$this->load->library('form_validation');
  	$this->form_validation->set_rules('password', 'required');
  	$this->form_validation->set_rules('cpassword', 'required|matches[password]');

  	if($this->form_validation->run() == FALSE)
  	{ 
  		echo "passwords do not match"; 
  	}
  	else
  	{ 
  		$email = $this->input->post('email_address');
		//print_r($email);
  		$data = array('password'=>md5($this->input->post('password')));
  		$this->_data= $this->db_mdl->update_admin_psw_where('user',$email,$data);
  		print_r($email);

  		redirect('admin/auth/index');
  		echo "passwords match"; 
  	}

    //echo "passwords do not match";  

  }
  
  /**
   * Creates session data for logged in user.
   *
   * @param type $user 
   */
  protected function create_login_session($user)
  { 
  	$session_data = array(
  		'company_id'  	 => $user->company_id,
  		'user_name'      => $user->username,
  		'name'      	 => $user->first_name.' '.$user->last_name,
  		// 'image'          => $user->image,
  		'email'  		 => $user->email,
  		'user_id'        => $user->id,
  		'logged_in'      => TRUE,
  		// 'is_admin'       => $user->is_admin,
  		'ip'             => $this->input->ip_address(),
  		'log_type'       => '1'
  	);
  	$this->session->set_userdata($session_data);
  }

  private function _is_logged_in()
  {
  	$session_data = $this->session->all_userdata();
  	return (isset($session_data['is_admin']) && $session_data['is_admin'] > 0 && $session_data['logged_in'] == TRUE);
  }

}
?>