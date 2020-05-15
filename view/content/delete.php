<?php
namespace Anax\View;

?>
<form method="post">
    <fieldset>
    <legend>Edit</legend>
    <input type="hidden" name="contentId" value="<?= esc($content->id) ?>"/>

    <p>
        <label>Title:<br>
        <input type="text" name="contentTitle" value="<?= esc($content->title) ?>"/>
        </label>
    </p>

    <p>
        <label>Path:<br>
        <input type="text" name="contentPath" readonly value="<?= esc($content->path) ?>"/>
    </p>

    <p>
        <label>Slug:<br>
        <input type="text" name="contentSlug" readonly value="<?= esc($content->slug) ?>"/>
    </p>

    <p>
        <label>Text:<br>
        <textarea name="contentData" readonly><?= esc($content->data) ?></textarea>
     </p>

     <p>
         <label>Type:<br>
         <input type="text" name="contentType" readonly value="<?= esc($content->type) ?>"/>
     </p>

     <p>
         <label>Filter:<br>
         <input type="text" name="contentFilter" readonly value="<?= esc($content->filter) ?>"/>
     </p>

     <p>
         <label>Publish:<br>
         <input type="datetime" name="contentPublish" readonly value="<?= esc($content->published) ?>"/>
     </p>
          <p>Är du säker på att du vill radera innehållet?</p>
    <p>
        <button type="submit" name="doDelete"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
    </p>
    <a href="<?= url("content/admin") ?>">Tillbaka</a>
    </fieldset>
</form>
