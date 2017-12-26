<?php
class M_participants extends CI_Model {

    public function __construct()
    {
            parent::__construct();
    }
    function getParticipants($id_activite){
        return $this->db->query("
        SELECT pseudo,compte,participant
        FROM dachis
        INNER JOIN participants ON dachis.id =id_dachi 
        INNER JOIN activites ON id_activite = activites.id
        WHERE id_activite = '".$id_activite."'
        ORDER BY participant DESC,pseudo ASC;
        ");
    }
 
    function insertParticipant(){
        $data= array(
            'id_dachi'=>$_SESSION['id'],
            'id_activite'=>$_POST['id_activite'],
            'participant'=>$_POST['participant']
        );
        $where= array(
            'id_dachi'=>$_SESSION['id'],
            'id_activite'=>$_POST['id_activite']
        );
        $query=$this->db->get_where('participants', $where);
        if(!($query->result())){
            $this->db->insert('participants', $data);
            return true;
        }else{
            return false;
        } 
    }
 
    function updateParticipant(){
        $data= array('participant'=>$_POST['participant']);
        $where= array(
            'id_dachi'=>$_SESSION['id'],
            'id_activite'=>$_POST['id_activite']);
        if($this->db->update('participants', $data,$where)){
            return true;
        }
        return false;
        
    }
    
}
