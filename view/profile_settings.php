<link rel="stylesheet" href="view/resources/styles/profile_settings.css">
<script src="view/resources/profile_settings.js" defer></script> 

<h1 class="heading">
                Pengaturan Profil
            </h1>
            <form action="" method="POST" id="edit-profile">
                <div class="columns">
                    <div class="column">
                        <div class="input-group">
                            <input type="text" name="username" class="input-field" autocomplete="off" required disabled />
                            <span class="input-highlight"></span>
                            <span class="input-bar"></span>
                            <label class="input-label">Username</label>
                        </div>
                    </div>
                </div>
                <div class="columns">
                    <div class="column">
                        <div class="input-group">
                            <input type="password" name="password" class="input-field" autocomplete="off" required
                                password-reveal />
                            <span class="input-highlight"></span>
                            <span class="input-bar"></span>
                            <label class="input-label">Old Password</label>
                        </div>
                    </div>
                </div>
                <div class="columns">
                    <div class="column">
                        <div class="input-group">
                            <input type="password" name="password" class="input-field" autocomplete="off"
                                password-reveal />
                            <span class="input-highlight"></span>
                            <span class="input-bar"></span>
                            <label class="input-label">New Password</label>
                        </div>
                    </div>
                </div>
                <hr />
                <div class="columns">
                    <div class="column">
                        <div class="input-group">
                            <input type="text" name="nama" class="input-field" autocomplete="off" required />
                            <span class="input-highlight"></span>
                            <span class="input-bar"></span>
                            <label class="input-label">Nama Lengkap</label>
                        </div>
                    </div>
                </div>
                <div class="columns">
                    <div class="column">
                        <div class="input-group">
                            <input type="email" name="email" class="input-field email" placeholder="E-mail" />
                        </div>
                    </div>
                </div>
                <div class="column">
                    <div class="column">
                        <button class="button button-primary icon-left" type="submit" ripple>
                            <i class="material-icons">build</i>
                            <span>Ubah Profil</span>
                        </button>
                    </div>
                </div>
        </form>