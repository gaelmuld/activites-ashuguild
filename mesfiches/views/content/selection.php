<section id="information">
    <h2>Choix des activités
    </h2>
    <?php if(isset($_SESSION['message'])){ ?>
    <h3 id='message'>
        <?= @$_SESSION['message']?>
    </h3>
    <?php } ?>
    <section class="selection">
        <?php foreach ($activites as $activite){?>

        <a href="<?= base_url().'control/activite/'.$activite['id'] ?>" class="
        <?=($activite['dateFin'] >= date('Y-m-d'))?'active':'finished' //en cours ou fini?>
        <?=(@$activite['createur'] === $_SESSION['id'])?'created':'' //createur ou non?>
        overview active" style="background-image:url(
        <?=$activite['imgDescription'] ?>);>">
            <h3>
                <?= $activite['titre']?>
            </h3>
        </a>
        <?php } ?>
    </section>

    <script>
        $('#message').delay(1500).fadeOut(1300);
        $('#newForm').hide();
        $('.switchInscription').click(function() {
            $('#newForm').toggle();
            $('#connexionForm').toggle();
        });

    </script>
