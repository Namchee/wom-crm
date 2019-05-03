<?php $idx = 1 ?>

<link rel="stylesheet" href="view/resources/styles/modify_client_cs.css">
<script src="view/resources/js/edit_client.js" defer></script>

            <h1 class="heading">
                Edit Client
            </h1>
            <table id="clients">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Client</th>
                        <th>Status Kawin</th>
                        <th>Tanggal Lahir</th>
                        <th>Nilai Investasi</th>
                        <th>Kota</th>
                        <th>Gender</th>
                        <th>Umur</th>
                        <th>Penanggung Jawab</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($clients as $value) : ?>
                       <tr>
                            <td>
                                <?= $idx++ ?>
                            </td>
                            <td>
                                <?= $value->nama ?>
                            </td>
                            <td>
                                <?php if ($value->statusKawin == 0): ?>
                                    Single
                                <?php else: ?>
                                    Married
                                <?php endif ?>
                            </td>
                            <td>
                                <?= $value->tanggalLahir ?>
                            </td>
                            <td>
                                <?= $value->nilaiInvest ?>
                            </td>
                            <td>
                                <?= $value->kota ?>
                            </td>
                            <td>
                                <?php if ($value->gender == 0): ?>
                                    Pria
                                <?php else: ?>
                                    Wanita
                                <?php endif ?>
                            </td>
                            <td>
                                <?= $value->age ?>
                            </td>
                            <td>
                                <?= $value->cs ?>
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
                        <h1 class="heading">
                            Profil Klien
                        </h1>
                        <form action="" method="POST">
                <div class="columns">
                    <div class="column">
                        <div class="input-group">
                            <input type="text" name="namaKlien" id="nama" class="input-field" 
                                autocomplete="off" required
                                pattern="[a-zA-Z]+" />
                            <span class="input-bar"></span>
                            <span class="input-highlight"></span>
                            <label class="input-label">Nama Klien</label>
                            <span class="input-message">Nama Klien hanya boleh berisi huruf</span>
                        </div>
                    </div>
                    <div class="column">
                        <select id="gender">
                            <option value="0">Pria</option>
                            <option value="1">Wanita</option>
                        </select>
                    </div>
                </div>
                <div class="columns">
                    <div class="column">
                        <select id="alamat">
                            <?php foreach ($kotas as $kota): ?>
                                <option value="<?= $kota->id ?>"><?= $kota->nama ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                <hr />
                <div class="columns">
                    <div class="column">
                        <div class="input-group icon-left">
                            <input type="text" name="date-of-birth" class="input-field date-of-birth" autocomplete="off"
                                required
                                placeholder="Tanggal Lahir" />
                            <span class="input-bar"></span>
                            <span class="input-highlight"></span>
                        </div>
                    </div>
                    <div class="column">
                        <select name="" id="marriage">
                            <option value="0">Single</option>
                            <option value="1">Married</option>
                        </select>
                    </div>
                </div>
                <hr />
                <div class="columns">
                    <div class="column">
                        <div class="input-group icon-left">
                            <input type="number" step="5000" id="nilai" class="input-field" autocomplete="off" required />
                            <span class="input-bar"></span>
                            <span class="input-highlight"></span>
                            <label class="input-label">Nilai Investasi</label>
                            <i class="material-icons left-icon">attach_money</i>
                        </div>
                    </div>
                    <div class="column">
                        &nbsp;
                    </div>
                </div>
                <div class="columns">
                    <div class="column">
                        <button class="button button-primary icon-left" type="submit" ripple>
                            <i class="material-icons">build</i>
                            <span>Ubah Informasi</span>
                        </button>
                    </div>
                    <div class="column">
                        <button class="button button-danger icon-left" type="button" id="purge" disabled ripple>
                            <i class="material-icons">delete</i>
                            <span>Hapus Klien</span>
                        </button>
                    </div>
                </div>
            </form>
                    </div>
                </div>
            </div>
