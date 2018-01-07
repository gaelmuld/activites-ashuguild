<?php if((@$_SESSION['rang']>3 || @$activite['createur'] === @$_SESSION['id'] && @$_SESSION['rang']>2) ){ ?>

<script src='<?= js_url("gestion") ?>'></script>

<?php } if(@$vue =='activity'){ ?>
<script src='<?= js_url("participation") ?>'></script>
<?php } ?>
</body>

</html>
