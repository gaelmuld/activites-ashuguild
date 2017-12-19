<?php
//include 'DBConnect.php';

    spl_autoload_register(function ($class) {
        include $class . '.class.php';
    });
class Dbact
{
    private $result;
    private $connexion;
    private $prefix;
    
    
    function __construct() {
        $connexion = new Dbconnect;
        $this->result = $connexion->connectionDB();
        $this->prefix = $connexion->getPrefix();
    }
    function getPrefix(){
        return ($this->prefix)?$this->prefix.'_':'';
    }
    function getAll($table){
        $table=$this->getPrefix().$table;
        $res =$this->result->query('SELECT * FROM '.$table);
        return $res->fetchall(PDO::FETCH_ASSOC);
        
    }
    function getWhere($table,$where='1',$cond='AND'){
        $table=$this->getPrefix().$table;
        $w=[];
        if (gettype($where) =='array'){
            foreach($where as $k=>$v){
                $w[$k]=$k.' = "'.$v.'"';
            }
            $w=implode(' '.$cond.' ',$w);
        }else {
            $w=$where;
        }
        $query = 'SELECT * FROM '.$table.' WHERE '.$w;
        
        
        $res =$this->result->query($query);
        return $res->fetchall(PDO::FETCH_ASSOC);
        
    }
    function getId($table,$id){
        $table=$this->getPrefix().$table;
        $res =$this->result->query('SELECT * FROM '.$table.' WHERE id='.$id);
        return $res->fetchall(PDO::FETCH_ASSOC);
        
    }
    function getLastId($table){
        $table=$this->getPrefix().$table;
        $res =$this->result->query('SELECT * FROM '.$table.' ORDER BY id DESC LIMIT 1');
        return $res->fetchall(PDO::FETCH_ASSOC);
        
    }
    function insert($table,$values){
        $table=$this->getPrefix().$table;
        $col='';
        $val='';
        $i=0;
        foreach($values as $k=>$v){
            //pour eviter problème d'encodage
            $k=str_replace("\"","",$k);
            $v=str_replace("\"","",$v);
            //tableau des keys et des values
            $col[$i]=$k;
            $val[$i]='"'.$v.'"';
            $i++;
        }
        
        //concatenations des tableaux
        $col=implode(',',$col);
        $val=implode(',',$val);
        
        //requete
        $query = 'INSERT INTO '.$table.' ('.$col.') VALUES ('.$val.')';
        return ($this->result->exec($query))?true:false;
    }
    function updateActivity($id,$val){
        $i=0;
        $updateTable=[];
        foreach($val as $k=>$v){
            //pour eviter problème d'encodage
            $k=str_replace("\"","\\\"",$k);
            $v=str_replace("\"","\\\"",$v);
            //tableau des keys et des values
            $updateTable[$i]=$k.' = "'.$v.'"';
            $i++;
        };
        
        $updateString=implode(',',$updateTable);
        $sql='UPDATE '.$this->getPrefix().'activites SET '.$updateString.' WHERE id="'.$id.'"';
        
        $res =$this->result->exec($sql);
        
        return $res;
        
    }
    function updateApi($compte,$val){
        $res =$this->result->exec('UPDATE '.$this->getPrefix().'dachis SET apiGw2 = "'.$val.'" WHERE compte="'.$compte.'"');
        return $res;
        
    }
    function updateConnexion($compte,$val){
        $res =$this->result->exec('UPDATE '.$this->getPrefix().'dachis SET apiConnection="'.$val.'" WHERE compte="'.$compte.'"');
        return $res;
        
    }
    function updatePseudo($api,$val){
        $res =$this->result->exec('UPDATE '.$this->getPrefix().'dachis SET pseudo="'.$val.'" WHERE apiGw2="'.$api.'"');
        return $res;
        
    }
    function updateMdp($api,$val){
        $res =$this->result->exec('UPDATE '.$this->getPrefix().'dachis SET mdp="'.$val.'" WHERE apiGw2="'.$api.'"');
        return $res;
        
    }
}
