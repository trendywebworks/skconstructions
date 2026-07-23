<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if(!is_logged_in())
		{
			redirect('');
		}
		
		$this->_table = 'users';
		$this->_user_id = $this->session->userdata('user_id');
		$this->load->model('User_model');
	}

	public function index()
	{
		$data['id'] = $this->_user_id;
		$data['titles'] = array(
			'title'	=>	'Profile Settings',
			'subtitle'	=>	'',
			'addlink'	=>	''
		);
		if (isset ($_POST['change_password']))
		{
		    $this->form_validation->set_rules('oldpassword', 'Old Password', 'required|callback_password_exists['.$this->_user_id.']');
		    $this->form_validation->set_rules('password', 'New Password', 'required');
		    $this->form_validation->set_rules('cpassword', 'Confirm Password', 'required|matches[password]');

		    if($this->form_validation->run() == true)
		    { 
		      $data = array('password'=>md5($this->input->post('password')));
		      $this->common_model->updateWhere($this->_table, array('id' => $this->_user_id), $data);
		      $this->session->sess_destroy();
		      $this->session->set_flashdata('success', 'Password changed successfully, Please login again');
		      redirect('');
		    }

		}
		else if (isset ($_POST['profile']))
		{
			$profiledata = array(
				'first_name' 	=> $this->input->post('first_name'),
				'last_name' 	=> $this->input->post('last_name'),
				'phone' 		=> $this->input->post('phone'),
				'address' 		=> $this->input->post('address'),
				'city' 			=> $this->input->post('city'),
				'state' 		=> $this->input->post('state'),
				// 'role' 			=> $this->input->post('role'),
				'updated_at'	=>	currentDateTime()
			);

			if (!empty($_FILES['profile_pic']['name']))
			{
				$ret = fileUpload('profile_pic', 'profile_pic');
				if($ret['status'] == 1)
				{
					$profiledata['profile_pic'] = $ret['filename'];
				}
				else
				{
					//redirecting to reload page fully
					$this->session->set_flashdata('error', $ret['message'].' Try uploading again.');
					redirect('profile-setting');
				}
			}
		    $this->common_model->updateWhere($this->_table, array('id' => $this->_user_id), $profiledata);
		    $this->session->set_flashdata('success', 'Profile updated successfully.');
		    redirect('profile-setting');
		}
		$data['details'] = $this->User_model->getUserDetails($this->_user_id);
		$data['page'] = 'profile_settings';
		$this->load->view('main', $data);
	}

	public function deleteAccount($id)
	{
		$userdata = $this->User_model->getUserDetails($this->_user_id);
		if($userdata['role_id'] != 1)
		{
			$this->session->set_flashdata('error', 'Only admin users can delete accounts.');
			redirect('profile-setting');
		}

		$insArray = array(
			'status'		=>	'deleted',
			'updated_at'	=>	currentDateTime()
		);
		$this->common_model->updateWhere($this->_table, array('id' => $id), $insArray);
		$this->session->set_flashdata('success', 'Account deleted successfully');
		redirect('admlogout');
	}

	public function password_exists($key, $id)
  	{
    	$this->db->where('password',md5($key))->where('id',$id);
    	$query = $this->db->get($this->_table);
    	if ($query->num_rows() > 0){
        	return true;
    	}
    	else{
    		$this->form_validation->set_message('password_exists','Wrong input for Current Password');
        	return false;
    	}
  	}
}
