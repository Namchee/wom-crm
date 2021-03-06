<link rel="stylesheet" href="view/resources/styles/modify_client_cs.css">
<script src="view/resources/js/search_region.js" defer></script>

            <h1 class="heading">
                Search Region
            </h1>
            <div class="columns">
                <div class="column">
                    Region
                </div>
                <div class="column">
                    <select id="region">
                        <option data-placeholder="true"></option>
                        <?php foreach ($regions as $region): ?>
                            <option value="<?= $region->id ?>"><?= $region->nama ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>
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
                                <div class="column" id="client-pj">
                                    
                                </div>
                            </div>
                    </div>
                </div>
            </div>
