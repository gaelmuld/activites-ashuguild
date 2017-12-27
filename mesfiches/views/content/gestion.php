<?php var_dump($_POST); ?>
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
                <?php if(@$joueurs){
            foreach($joueurs as $k=>$infoJoueur) { ?>
                <tr>
                    <input type="hidden" value="<?= $infoJoueur['id'] ?>" name="id[]">
                    <th scope="row" width="48%">
                        <?= $infoJoueur['pseudo'] ?>
                    </th>
                    <td width="48%">
                        <?= $infoJoueur['compte'] ?>
                    </td>
                    <td>
                        <select name="rang[]" id="">
                            <option value="<?= $infoJoueur['rang'] ?>"><?= $infoJoueur['rang'] ?></option>
                            <option value="" disabled>------</option>
                            <option value="admin">admin</option>
                            <option value="organisateur">organisateur</option>
                            <option value="participant">participant</option>
                       </select>
                    </td>
                </tr>
                <?php }} ; ?>

            </tbody>
        </table>
        <input type="submit" class="btn btn-success btn-lg">
    </form>
</section>
