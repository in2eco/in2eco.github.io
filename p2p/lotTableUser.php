<h1><?= findNameFromUsername($_GET["username"])?></h1>
<form id="logout-form" action="server/logout.php" method="POST">
  <button type="submit" class="logout-button">Logout</button>
</form>
<br>
<?php include 'contact.php';?>

<?php include 'location.php'?>
<hr>
<div id="lot-container">
<h2>Library of Things</h2>
<table id="lotTable" class="display">
    <thead>
        <tr>
            <?php
              $lotKeys = findKeysOfLotDatabase();
              foreach ($lotKeys as $lotKey): ?>
              <th class="<?=$lotKey?>" ><?= (ucfirst($lotKey)) ?></th>
            <?php endforeach; ?>
            <th></th>
        </tr>
    </thead>
</table>
<!-- FORM FOR ADDING, EDITING LOT ITEM -->
<div id="formModal" style="display:none;">
    <form id="dataForm" method="POST">
        <input type="hidden" name="id" id="id">
        <input type="hidden" name="action" id="action">
        <?php foreach ($lotKeys as $lotKey): ?>
            <?php if ($lotKey !== 'id' && $lotKey !== 'username'): ?>
                <label><?= ucfirst($lotKey) ?>: <input type="text" name="<?= $lotKey ?>" id="<?= $lotKey ?>" required></label>
            <?php endif; ?>
            <?php if ($lotKey === 'username'): ?>
                <input type="hidden" name="<?= $lotKey ?>" id="<?= $lotKey ?>" value="<?= $_GET['username']?>">
            <?php endif; ?>
        <?php endforeach; ?>
        <br>
        <button type="submit">Save</button>
        <button type="button" onclick="hideForm()">Cancel</button>
    </form>
</div>


<button onclick="showAddForm()">Add New Item</button>
</div>

<script>
$(document).ready(function() {
    var url = "server/fetchLotUser.php?username=" + "<?=$_GET['username']?>";
    $('#lotTable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
          "url": url
        },
        "createdRow": function(row, data, dataIndex) {
            $('td', row).eq(0).addClass('id');
            $('td', row).eq(1).addClass('username');
            $('td', row).eq(2).addClass('item');
        },
       "lengthMenu": [ 5, 10, 25, 50, 100 ],
       "pageLength": 5,
        "columns": [
            { "data": "id" },
            { "data": "username" },
            { "data": "item"},
            { "data": "action"}
        ],
        "columnDefs": [
            {
                "targets": [0,1,3], // Column index for contact
                "orderable": false // Optional: Disable sorting for this column if necessary
            },
            {
              "targets": [],
              "visible": false
            }
        ]
    });
});
// SHOW THE ADD LOT ITEM FORM
function showAddForm() {
    $('#action').val('add');
    $('#id').val('');
    <?php foreach ($lotKeys as $lotKey): ?>
        <?php if ($lotKey !== 'id' && $lotKey !== 'username'): ?>
            $('#<?= $lotKey ?>').val('');
        <?php endif; ?>
    <?php endforeach; ?>
    $('#formModal').show();
}

// SHOW THE EDIT LOT ITEM FORM
function editData(row) {
    $('#action').val('edit');
    $('#id').val(row.id);
    // console.log(row.id);
    <?php foreach ($lotKeys as $lotKey): ?>
        <?php if ($lotKey !== 'id'): ?>
            $('#<?= $lotKey ?>').val(row['<?= $lotKey ?>']);
        <?php endif; ?>
    <?php endforeach; ?>
    $('#formModal').show();
}

// DELETE LOT ITEM
function deleteData(id) {
    if (confirm('Are you sure you want to delete this entry?')) {
        $('<form>', {
            'method': 'POST',
            'html': '<input type="hidden" name="id" value="' + id + '"><input type="hidden" name="action" value="delete">'
        }).appendTo(document.body).submit();
    }
}

// HIDE FORM
function hideForm() {
    $('#formModal').hide();
}
</script>
<hr>
