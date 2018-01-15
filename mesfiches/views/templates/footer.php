<?php if(@$_SESSION['rang']>0){ ?>

<script src='<?= js_url("gestion") ?>'></script>

<?php  if(@$vue =='activity'){ ?>
<script src='<?= js_url("participation") ?>'></script>
<?php }} ?>
</body>

</html>
