
    <link rel="stylesheet" href="view/resources/styles/add_client.css">
    <script src="view/resources/js/add_client.js" defer></script>

            <h1 class="heading">
                Tambah Klien
            </h1>
            <form action="" method="POST">
                <div class="columns">
                    <div class="column">
                        <div class="input-group">
                            <input type="text" name="namaKlien" id="nama" class="input-field" autocomplete="off" required />
                            <span class="input-bar"></span>
                            <span class="input-highlight"></span>
                            <label class="input-label">Nama Klien</label>
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
                    <div class="column photo">
                        Foto Klien
                    </div>
                    <div class="column">
                        <input type="file" id="file-hide" accept="image/*" />
                        <div class="columns">
                            <div class="column">
                                <label for="file-hide" class="button button-primary">
                                    Upload Foto
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="columns">
                    <div class="column">
                        <button class="button button-primary icon-left" type="submit" ripple>
                            <i class="material-icons">person_add</i>
                            <span>Tambah Klien</span>
                        </button>
                    </div>
                </div>
            </form>