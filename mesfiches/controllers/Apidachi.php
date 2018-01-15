<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Apidachi extends CI_Controller {

    public function index(){
        return 'coucou';
    }
    public function verifKey($dachiKey){
        return true;
    }

    public function getDachi($dachiKey){
        if($this->verifKey($dachiKey)){
            $this->load->model('M_dachis');
            return json_encode($this->M_dachis->getDachis());
        }else{
            echo 'Clé inconnue';

        }
    }

}
