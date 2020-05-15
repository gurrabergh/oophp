<?php
namespace Anax\View;

?>
<form method="post">
    <fieldset>
    <legend>Create</legend>

    <p>
        <label>Title:<br>
        <input type="text" name="contentTitle" default="A Title"/>
        </label>
    </p>

    <p>
        <button type="submit" name="doCreate"><i class="fa fa-plus" aria-hidden="true"></i> Create</button>
    </p>
        <a href="<?= url("content/admin") ?>">Tillbaka</a>
    </fieldset>
</form>
