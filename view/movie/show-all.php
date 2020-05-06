<?php
namespace Anax\View;

if (!$res) {
    return;
}
?>

<table>
    <tr class="first">
        <th>Rad</th>
        <th>Id</th>
        <th>Bild</th>
        <th>Titel</th>
        <th>År</th>
        <th>Uppdatera</th>
        <th>Radera</th>
    </tr>
<?php $id = -1; foreach ($res as $row) :
    $id++; ?>
    <tr>
        <td><?= $id ?></td>
        <td><?= $row->id ?></td>
        <td><img class="thumb" src="../<?= $row->image ?>"></td>
        <td><?= $row->title ?></td>
        <td><?= $row->year ?></td>
        <th><a href="<?= url("movie/edit?id=$row->id") ?>">&#9998;</a></th>
        <th><a href="<?= url("movie/delete?id=$row->id") ?>">&#10060;</a></th>
    </tr>
<?php endforeach; ?>
</table>
<p><a href="<?= url("movie/create")  ?>">Lägg till ny film</a></p>
