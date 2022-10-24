<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Mahasiswa extends REST_Controller
{

    function __construct($config = 'rest')
    {
        parent::__construct($config);
        $this->load->model('Mahasiswamodel', 'model');
    }

    public function index_get()
    {
        $data = $this->model->getMahasiswa();
        $this->set_response([
          'status' => TRUE,
          'code' => 200,
          'message' => 'Success',
          'data' => $data,  
        ], REST_Controller::HTTP_OK);
    }

    public function sendmail_post(){
        $to_email = $this ->post('email');
        $this->load->library('email');
        $this->email->from('jowi@joey.ngantokimt.com', 'SIDU PMI');
        $this->email->to($to_email);
        $this->email->subject('Informasi Penting dari SIDU');
        $this->email->message("
        <body style='outline-style: solid; outline-color: #FF0015; margin: 10px; '>
        <center>
        <h1 style='color: #FF5555;'>Welcome to SIDU PMI </h1>
        <img src = 'https://imgs.search.brave.com/c1A6oOPECUvP7AFjSWuvb4LtnaLBSnr0RS66swXpyr8/rs:fit:850:350:1/g:ce/aHR0cHM6Ly9pLnBp/bmltZy5jb20vb3Jp/Z2luYWxzLzQyL2Mw/LzRjLzQyYzA0YzU3/NzQ2ZWYwMWZkNmU0/ZTUyODYwZDc5ZTA1/LmpwZw' width = '600px' height = '300px'>
        <p style='outline-style : solid; outline-color : #FF0015; font-size: 20px; '>Welcome to Sidu PMI.. We hope you enjoy our services.. </p>
        </center>
        </body>
        ");

        if($this->email->send()){
            $this->set_response([
                   'status' => TRUE,
                   'code' => 200,
                   'message'=> 'Email succesfully sent.. Please check your inbox..'
                    ], REST_Controller::HTTP_OK);

        }else {
            $this->set_response([
                   'status' => FALSE,
                   'code' => 404,
                   'message' => 'Failed to send email'
                    ], REST_Controller::HTTP_NOT_FOUND);
        }
    }
}