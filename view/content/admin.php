<?php
namespace Anax\View;

if (!$res) {
    return;
}
?>

<table>
    <tr class="first">
        <th>Id</th>
        <th>Title</th>
        <th>Type</th>
        <th>Path</th>
        <th>Slug</th>
        <th>Published</th>
        <th>Created</th>
        <th>Updated</th>
        <th>Deleted</th>
        <th>Actions</th>
    </tr>
<?php $id = -1; foreach ($res as $row) :
    $id++; ?>
    <tr>
        <td><?= $row->id ?></td>
        <td><?= $row->title ?></td>
        <td><?= $row->type ?></td>
        <td><?= $row->path ?></td>
        <td><?= $row->slug ?></td>
        <td><?= $row->published ?></td>
        <td><?= $row->created ?></td>
        <td><?= $row->updated ?></td>
        <td><?= $row->deleted ?></td>
        <th>
            <a href="<?= url("content/edit?id=$row->id") ?>">&#9998;</a>
            <a href="<?= url("content/delete?id=$row->id") ?>">&#10060;</a>
        </th>
    </tr>
<?php endforeach; ?>
</table>
<a href="<?= url("content/create") ?>">Skapa nytt content</a>
