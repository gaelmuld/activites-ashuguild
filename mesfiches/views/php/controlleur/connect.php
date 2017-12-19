<?php
spl_autoload_register(function ($class) {
    include '../classes/'.$class . '.class.php';
});
session_start();

function back() { echo '
    <script>
        (setTimeout(function() {
            history.back();
        }, 2500))();

    </script>';
    }
    
    
$DB = new Dbact;
$table = 'dachis';
if(isset($_POST['connexion'])){
    //connexion d'un compte
    $pseudo = $_POST['pseudo'];
    $mdp = md5($_POST['mdp']);
    $infoConnect=[
        "pseudo" => $pseudo,
        "mdp" => $mdp
    ];
    if($result=$DB->getWhere($table,$infoConnect)){
        $_SESSION=[
            'pseudo'=>$result[0]['pseudo'],
            'compte'=>$result[0]['compte'],
            'rang'=>$result[0]['rang'],
            'id'=>$result[0]['id'],
        ];
        
        header('Location:../../page/selection.php');
    }else{
        echo 'Mauvais pseudo/mot de passe';
        back();
    }
    
}


else if(isset($_POST['creation'])){
    
    // création ou récupération de compte
    $pseudo = $_POST['pseudo'];
    $mdp = md5($_POST['mdp']);
    $api = $_POST['apiKey'];
    
    $getApi= new apiGw2;
    $account = $getApi->getMembreNameAccount($api);
    
    $infoConnect=[
        "pseudo" => $pseudo,
        "mdp" => $mdp
    ];
    
    // déjà inscrit
    $result=$DB->getWhere($table,$infoConnect);
    $result=($result)?$result[0]:null;
    $infoConnect["apiGw2"] = $api;
    
    
    if($result['pseudo'] == $pseudo && $result['mdp'] == $mdp && $account['name'] == $result['compte']){
        //mise à jour de l'api
        $DB->updateApi($result['compte'],$api);
        echo 'Api changé';
        back();
        
    }else{
        // nouveau inscrit  
        $option["pseudo"]=$pseudo;
        $option["apiGw2"]=$api;
        //pret pour ce connecter à l'api
        
        if($DB->getWhere($table,$option)){
            //pour changer de mot de passe
            $DB->updateMdp($api,$mdp);
            echo 'Mot de passe changé';
            back();
        }else if($DB->getWhere($table,'pseudo = "'.$pseudo.'"')){
            //si pseudo déjà pris
            echo 'pseudo déjà pris';
            back();
        }else{
            //nouveau confirmé
            $getApi= new apiGw2;
            if($account){
                $infoConnect['compte']=$account['name'];
                if($DB->getWhere($table,'apiGw2 = "'.$api.'"')){
                //si api déjà existant
                  $DB->updateMdp($api,$mdp);
                  $DB->updatePseudo($api,$pseudo);
                }
                $DB->insert($table,$infoConnect);
                echo 'pseudo et mot de passe changé';
                back();;
            }else{
                //si api incorrecte
                echo "Api Incorrecte";
                back();
            }
        }
    }
}
