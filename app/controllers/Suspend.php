<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Suspend extends MY_Controller
{


    public function index()
    {
        $this->load->view('default/views/suspend', $data); // For suspend page 
    }
	
	
	public function login()
    {
        $this->load->view('default/views/suspend', $data); // For suspend page 
    }
    
}
