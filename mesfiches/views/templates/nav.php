<body>
    <header>
        <h1>Acticvité Ashuguild</h1>
        <?php if(isset($_SESSION['pseudo'],$vue) && $vue!='index') {?>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="<?= base_url().'control/selection' ?>">Activités</a>
            <button class="navbar-toggler " type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#">
                            <?= $_SESSION['pseudo'] ?>
                        </a>
                        <input type="hidden" id="pseudoConnection" value="<?= $_SESSION['pseudo'] ?>">
                    </li>

                    <?php if($_SESSION['rang']>2)// Pour l'administration des personnes. Acces:[Superviseur/organisateur/administrateur]
                    { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url().'control/gestion' ?>">gestion</a>
                    </li>

                    <?php } ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url().'control/disconnect' ?>">Se déconnecter</a>
                    </li>
                </ul>
            </div>
            <div class="gestion navbar-brand">

                <?php $this->load->view('templates/activiteGestion'); ?>

            </div>
        </nav>

        <?php } ?>

    </header>
