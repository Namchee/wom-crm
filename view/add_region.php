<link rel="stylesheet" href="view/resources/styles/add_region.css">
<script src="view/resources/js/add_region.js" defer></script>

<h1 class="heading">
    Tambah Region
</h1>
            <form action="">
                <div class="columns">
                    <div class="column">
                        <div class="input-group">
                            <input type="text" name="namaRegion" id="namaRegion" class="input-field" autocomplete="off" required />
                            <span class="input-highlight"></span>
                            <span class="input-bar"></span>
                            <label class="input-label">Nama Region</label>
                        </div>
                    </div>
                </div>
                <div class="columns">
                    <div class="column">
                        <select name="kotas" id="kotas" class="kotas" multiple>
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
                            <span>Tambah Region</span>
                        </button>
                    </div>
                </div>
            </form>