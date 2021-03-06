<?php $idx = 1 ?>

<link rel="stylesheet" href="view/resources/styles/modify_client_cs.css">
<script src="view/resources/js/modify_client_cs.js" defer></script>

            <h1 class="heading">
                Ubah Penanggung Jawab Klien
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
                        <form action="" class="client-form">
                            <div class="columns">
                                <div class="column">
                                    Nama Klien
                                </div>
                                <div class="column" id="client-name">
                                    
                                </div>
                            </div>
                            <div class="columns">
                                <div class="column">
                                    Status Kawin
                                </div>
                                <div class="column" id="client-marriage">
                                    
                                </div>
                            </div>
                            <div class="columns">
                                <div class="column">
                                    Tanggal Lahir
                                </div>
                                <div class="column" id="client-date">

                                </div>
                            </div>
                            <div class="columns">
                                <div class="column">
                                    Nilai Investasi
                                </div>
                                <div class="column" id="client-price">
                                
                                </div>
                            </div>
                            <div class="columns">
                                <div class="column">
                                    Kota
                                </div>
                                <div class="column" id="client-kota">
                                
                                </div>
                            </div>
                            <div class="columns">
                                <div class="column">
                                    Gender
                                </div>
                                <div class="column" id="client-gender">
                                
                                </div>
                            </div>
                            <div class="columns">
                                <div class="column">
                                    Umur
                                </div>
                                <div class="column" id="client-umur">

                                </div>
                            </div>
                            <div class="columns">
                                <div class="column">
                                    Penanggung Jawab
                                </div>
                                <div class="column">
                                    <select name="cs" id="cs" class="cs">
                                        <!-- php -->
                                        <?php foreach ($cs as $value): ?>
                                            <option value="<?= $value->id ?>"><?= $value->name ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                            <button class="button button-primary icon-left" type="submit">
                                <i class="material-icons">build</i>
                                <span>Simpan Perubahan</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
