<link rel="stylesheet" href="view/resources/styles/dashboard_admin.css">
<script src="view/resources/js/dashboard_admin.js" defer></script>
<?php $idx = 1; ?>

<h1 class="heading">
    Admin Dashboard
</h1>
<table id="cs">
    <thead>
        <tr>
            <th>No</th>
            <th>Username</th>   
            <th>Nama Lengkap</th>
            <th>Tanggal Gabung</th>
        </tr>  
    </thead>
    <tbody>
        <h1 class="table-head">
            Daftar Customer Service
        </h1>
        <?php foreach ($result as $key=>$value): ?>
            <tr>
                <td>
                    <?= $idx++ ?>
                </td>
                <td class="table-username">
                    <?= $value->username ?>
                </td>
                <td class="table-name">
                    <?= $value->name ?>
                </td>
                <td class="table-join">
                    <?= $value->tanggalGabung ?>
                </td>
                <td class="hide-id">
                    <?= $value->id ?>
                </td>
            </tr>
        <?php endforeach ?>    
    </tbody>
</table>

<div id="modal-info" class="modal">
        <input type="checkbox" id="modal-close" />
        <label for="modal-close" class="modal-overlay"></label>
        <label for="modal-close" class="modal-close-button">
            <i class="material-icons">
                cancel
            </i>
        </label>
        <div class="modal-items client-info">
            <div class="modal-content">
                <div class="columns">
                    <div class="column">
                        <div class="media media-modal">
                            <div class="media-content">
                                <h1 class="heading">
                                    Profile Customer Service
                                </h1>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="columns">
                    <div class="column">
                        ID
                    </div>
                    <div class="column cs-id">
                    </div>
                </div>
                <div class="columns">
                    <div class="column">
                        Nama Lengkap
                    </div>
                    <div class="column cs-name">
                    </div>
                </div>
                <div class="columns">
                    <div class="column">
                        Username
                    </div>
                    <div class="column cs-username">
                    </div>
                </div>
                <div class="columns">
                    <div class="column">
                        Tanggal Gabung
                    </div>
                    <div class="column cs-join">
                    </div>
                </div>
            </div>
        </div>
    </div>