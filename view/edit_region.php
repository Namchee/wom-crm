<?php $idx = 1 ?>

<link rel="stylesheet" href="view/resources/styles/edit_region.css">
<script src="view/resources/js/edit_region.js" defer></script>

            <h1 class="heading">
                Ubah Region
            </h1>
            <table id="region">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Region</th>
                        <th>Jumlah Kota</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($regions as $key=>$value) : ?>
                        <tr>
                            <td>
                                <?= $idx++ ?>
                            </td>
                            <td id="reg-real-name">
                                <?= $value->nama ?>
                            </td>
                            <td>
                                <?= $value->jumlah ?>
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
                            Region
                            <span id="reg-name-head">
                        </h1>
                        <form action="" class="regioner">
                            <div class="columns">
                                <div class="column">
                                    Nama Region
                                </div>
                                <div class="column" id="reg-name">
                                    
                                </div>
                            </div>
                            <div class="columns">
                                <div class="column">
                                    Daftar Kota
                                </div>
                                <div class="column">
                                    <select name="" id="city" multiple>
                                        <?php foreach ($kotas as $key=>$value): ?>
                                            <option value="<?= $value->id ?>">
                                                <?= $value->nama ?>
                                            </option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                            <button class="button button-primary icon-left" type="submit">
                                <i class="material-icons">location_city</i>
                                <span>Simpan Perubahan</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
