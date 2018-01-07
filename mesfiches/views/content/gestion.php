<section id="ListeJoueurs">
    <h3>Les Dachis</h3>
    <form action="./gestionAction" method="post">
        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Pseudo</th>
                    <th scope="col">#GW2</th>
                    <th scope="col">Rang</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($joueurs as $k=>$infoJoueur) { ?>
                <tr>
                    <input type="hidden" value="<?= $infoJoueur['id'] ?>" name="id[]">
                    <th scope="row" width="48%">
                        <?= $infoJoueur['pseudo'] ?>
                    </th>
                    <td width="48%">
                        <?= $infoJoueur['compte'] ?>
                    </td>
                    <td>
                        <?php if($infoJoueur['rang'] < $_SESSION['rang']){ ?>
                        <select name="rang[]" id="">
                            <?php for($i=1;$i<=$_SESSION['rang'];$i++){?>
                            <option value="<?= $i ?>" 
                            <?= ($infoJoueur['rang']==$i)?'selected':''; ?>
                            ><?= $this->M_dachis->getRank($i) ?></option>
                            <?php } ?>
                       </select>
                        <?php }else{ 
                            echo $this->M_dachis->getRank($infoJoueur['rang']); ?>
                        <input type="hidden" value="<?= $infoJoueur['rang'] ?>" name="rang[]">
                        <?php } ?>
                    </td>
                </tr>
                <?php }; ?>

            </tbody>
        </table>
        <input type="submit" class="btn btn-success btn-lg">
    </form>
</section>
