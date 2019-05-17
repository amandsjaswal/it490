<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class events extends CI_Controller
{

    public function __construct()
    {
        Parent::__construct();
        $this->load->model('events_model');
        $this->load->library('session');
    }

    public function index(){
        $data['results'] = $this->events_model->fetchData();
        $this->load->view('events_view',$data);
    }

    public function addevent(){
        if($this->session->userdata('isadmin')==1){
            $this->load->view('addevent');
        }else{
            redirect('events');
        }
    }

    public function create(){
        if($this->session->userdata('isadmin')==1){
            $this->events_model->create();
            redirect("events");
        }else{
            redirect('events');
        }
    }

    public function edit(){
        if($this->session->userdata('isadmin')==1){
            $this->events_model->edit($_GET['event_id']);
            redirect("events");
        }else{
            redirect('events');
        }

    }

    public function delete(){
        if($this->session->userdata('isadmin')==1){
            $this->events_model->delete($_GET['event_id']);
            redirect("events");
        }else{
            redirect('events');
        }

    }

}