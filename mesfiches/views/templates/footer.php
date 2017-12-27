<?php if(@$_SESSION['rang']=='admin' || @$_SESSION['rang']=='organisateur' ){ ?>

<script src='<?= js_url("gestion") ?>'></script>

<?php } if(@$vue =='activity'){ ?>
<script src='<?= js_url("participation") ?>'></script>
<?php } ?>
</body>

</html>
