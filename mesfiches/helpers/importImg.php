<form method="post" action="" enctype="multipart/form-data">

    <p>
        <label for="image">Image : </label>
        <input type="hidden" name="MAX_FILE_SIZE" value="33554432" />
        <input type="file" name="img[]" id="image" accept="image/jpeg" multiple />
    </p>

    <input type="submit" name="resized" value="recupérer">
</form>


<?php
include 'my_functions.php';
!isset($_FILES['img'])?:upload($_FILES['img'],$destination='../resultat/1/');

?>
