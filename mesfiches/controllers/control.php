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
        $this->load->model('M_dachis');
        /*******************\
        |**GROSSE FONCTION**|
        \*******************/
        
        /*****************************************\
        |**Initialisation des variables communes**|
        \*****************************************/
        $infoCreate=[
            "pseudo" => $_POST['pseudo'],
            "mdp" => md5($_POST['mdp'])
        ];
        $table='dachis';
        
        /*****************\
        |**Si connection**|
        \*****************/
        
        if(isset($_POST['connexion'])){
            //connexion d'un compte
            $query=$this->db->get_where($table,$infoCreate);
            $result=$query->result_array();
            if($result){
                $result=$result[0];
                
                $inGuild = $this->apigw2->verifInGuild($result['compte']);
                $newdata=array(
                    'pseudo'=>$result['pseudo'],
                    'rangId'=>$result['rangId'],
                    'id'=>$result['id'],
                    'rang'=>$this->M_dachis->getRank($result['rangId'])['niveau']
                );
                if(!$inGuild){
                    $this->m_db->updateRang($result['id'],7);
                    $newdata['rang']=7;
                }
                $this->session->set_userdata($newdata);
                $message='Connexion réussie';
                $this->session->set_flashdata('message', $message);
                
                header('Location:'.base_url().'control/selection');
                
            }else{
                $message ='Mauvais pseudo/mot de passe';
                $this->session->set_flashdata('message', $message);
                header('Location:'.base_url());
            }
            
        }
        /****************************\
        |**Si creation/modification**|
        \****************************/
        
        if(isset($_POST['creation'])){
                   
            $infoCreate['apiGw2'] = $_POST['apiKey'];
            $accountGw2 = $this->apigw2->getMembreAccount($infoCreate['apiGw2']);
                if(!$accountGw2){
                /*********************\
                |**si api incorrecte**|
                \*********************/
                $data['message'] ="Api Incorrecte";
                $this->session->set_flashdata('message', $data['message']);
                header('Location:'.base_url());
                return ;
            }
            @$result=$this->m_db->getCompte($infoCreate['pseudo'],$accountGw2['name']);
            $infoCreate['compte']=$accountGw2['name'];
            if(!$result){
                /*********************\
                |**Si nouvel inscrit**|
                \*********************/
                
            
                /***********************************************\
                |**faut appartenir à la guilde pour s'inscrire**|
                \***********************************************/
                $inGuild = $this->apigw2->verifInGuild($accountGw2['name']);
                
                if(!$inGuild){
                   
                    $data['message'] ='faut être dans la Ashuguilde. Club privé!!';
                    $this->session->set_flashdata('message', $data['message']);
                    header('Location:'.base_url());
                    return ;
                }
                $this->db->insert($table,$infoCreate);
                $data['message'] ='Bienvenu, chez les dachis. '.$infoCreate['pseudo'];
                $this->session->set_flashdata('message', $data['message']);
                
                header('Location:'.base_url());
                return ;
            }
            else{
                /****************************\
                |**Les autres cas possibles**|
                \****************************/
                /*******************************************\
                |**ecriture des cas en binaire.Pour le fun**|
                \*******************************************/
                $compteCheck = $result['compte'] == $infoCreate['compte'];
                $pseudoCheck = $result['pseudo'] == $infoCreate['pseudo'];
                $apiCheck = $result['apiGw2'] == $infoCreate['apiGw2'];
                $mdpCheck = $result['mdp'] == $infoCreate['mdp'];
                $cas= ($compteCheck+0).($pseudoCheck+0).($apiCheck+0).($mdpCheck+0);
                switch ($cas){
                    case '0100':
                        $message ="Pseudo déjà pris" ;
                        $this->session->set_flashdata('message', $message);
                        header('Location:'.base_url());
                        return;
                        //var_dump($message);
                        break;
                    case '0101':
                        $message ="Crée un nouveau compte pour ce compte Gw2 unique" ;
                        $this->session->set_flashdata('message', $message);
                        header('Location:'.base_url());
                        return;
                        //var_dump($message);
                        break;
                    case '1010':
                        /**********************\
                        |**Seul l'api est bon**|
                        \**********************/
                        $api = $infoCreate['apiGw2'];
                        $mdp = $infoCreate['mdp'];
                        $pseudo = $infoCreate['pseudo'];
                        $this->m_db->updateMdpAndPseudo($api,$mdp,$pseudo);
                        $message ='Mot de passe et pseudo changés';
                        $this->session->set_flashdata('message', $message);
                        header('Location:'.base_url());
                        return;
                        //var_dump($api,$pseudo,$mdp,$message);
                        break;
                    case '1011':
                        /**********************\
                        |**api+mdp identiques**|
                        \**********************/
                        $api = $infoCreate['apiGw2'];
                        $pseudo = $infoCreate['pseudo'];
                        //pour changer de mot de passe
                        $this->m_db->updatePseudo($api,$pseudo);
                        $message ='Pseudo changé';
                        $this->session->set_flashdata('message', $message);
                        header('Location:'.base_url());
                        return;
                        //var_dump($api,$pseudo,$message);
                        break;
                    case '1101':
                        /*****************\
                        |**Changer d'api**|
                        \*****************/
                        $this->m_db->updateApi($result['compte'],$infoCreate['apiGw2']);
                        $message = 'API changé';
                        $this->session->set_flashdata('message', $message);
                        header('Location:'.base_url());
                        return;
                        //var_dump($this->db->last_query(),$message);
                        break;
                    case '1110':
                        /***************************\
                        |**Api + pseudo identiques**|
                        \***************************/
                        $api = $infoCreate['apiGw2'];
                        $mdp = $infoCreate['mdp'];
                        //pour changer de mot de passe
                        $this->m_db->updateMdp($api,$mdp);
                        $message ='Mot de passe changé';
                        $this->session->set_flashdata('message', $message);
                        header('Location:'.base_url());
                        return;
                        //var_dump($api,$mdp,$message);
                        break;
                    case '1111':
                        /**********************************\
                        |**Tout est identique->Connection**|
                        \**********************************/
                        
                        $newdata=array(
                            'pseudo'=>$result['pseudo'],
                            'rangId'=>$result['rangId'],
                            'id'=>$result['id'],
                            'rang'=>$this->M_dachis->getRank($result['rangId'])['niveau']
                            );
                        $this->session->set_userdata($newdata);
                        $message='Connexion réussie';
                        $this->session->set_flashdata('message', $message);
                        header('Location:'.base_url().'control/selection');
                        return;
                        //var_dump($newdata,$message,$_SESSION);
                        break;
                    default:
                        $message ="Va demander à un admin. ErrorCode : ".$cas ;
                        $this->session->set_flashdata('message', $message);
                        header('Location:'.base_url());
                        return;
                        //var_dump($data['message']);
                        break;
                }
               
            }
        }
    }
    function verifSession(){
        /**********************\
        |**verifie la session**|
        \**********************/
        if(!$_SESSION['rangId']){
           header('Location:'.base_url()); 
        }
    }
    function selection()
        {
        /********************************\
        |**donne la liste des activités**|
        \********************************/
        $this->verifSession();
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
        /************************************************\
        |**donne les informations de l'activité choisie**|
        \************************************************/
        $this->verifSession();
        $this->load->model('M_dachis');
        @$activite= $this->m_db->getId('activites',$id)->result_array()[0];
        if(!$activite){
            $data['message'] ="Cette activité est poussière" ;
            $this->session->set_flashdata('message', $data['message']);
            header('Location:'.base_url().'control/selection');
        }
        $participants= $this->m_participants->getParticipants($id);
        $data= array(
            'vue'=>'activity',
            'activite'=>$activite,
            'participants'=>$participants->result_array(),
            'message'=>''
        );
        $this->load->view('templates/template',$data);
        }
    
    public function activityUpdate()
        {
        /*****************************\
        |**mise à jour de l'activité**|
        \*****************************/
        $this->db->where ('id',$_POST['idActivity']);
        $this->db->update('activites', $_POST['activite']);
        echo 'Activité mise à jour';
        return;
        }
    public function newActivity()
        {
        /******************************************\
        |**initialisation d'une nouvelle activité**|
        \******************************************/
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
        /************************************\
        |**création d'une nouvelle activité**|
        \************************************/
        var_dump($_POST);
        $this->db->insert('activites', $_POST['activite']);
        echo 'Activité crée';
        return;
    	  
        }    
    public function activityDelete($id)
        {
        /*****************************\
        |**supprétion d'une activité**|
        \*****************************/
        $this->db->where ('id',$id);
        $this->db->delete('activites');
        $message ="Cet activité est né poussière et redevient poussière"  ;
        $this->session->set_flashdata('message', $message);
        header('Location:'.base_url().'control/selection');
    	  
        }
    
    public function inscription(){ 
        /******************************************\
        |**inscription d'un joueur à une activité**|
        \******************************************/
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
    
        function gestion()
    {
        $this->load->model('M_dachis');
        /*************************************\
        |**donne les informations des dachis**|
        \*************************************/
        $this->verifSession();
            if($_SESSION['rang'] == 0){
                $message ="Cet section n'est pas accessible"  ;
                $this->session->set_flashdata('message', $message);
                header('Location:'.base_url().'control/selection');  
            }
    
        $membres = $this->apigw2->getMembresGuild(); //reçu de l'api
        
        $this->db->order_by('rang','DESC');
        $joueurs= $this->M_dachis->getDachis();
        $countActivites= $this->M_dachis->getCreationCount();
        $countParticipations= $this->M_dachis->getParticipationCount();
            
        /*********************************************************************************\
        |**reconstruction des tableau pour facilité l'incrustation dans le tableau final**|
        \*********************************************************************************/
        foreach($countActivites as $countAct){//decompte des activités créées
            $countActs[$countAct['id']]=$countAct['nbCreation'];
        }            
            
        foreach($countParticipations as $countPart){//décompte des participations/refus
            $countParts[$countPart['id']][$countPart['participe']]=0+$countPart['nbParticipe'];
        } 
            
        foreach($joueurs as $k=>$joueur){// infos reçu de l'
            foreach($membres as $member){
                if($joueur['compte'] == $member['name']){
                    $joueurs[$k]['joined']=date('d/m/Y',strtotime($member['joined']));
                    $joueurs[$k]['rankGuild']=$member['rank'];
                    break;
                }else{
                $joueurs[$k]['joined']='Not in Guild';
                $joueurs[$k]['rankGuild']='Not in Guild';
                }
                
            }
            $joueurs[$k]['countCreaAct']=$countActs[$joueur['id']];
            $joueurs[$k]['countParticipation']=array(
                '0'=>0,
                '1'=>0
                );
            if(isset($countParts[$joueur['id']])){
                $joueurs[$k]['countParticipation']=$countParts[$joueur['id']];
            }
        }
        
        $data= array(
            'vue'=>'gestion',
            'joueurs'=>$joueurs,
            'message'=>''
        );
        $this->load->view('templates/template',$data);
        }
    public function gestionAction()
        {
        $this->m_db->updateRang($_POST['id'],$_POST['rang']);
        $message ="Modification effectués"  ;
        $this->session->set_flashdata('message', $message);
        header('Location:'.base_url().'control/gestion');
        
        }
    
}
