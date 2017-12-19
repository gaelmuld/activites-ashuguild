<section id="information">
    <h2>Choix des activités
    </h2>
    <section class="selection">
        <?php foreach ($activites as $activite){?>

        <a href="<?= base_url().'control/activite/'.$activite['id'] ?>" class="<?=($activite['dateFin'] > date('Y-m-d'))?'active':'finished' ?> overview active" style="background-image:url(
        <?=$activite['imgDescription'] ?>)">
            <h5>
                <?= $activite['titre']?>
            </h5>
        </a>
        <?php } ?>
    </section>
