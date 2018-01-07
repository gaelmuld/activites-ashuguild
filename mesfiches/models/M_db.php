<?php
class M_db extends CI_Model {

    
    public function __construct()
    {
            parent::__construct();
    }
    function getActivites(){
        return $this->db->query("SELECT id,titre,imgDescription,dateFin,createur FROM activites ORDER BY dateDebut DESC");
    }

    function getId($table,$id){
        $data= array('id'=>$id);
        return $this->db->get_where($table,$data);
        
    }
    function getLastId(){
       return $this->db->insert_id();
        
    }
    function getCompte($pseudo,$compte){
        $this->db->where('pseudo',$pseudo);
        $this->db->or_where('compte',$compte);
        return $this->db->get('dachis')->result_array()[0];
    }
    function updateApi($compte,$val){
        $data= array('apiGw2'=>$val);
        $where= array('compte'=>$compte);
        $this->db->update('dachis', $data,$where);
        
    }
    function updateConnexion($compte,$val){
        
        $data= array('apiConnection'=>$val);
        $where= array('compte'=>$compte);
        $this->db->update('dachis', $data,$where);
        
    }
    function updatePseudo($api,$val){
        
        
        $data= array('pseudo'=>$val);
        $where= array('apiGw2'=>$api);
        $this->db->update('dachis', $data,$where);
        
    }
    function updateMdp($api,$val){
        
        
        $data= array('mdp'=>$val);
        $where= array('apiGw2'=>$api);
        $this->db->update('dachis', $data,$where);
        
    }
    function updateMdpAndPseudo($api,$mdp,$pseudo){
        
        
        $data= array('mdp'=>$mdp,'pseudo'=>$pseudo);
        $where= array('apiGw2'=>$api);
        $this->db->update('dachis', $data,$where);
        
    }
    function updateRang($ids,$rang){
        foreach($ids as $k=>$id){
            $query='UPDATE dachis SET rang = "'.$rang[$k].'" WHERE id = '.$id.' ; ';
            $this->db->query($query);
        }
    }
}
