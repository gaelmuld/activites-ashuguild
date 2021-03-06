<?php 
function colorSwitch($switch){
    switch ($switch){
        case 0:return "#6c6c6c";
        case 1:return "#0062ff";
        case 2:return "#008900";
        case 3:return "#f58d00";
        case 4:return "#ff45a9";
        case 5:return "#800080";
    }
    
}

?>


<section id="ListeJoueurs">
    <h3>Les Dachis</h3>
    <div class="">
        <div class="col-md-3 col-12 list-group panelJoueur text-center">
            <?php foreach($joueurs as $k=>$infoJoueur) {
            ?>
            <div style="color:<?=colorSwitch($infoJoueur['niveau']) ?>;" onclick="gestionInfo(<?= $infoJoueur['id'] ?>)" class="row list-group-item list-group-item-action">
                <div title="<?= $infoJoueur['pseudo'] ?>">
                    <?= $infoJoueur['pseudo'] ?>
                </div>
                <div class="fa fa-arrow-right"></div>
            </div>
            <?php } ?>
        </div>
        <div class="col-md-9 col-12 infoJoueur">
            <?php foreach($joueurs as $k=>$infoJoueur) {
            ?>
            <div class="d-none tableInfo" id="info-<?= $infoJoueur['id'] ?>">
                <h3 class="text-center" style="color:<?=colorSwitch($infoJoueur['niveau']) ?>;">
                    <div>
                        <?= $infoJoueur['pseudo'] ?>
                    </div>
                    <div>
                        <?= $infoJoueur['compte'] ?>
                    </div>
                </h3>
                <form action="./gestionAction" method="post">
                    <input type="hidden" value="<?= $infoJoueur['id'] ?>" name="id">
                    <input type="hidden" value="<?= $infoJoueur['rangId'] ?>" name="rang">
                    <div class="form-group row">
                        <label for="rang" class="col-form-label col-lg-3 col-md-6 col-12">Rang : </label>
                        <div class="col-lg-3 col-md-5 col-11">
                            <?php if($infoJoueur['niveau'] < $_SESSION['rang'] && $_SESSION['rang']>2){ ?>
                            <select name="rang" id="rang" class="form-control">
                              <?php foreach($this->M_dachis->getUnderRanks($_SESSION['rang']) as $rankInfo){
                                $rank = $this->M_dachis->getRank($rankInfo['id']);
                                
                                ?>
                              <option value="<?= $rankInfo['id'] ?>" <?= ($infoJoueur['rangId']==$rankInfo['id'])?'selected':''; ?>>
                                    <?= $rank['nom'] ?>
                              </option>
                              <?php } ?>
                             </select>
                            <?php }else{ 
                            ?>
                            <input style="color:<?= colorSwitch($infoJoueur['niveau']) ?>" type="text" disabled name="rang" value="<?=$this->M_dachis->getRank($infoJoueur['rangId'])['nom']?>" id="rang" class="form-control">
                            <?php } ?>
                        </div>
                        <div class="col-form-label col-lg-3 col-md-6 col-8">Rang GW2 : </div>
                        <div class="col-lg-3 col-md-6 col-4 col-form-label">
                            <?=$infoJoueur['rankGuild'] ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-form-label col-md-3 col-8"># de participation</div>
                        <div class="col-md-3 col-4 col-form-label">
                            <?= (isset($infoJoueur['countParticipation'][1]))?
                $infoJoueur['countParticipation'][1]:'0' ?>
                        </div>
                        <div class="col-form-label col-md-3 col-8"># d'activité décliné</div>
                        <div class="col-md-3 col-4 col-form-label">
                            <?= (isset($infoJoueur['countParticipation'][0]))?
                $infoJoueur['countParticipation'][0]:'0' ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-form-label col-md-3 col-8"># d'activité créée</div>
                        <div class="col-md-3 col-4 col-form-label">
                            <?=$infoJoueur['countCreaAct'] ?>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <!--
                        <div class="col-form-label col-md-3 col-8">Liste des personnages</div>
                        <div class="col-md-3 col-4 col-form-label">liste</div>
-->
                        <div class="col-form-label col-md-3 col-8">Á rejoind la guilde le : </div>
                        <div class="col-md-3 col-4 col-form-label">
                            <?= $infoJoueur['joined'] ?>
                        </div>
                    </div>
                    <?php if($this->M_dachis->getRank($infoJoueur['rangId'])['niveau'] < $_SESSION['rang'] && $_SESSION['rang']>2){ ?>
                    <input type="submit" class="btn btn-success btn col-4 offset-4">
                    <?php } ?>
                </form>
            </div>
            <?php } ?>
        </div>
    </div>
</section>
