<link rel="stylesheet" href="view/resources/styles/add_kota.css">
<script src="view/resources/js/add_kota.js" defer></script>

<h1 class="heading">
    Tambah Kota
</h1>
            <form action="">
                <div class="columns">
                    <div class="column">
                        <div class="input-group">
                            <input type="text" name="namaKota" id="namaKota" class="input-field" autocomplete="off" required />
                            <span class="input-highlight"></span>
                            <span class="input-bar"></span>
                            <label class="input-label">Nama Kota</label>
                        </div>
                    </div>
                </div>
                <div class="columns">
                    <div class="column">
                        <select name="region" id="regions" class="regions" multiple>
                            <!-- php -->
                            <?php foreach ($result as $key=>$value): ?>
                                <option value="<?= $value->id ?>"><?= $value->nama ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                <div class="columns">
                    <div class="column">
                        <button class="button button-primary icon-left submit" type="submit" ripple>
                            <i class="material-icons">location_city</i>
                            <span>Tambah Kota</span>
                        </button>
                    </div>
                </div>
            </form>