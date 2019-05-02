    <nav class="navbar navbar-primary">
        <input type="checkbox" id="navbar-toggle" />
        <label for="navbar-toggle" class="navbar-toggle-label">
            <div class="burger">
                <span class="line"></span>
                <span class="line"></span>
                <span class="line"></span>
            </div>
        </label>
        <header class="navbar-content">
            <div class="navbar-item navbar-item-right" id="date"></div>
        </header>
        <nav class="sidenav">
            <div class="sidenav-item sidenav-top current-user">
                <div class="media">
                    <div class="media-content">
                        <div class="media-header">
                            <?php echo $_SESSION['nama'] ?>
                        </div>
                        <p>
                            <?php if ($_SESSION['status'] == 0): ?>
                                Customer Service
                            <?php else: ?>
                                Administrator
                            <?php endif ?>
                        </p>
                    </div>
                </div>
            </div>
            <ul class="sidenav-item">
                <a class="<?php echo ($_SERVER['REQUEST_URI'] == '/dashboard') ? 'active' : '' ?>"
                    href="/dashboard">
                    <li>
                        <i class="material-icons">home</i>
                        <span>Home</span>
                    </li>
                </a>
                <?php if ($_SESSION['status'] == 0): ?>
                    <a class="<?php echo ($_SERVER['REQUEST_URI'] == '/add_client') ? 'active' : '' ?>"
                        href="/add_client">
                        <li>
                            <i class="material-icons">person_add</i>
                            <span>Add Client</span>
                        </li>
                    </a>
                <?php else: ?>
                    <a class="<?php echo ($_SERVER['REQUEST_URI'] == '/add_cs') ? 'active' : '' ?>"
                        href="/add_cs">
                        <li>
                            <i class="material-icons">person_add</i>
                            <span>Add Customer Service</span>
                        </li>
                    </a>
                <?php endif ?>
                <?php if ($_SESSION['status'] == 0): ?>
                    <a class="<?php echo ($_SERVER['REQUEST_URI'] == '/modify_client_cs') ? 'active' : '' ?>"
                        href="/modify_client_cs">
                        <li>
                            <i class="material-icons">build</i>
                            <span>Modify Client-CS</span>
                        </li>
                    </a>
                <?php else: ?>
                    <a class="<?php echo ($_SERVER['REQUEST_URI'] == '/move_client') ? 'active' : '' ?>"
                        href="/move_client">
                        <li>
                            <i class="material-icons">build</i>
                            <span>Move Client</span>
                        </li>
                    </a>
                <?php endif ?>
                <?php if ($_SESSION['status'] == 0): ?>
                    <a class="<?php echo ($_SERVER['REQUEST_URI'] == '/search_region') ? 'active' : '' ?>"
                        href="/search_region">
                        <li>
                            <i class="material-icons">public</i>
                            <span>Search Region</span>
                        </li>
                    </a>
                <?php else: ?>
                    <a class="<?php echo ($_SERVER['REQUEST_URI'] == '/add_kota') ? 'active' : '' ?>"
                        href="/add_kota">
                        <li>
                            <i class="material-icons">location_city</i>
                            <span>Add New City</span>
                        </li>
                    </a>
                <?php endif ?>
                <?php if ($_SESSION['status'] == 1): ?>
                    <a class="<?php echo ($_SERVER['REQUEST_URI'] == '/add_region') ? 'active' : '' ?>"
                        href="/add_region">
                        <li>
                            <i class="material-icons">domain</i>
                            <span>Add New Region</span>
                        </li>
                    </a>
                <?php endif ?>
                <?php if ($_SESSION['status'] == 1): ?>
                    <a class="<?php echo ($_SERVER['REQUEST_URI'] == '/edit_region') ? 'active' : '' ?>"
                        href="/edit_region">
                        <li>
                            <i class="material-icons">language</i>
                            <span>Edit Region</span>
                        </li>
                    </a>
                <?php endif ?>
                <a class="<?php echo ($_SERVER['REQUEST_URI'] == '/profile_settings') ? 'active' : '' ?>"
                    href="/profile_settings">
                    <li>
                        <i class="material-icons">settings</i>
                        <span>Profile Settings</span>
                    </li>
                </a>
            </ul>
            <div class="sidenav-item sidenav-bottom">
                <button class="button button-primary" type="button" id="logout" ripple>
                    Logout
                </button>
            </div>
        </nav>
        <label class="sidenav-mask" for="navbar-toggle"></label>
    </nav>


    <script>
        let logout = document.getElementById("logout");
        logout.addEventListener('click', () => {
            fetch('/logout', {
                method: "POST"
            }).then(() => {
                window.location.href = '/login';
            }).catch(() => {
                alert('Gagal Logout');
            })
        });
    </script>