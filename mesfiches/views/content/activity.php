<section id="information">
    <h2>Activité mensuelle en cours :
        <span class="normal ed" id="titleActivity"><?= $activite['titre'] ?></span>
    </h2>
    <div>activité n°:<span id="idActivity"><?=$activite['id'] ?></span></div>
    <?php if($_SESSION['rang']>2){ ?>
    <span class="btnAct">lancement le<input type="date" id='dateStart' value='<?= $activite['dateDebut'] ?>'> - Jusqu'au <input type="date" id='dateEnd' value='<?= $activite['dateFin'] ?>'></span>
    <?php } ?>
    <div class="description">
        <h4>
            <p>Description</p>
        </h4>
        <?php if($_SESSION['rang']>2){ ?>
        <span class="btnAct">source de l'image : <input type="text" id="imgActivity" value="<?= $activite['imgDescription'] ?>"></span>
        <?php } ?>
        <a href="<?= $activite['imgDescription'] ?>" target="_blank"><img class="img-thumbnail rounded float-l" width='300' height='250' src="<?= $activite['imgDescription'] ?>" id="imgActivityResult"></a>
        <p class="ed" id="descriptionActivity">
            <?= $activite['description'] ?>
        </p>
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
<?php if(isset($activite['dateFin']) && $activite['dateFin'] > date('Y-m-d')){ ?>
<section id="action" class="text-center">
    <button class="btn btn-success text-center" id="participe">Je participe</button>
    <button class="btn btn-warning text-center" id="dontParticipe">Je ne participe pas</button>
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
                <th scope="col">Participation ?</th>
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
                    <?= $infoParticipant['participant'] ?>
                </td>
            </tr>
            <?php }} ; ?>
        </tbody>
    </table>
</section>
