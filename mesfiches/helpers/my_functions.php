<?php


/**
* crée une image retaillé et envoie ses informations
*
*@param files $imgInput
*   image de départ
*@param int $size
*   taille d'un coté fixé en px
*@param string $title
*   titre du nouveau fichier
*
*@return string|string|int|int|int|bool
*   l'adresse de sortie|mime|qualité|largeur|hauteur|sii il y a une erreur
**/
function imgResize($imgInput,$size,$title=null,$quality=100,$dimType=0,$imgOutput=null){
                    $ImageChoisie = imagecreatefromjpeg($imgInput);
    
                    $TailleImageChoisie = getimagesize($imgInput);
                    $NouvelleLargeur = 0;
                    $NouvelleHauteur = 0;
                    
                if($dimType==0){
                    $NouvelleLargeur = $size;
                    $NouvelleHauteur = floor( ($TailleImageChoisie[1] * (($NouvelleLargeur)/$TailleImageChoisie[0])) );
                }   
                else{
                    $NouvelleHauteur = $size;
                    $NouvelleLargeur = floor( ($TailleImageChoisie[0] * (($NouvelleHauteur)/$TailleImageChoisie[1])) );
                }    
                $NouvelleImage = imagecreatetruecolor($NouvelleLargeur , $NouvelleHauteur) or die ("Erreur");
                imagecopyresampled($NouvelleImage , $ImageChoisie  , 0,0, 0,0, $NouvelleLargeur, $NouvelleHauteur, $TailleImageChoisie[0],$TailleImageChoisie[1]);
                $src="";
                if($imgOutput){
                    $src=$imgOutput;
                }
                $src.=$title.'-'.$NouvelleLargeur.'x'.$NouvelleHauteur.'_'.$quality.'.jpg';
                imagejpeg($NouvelleImage , $src , $quality);
                return array('src'=>$src,'mime'=>'jpg','quality'=>$quality,'width'=> $NouvelleLargeur,'height'=> $NouvelleHauteur,'error'=>0,'name'=>$title);}
    
   
function check_file_uploaded_name ($filename)
{
    return ((preg_match("`^[-0-9A-z-À-ÿ_\.]+$`i",$filename)) ? true : false);
}
function check_file_uploaded_length ($filename)
{
    return ((mb_strlen($filename,"UTF-8") > 225) ? true : false);
}
  
/*
* Upload d'image
*@input $files: => $_FILES['...']; $destination: lieu de deposition du fichier
*
*
**/
function upload($files,$destination=''){
        if(isset($files)){
            foreach($files['tmp_name'] as $k=>$v){
                if(is_uploaded_file($files['tmp_name'][$k])){
                    $filename=$files['tmp_name'][$k];
                    $name=$files['name'][$k];
                    (check_file_uploaded_name ($filename));
                    (check_file_uploaded_length ($filename));
                    move_uploaded_file($filename,$destination.$name);
                }
            } 
        }
    return true;
    }

?>
