<?php
namespace Anax\View;

?>
<form method="post" action="<?= url("movie/edit") ?>">
    <fieldset>
    <legend>Edit</legend>
    <input type="hidden" name="movieId" value="<?= $movie->id ?>"/>

    <p>
        <label>Title:<br>
        <input type="text" name="movieTitle" value="<?= $movie->title ?>"/>
        </label>
    </p>

    <p>
        <label>Year:<br>
        <input type="number" name="movieYear" value="<?= $movie->year ?>"/>
    </p>

    <p>
        <label>Image:<br>
        <input type="text" name="movieImage" value="<?= $movie->image ?>"/>
        </label>
    </p>

    <p>
        <input type="submit" name="doSave" value="Save">
    </p>
    <p><a href="<?= url("movie/show") ?>">Back</a></p>
    </fieldset>
</form>
