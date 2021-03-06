<?php $canAdmin = $_SESSION['rang']>3 || !isset($activite['createur']) || ($_SESSION['rang']>2 && $activite['createur']==$_SESSION['id']); ?>
<section id="information">
    <h2>Activité :
        <span class="ed" id="titleActivity"><?= $activite['titre'] ?></span>
    </h2>
    <div>activité n°:<span id="idActivity"><?=$activite['id'] ?></span></div>
    <?php if($canAdmin){ ?>
    <span class="btnAct">lancement le<input type="date" id='dateStart' value='<?= $activite['dateDebut'] ?>'> - Jusqu'au <input type="date" id='dateEnd' value='<?= $activite['dateFin'] ?>'></span>
    <?php } ?>
    <input type="hidden" id="createurId" value="<?=(!isset($activite['createur']))?$_SESSION['id']:$activite['createur']; ?>">
    <div class="description">
        <h4>
            Description
        </h4>
        <?php if($canAdmin){ ?>
        <span class="btnAct">source de l'image : <input type="text" id="imgActivity" value="<?= $activite['imgDescription'] ?>"></span>
        <?php } ?>
        <a href="<?= $activite['imgDescription'] ?>" target="_blank"><img class="img-thumbnail rounded float-l"  src="<?= $activite['imgDescription'] ?>" id="imgActivityResult"></a>
        <div id="descriptionActivity">
            <p class="ed">
                <?= $activite['description'] ?>
            </p>
        </div>
    </div>
    <div class="card-info">
        <div class="regle">
            <h5>Règles</h5>
            <ol class="ed" id="ruleActivity">
                <?= $activite['regles'] ?>
            </ol>
        </div>
        <div class="duree">
            <h5>Durée</h5>
            <ul class="ed" id="timeActivity">
                <?= $activite['duree'] ?>
            </ul>
        </div>
        <div class="prerequis">
            <h5>Prérequis</h5>
            <ol class="ed" id="requestActivity">
                <?= $activite['prerequis'] ?>
            </ol>
        </div>
    </div>
</section>
<?php if(@$activite['dateFin'] > date('Y-m-d') && $_SESSION['rang']>1){ ?>
<section id="action" class="text-center">
    <button class=" btn-round btn btn-success text-center d-sm-none participe">V</button>
    <button class=" btn-round btn btn-warning text-center d-sm-none dontParticipe">X</button>
    <button class="btn btn-success text-center d-none d-sm-block participe">Je participe</button>
    <button class="btn btn-warning text-center d-none d-sm-block dontParticipe">Je ne participe pas</button>
</section>
<?php } ?>
<hr>
<section id="participants">
    <h3>Les participants</h3>
    <table class="table table-striped">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Pseudo</th>
                <th scope="col">#GW2</th>
                <th scope="col" class="d-none d-sm-block">Participation ?</th>
                <th scope="col" class="d-sm-none">Part.?</th>
            </tr>
        </thead>
        <tbody>
            <?php if(@$participants){
            foreach($participants as $k=>$infoParticipant) { ?>
            <tr>
                <th scope="row">
                    <?= $infoParticipant['pseudo'] ?>
                </th>
                <td>
                    <?= $infoParticipant['compte'] ?>
                </td>
                <td>
                    <?= ($infoParticipant['participant'])?'oui':'non' ?>
                </td>
            </tr>
            <?php }} ; ?>
        </tbody>
    </table>
</section>
