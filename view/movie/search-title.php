<?php
namespace Anax\View;

?>
<form method="get">
    <fieldset>
    <legend>Search</legend>
    <input type="hidden" name="route" value="search-title">
    <p>
        <label>Title (use % as wildcard):
            <input type="search" name="searchTitle" value=""/>
        </label>
    </p>
    <p>
        <input type="submit" name="doSearch" value="Search">
    </p>
    <p><a href="<?= url("movie/show")  ?>">Show all</a></p>
    </fieldset>
</form>
