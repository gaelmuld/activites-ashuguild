<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Control extends CI_Controller {
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
    
    
	public function index()
        {
        session_destroy();
        $data= array(
            'vue'=>'index',
            'message'=>$this->session->flashdata('message')
        );
		  $this->load->view('templates/template',$data);
        }	
    public function disconnect()
        {
            $sessionVar= array('pseudo','rang','id');
            $message='Au revoir';
            $this->session->unset_userdata($sessionVar);
            $this->session->set_flashdata('message', $message);
            header('Location:'.base_url());
        }
    public function connexion()
        {
        /*****************************************\
        |**Initialisation des variables communes**|
        \*****************************************/
        $infoCreate=[
            "pseudo" => $_POST['pseudo'],
            "mdp" => md5($_POST['mdp'])
        ];
        $table='dachis';
        
        /*****************\
        |**SI connection**|
        \*****************/
        
        if(isset($_POST['connexion'])){
            //connexion d'un compte
            $query=$this->db->get_where($table,$infoCreate);
            $result=$query->result_array();
            if($result){
                $result=$result[0];
                $newdata=array(
                    'pseudo'=>$result['pseudo'],
                    'rang'=>$result['rang'],
                    'id'=>$result['id'],
                );
                $this->session->set_userdata($newdata);
                $data['message']='Connexion réussie';
                $this->session->set_flashdata('message', $data);
                header('Location:'.base_url().'control/selection');
                
            }else{
                $data['message'] ='Mauvais pseudo/mot de passe';
                $this->session->set_flashdata('message', $data['message']);
                header('Location:'.base_url());
            }
            
        }
        /****************************\
        |**Si creation/modification**|
        \****************************/
        
        else if(isset($_POST['creation'])){
            
            // création ou récupération de compte
            $infoCreate['apiGw2'] = $_POST['apiKey'];
            $nameAccount = $this->apigw2->getMembreNameAccount($infoCreate['apiGw2']);
            $result=null;
            
            $query=$this->db->get_where($table,$infoCreate);
            if($result = $query->result_array()){
                $result= $result[0];
            }
            if($result != null){
                if($result['pseudo'] == $infoCreate['pseudo'] && $result['mdp'] == $infoCreate['mdp'] && $nameAccount['name'] == $result['compte']){
                    //mise à jour de l'api
                    $this->m_db->updateApi($result['compte'],$api);
                    $data['message'] = 'API changé';
                    $this->session->set_flashdata('message', $data['message']);
                    header('Location:'.base_url());
                }
                
            }else{
                
                // nouveau inscrit  
                $option["pseudo"]=$infoCreate['pseudo'];
                $option["apiGw2"]=$infoCreate['apiGw2'];
                //pret pour ce connecter à l'api
                if($result=$this->db->get_where($table,$option)->result()){
                    //pour changer de mot de passe
                    $this->m_db->updateMdp($api,$mdp);
                    $data['message'] ='Mot de passe changé';
                    $this->session->set_flashdata('message', $data['message']);
                    header('Location:'.base_url());
                }else if($result=$this->db->get_where($table,'pseudo = "'.$option['pseudo'].'"')->result()){
                    //si pseudo déjà pris
                    $data['message'] ='pseudo déjà pris';
                    $this->session->set_flashdata('message', $data['message']);
                    header('Location:'.base_url());
                }else{
                    //nouveau confirmé
                    if($nameAccount){
                        $query=$this->db->get_where($table,'apiGw2 = "'.$option['apiGw2'].'"');
                        if($result=$query->result()){
                            //si api déjà existant
                            $this->m_db->updateMdp($option['apiGw2'],$infoCreate['mdp']);
                            $this->m_db->updatePseudo($option['apiGw2'],$infoCreate['pseudo']);
                            $data['message'] ='pseudo et mot de passe changé';
                            $this->session->set_flashdata('message', $data['message']);
                            header('Location:'.base_url());
                        }else{
                        $infoCreate['compte']=$nameAccount['name'];
                        $this->db->insert($table,$infoCreate);
                        $data['message'] ='Bienvenu, cher Dachi';
                        $this->session->set_flashdata('message', $data['message']);
                        header('Location:'.base_url());
                        }
                    }else{
                        //si api incorrecte
                        $data['message'] ="Api Incorrecte";
                        $this->session->set_flashdata('message', $data['message']);
                        header('Location:'.base_url());
                    }
                }
            }
        }
    }
    function selection()
        {
        if(!$_SESSION['pseudo']){
           header('Location:'.base_url()); 
        }
        $query= $this->m_db->getActivites();
        $data= array(
            'vue'=>'selection',
            'activites'=>$query->result_array(),
            'message'=>''
        );
    	  $this->load->view('templates/template',$data);
        }
    function activite($id)
    {
        if(!$_SESSION['pseudo']){
           header('Location:'.base_url()); 
        }
        $activite= $this->m_db->getId('activites',$id);
        $participants= $this->m_participants->getParticipants($id);
        $data= array(
            'vue'=>'activity',
            'activite'=>$activite->result_array()[0],
            'participants'=>$participants->result_array(),
            'message'=>''
        );
        $this->load->view('templates/template',$data);
        }
    
    public function activityUpdate()
        {
        $this->db->where ('id',$_POST['idActivity']);
        $this->db->update('activites', $_POST['activite']);
        echo 'Activité mise à jour';
        return;
        }
    public function newActivity()
        {
            $activite=array(
                'titre'=> "nouvelle Activité",
                'id'=> 'N/A',
                'dateDebut'=>'',
                'dateFin'=>'',
                'imgDescription'=>'https://d3b4yo2b5lbfy.cloudfront.net/wp-content/uploads/2012/02/guildwars2-031.jpg',
                'description'=>'À remplire',
                'regles'=>'<li> À remplire </li>',
                'duree'=>'<li> À remplire </li>',
                'prerequis'=>'<li> À remplire </li>'
                );
        $data= array(
            'vue'=>'activity',
            'message'=>'',
            'activite'=>$activite,
            'newActivite'=>1
        );
    	  $this->load->view('templates/template',$data);
        }
    public function activityCreate()
        {
        $this->db->insert('activites', $_POST['activite']);
        echo 'Activité crée';
        return;
    	  
        }    
    public function activityDelete($id)
        {
        $this->db->where ('id',$id);
        $this->db->delete('activites');
        echo 'Activité supprimer';
        header('Location:'.base_url().'control/selection');
    	  
        }
    
    public function inscription(){ 
        
        if(!($this->m_participants->insertParticipant())){
            if(!($this->m_participants->updateParticipant())){
                echo 'Erreur';
                return;
            }
            echo 'Inscription du dachi modifié';
            return;
            
        }
        echo 'Inscription du dachi ajouté';
        return;
    }
}
