<?php if($_SESSION['rang']=='admin' ){ ?>
<div class="btnMod">
    <?php if($vue =='selection')  {?>

    <a href="<?=base_url().'control/newActivity' ?>" class="btn btn-info" id='btnCreer' value='creer'>Créer</a>

    <?php } if($vue =='activity') {?>

    <button class="btn btn-info" id='btnModif' value='modif'>Modifier</button>

    <a href="<?=base_url().'control/activityDelete/'.$activite['id'] ?>" class="btn btn-danger" id='btnModif' value='modif'>Supprimer</a>

    <?php } ?>
</div>
<div class="btnAct">
    <button class="btn btn-info" id='btnValid' value='valider'>Valider</button>
    <button class="btn btn-info" id='btnAnnule' value='annuler'>Annuler</button>
</div>
<?php }?>
