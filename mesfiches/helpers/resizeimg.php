<?php
include 'my_functions.php';
session_start();
$imgVal='';
//cas de base
if(!isset($_SESSION['page'])){
    $tab=scandir('../resultat/1');
    array_shift($tab);
    array_shift($tab);
    $_SESSION['page']=0;
    $_SESSION['tab']=$tab;
    $imgVal=$_SESSION['tab'][0]; 
    
}
//apres avoir validé une img
if(isset($_POST['resized']) && $_POST['Title']==''){
        array_shift($_SESSION['tab']);
        if(!count($_SESSION['tab'])){
            session_unset();
            $tab=scandir('../resultat/1');
            array_shift($tab);
            array_shift($tab);
            $_SESSION['page']=0;
            $_SESSION['tab']=$tab;
            $_SESSION['page']++; 
        }
        $imgVal=$_SESSION['tab'][0]; 
    }
elseif(isset($_POST['resized']) && $_POST['Title']!=''){
        $imgVal=$_SESSION['tab'][0];
        $_SESSION['page']++;
        $error=imgResize('../resultat/1/'.$imgVal,$_POST['Largeur'],$_POST['Title'],$_POST['qualite'],0,'../resultat/2/')['error'];
        //rename('../resultat/1/'.$imgVal,'../resultat/2/'.$imgVal);
        if(!$error){
            array_shift($_SESSION['tab']);
        }
        if(!count($_SESSION['tab'])){
            session_unset();
            $tab=scandir('../resultat/1');
            array_shift($tab);
            array_shift($tab);
            $_SESSION['page']=0;
            $_SESSION['tab']=$tab;
            $_SESSION['page']++; 
        }
        $imgVal=$_SESSION['tab'][0];

}else{
    if(!count($_SESSION['tab'])){
        session_unset();
        $tab=scandir('../resultat/1');
        array_shift($tab);
        array_shift($tab);
        $_SESSION['page']=0;
        $_SESSION['tab']=$tab;
        $_SESSION['page']++; 
    }
    $imgVal=$_SESSION['tab'][0]; 
}
?>


    <div style="display:inline-block;width:25vw;min-width:250px;">
        <img src="../resultat/1/<?= $imgVal ?>" alt="" style="width:100%;height:auto;">
    </div>

    <div style="display:inline-block;">
        <form method="post" action="" enctype="multipart/form-data">
            <p>
                <label for="titre">Titre :</label>
                <input type="text" name="Title" id="titre" />
            </p>
            <p>
                <label for="Largeur">Largeur :</label>
                <input type="text" name="Largeur" id="Largeur" />
            </p>
            <p style="display:none;">
                <label for="Qualite">Qualité :</label>
                <input type="text" name="qualite" value="60" id="Qualite" />
            </p>

            <input type="submit" name="resized" value="recupérer">
        </form>
    </div>
