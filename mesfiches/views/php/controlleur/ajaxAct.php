<?php
spl_autoload_register(function ($class) {
    include '../classes/'.$class . '.class.php';
});

$DB= new Dbact;
$table= 'activites';

/********************************\
|**Ajout en modif des activités**|
\********************************/

if(isset($_POST['newActivity'])){
    if($_POST['newActivity']){
        if($DB->insert($table,$_POST['activite'])){
            echo 'nouvelle activité enregistré';
        }else{
            echo 'il y a un pépin';
        }
    }
    if(!$_POST['newActivity']){
        $DB->updateActivity($_POST['idActivity'],$_POST['activite']);
        if(true){
            echo 'activité modifié';
        }else{
            echo 'il y a un pépin';
        }
    }
}

if(isset($_POST['recive'])){
    $lastItem=$DB->getId($table,$_POST['recive']);
    echo json_encode($lastItem);
}

/***********************************\
|**Ajout et modif des participants**|
\***********************************/
