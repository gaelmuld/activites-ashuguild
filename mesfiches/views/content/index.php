<section id="connexionForm">
    <h3 class="text-center">Se connecter</h3>
    <form class="form-inline" method="post" action="control/connexion">
        <input type="hidden" value="" name="connexion">
        <div class="form-group mx-sm-3">
            <label for="inputPseudo" class="sr-only">pseudo</label>
            <input type="text" class="form-control" id="inputPseudo" required name="pseudo" placeholder="pseudo">
        </div>
        <div class="form-group mx-sm-3">
            <label for="inputPass" class="sr-only">Mdp</label>
            <input type="password" class="form-control" id="inputPass" required name="mdp" placeholder="mdp">
        </div>
        <div>
            <button type="submit" class="btn btn-primary mx-3">s'identifier</button>
        </div>
    </form>
    <p class="text-center mt-5"><a href="#" class="switchInscription">pas encore inscrit ?</a></p>
</section>
<section id="newForm">
    <h3 class="text-center">Créer un accès</h3>
    <form class="form-inline" method="post" action="control/connexion">
        <input type="hidden" value="" name="creation">
        <div class="form-group mx-sm-3">
            <label for="pseudo" class="sr-only">pseudo</label>
            <input type="text" class="form-control" id="pseudo" required name="pseudo" placeholder="pseudo">
        </div>
        <div class="form-group mx-sm-3">
            <label for="apiKey" class="sr-only">Clé Api</label>
            <input type="text" class="form-control" id="apiKey" name="apiKey" required placeholder="clé api">
        </div>
        <div class="form-group mx-sm-3">
            <label for="mdp" class="sr-only">Mot de passe</label>
            <input type="password" class="form-control" id="mdp" name="mdp" required placeholder="mdp">
        </div>
        <div>
            <button type="submit" class="btn btn-primary mx-3">créer un compte</button>
        </div>
    </form>
    <p class="text-center mt-5"><a href="#" class="switchInscription">déjà inscrit ?</a></p>
</section>
<h2 id='message'>
    <?= (isset($message))?$message:''; ?>
</h2>
<script>
    $('#message').delay(1500).fadeOut(1300);
    $('#newForm').hide();
    $('.switchInscription').click(function() {
        $('#newForm').toggle();
        $('#connexionForm').toggle();
    });

</script>
