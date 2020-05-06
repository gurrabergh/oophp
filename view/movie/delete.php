<?php
namespace Anax\View;

?>
<form method="post" action="<?= url("movie/delete") ?>">
    <fieldset>
    <legend>Delete</legend>
    <input type="hidden" name="movieId" value="<?= $movie->id ?>"/ >

    <p>
        <label>Title:<br>
        <input type="text" name="movieTitle" value="<?= $movie->title ?>"/readonly>
        </label>
    </p>

    <p>
        <label>Year:<br>
        <input type="number" name="movieYear" value="<?= $movie->year ?>"/readonly>
    </p>

    <p>
        <label>Image:<br>
        <input type="text" name="movieImage" value="<?= $movie->image ?>"/readonly>
        </label>
    </p>

    <p>
        <input type="submit" name="doDelete" value="Delete">
    </p>
    <p><a href="<?= url("movie/show") ?>">Back</a></p>
    </fieldset>
</form>
