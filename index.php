<?php
    session_start();
    require_once 'controller/services/view.php';
    require_once 'controller/userController.php';
    require_once 'controller/adminController.php';
    require_once 'controller/csController.php';

    $userController = new UserController();
    $adminController = new AdminController();
    $csController = new CsController();

    $url = $_SERVER['REQUEST_URI'];

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        if ($url == '/login') {
            if (isset($_SESSION['id'])) {
                header('Location: /dashboard');
            } else {
                echo View::renderStatic('login.html');
            }
            return;
        } else if ($url == '' || $url == '/') {
            if (isset($_SESSION['id'])) {
                header('Location: /dashboard');
            } else {
                header('Location: /login');
            }
            return;
        } else if ($url == '/dashboard') {
            if (!isset($_SESSION['id'])) {
                header('Location: /401');
                return;
            } else {
                if ($_SESSION['status'] == 0) {
                    echo $csController->viewDashboard();
                    return;
                } else {   
                    echo $adminController->viewDashboard();
                    return;
                }
            }
        } else if (preg_match('/\/get_cs\/(\d+)/', $url)) {
            if (isset($_SESSION['id'])) {
                if ($_SESSION['status'] != 1) {
                    header('Location: /403');
                } else {
                    echo $adminController->getCSById();
                    return;
                }
            } else {
                header('Location: /401');
                return;
            }
        } else if (preg_match('/\/get_region\/(\d+)/', $url)) {
            if (isset($_SESSION['id'])) {
                if ($_SESSION['status'] != 1) {
                    header('Location: /403');
                } else {
                    echo $adminController->getRegionById();
                    return;
                }
            } else {
                header('Location: /401');
                return;
            }
        } else if (preg_match('/\/get_client_mod\/(\d+)/', $url)) {
            if (isset($_SESSION['id'])) {
                if ($_SESSION['status'] != 1) {
                    header('Location: /403');
                } else {
                    echo $adminController->getClient();
                    return;
                }
            } else {
                header('Location: /401');
                return;
            }
        } else if (preg_match('/\/get_client\/(\d+)/', $url)) {
            if (isset($_SESSION['id'])) {
                if ($_SESSION['status'] != 0) {
                    header('Location: /403');
                } else {
                    echo $csController->getClient();
                    return;
                }
            } else {
                header('Location: /401');
                return;
            }
        } else if (preg_match('/\/get_client_by_region\/(\d+)/', $url)) {
            if (isset($_SESSION['id'])) {
                if ($_SESSION['status'] != 0) {
                    header('Location: /403');
                } else {
                    echo $csController->getClientByRegion();
                    return;
                }
            } else {
                header('Location: /401');
                return;
            }
        } else if ($url == '/add_cs') {
            if (isset($_SESSION['id'])) {
                if ($_SESSION['status'] != 1) {
                    header('Location: /403');
                } else {
                    echo $adminController->viewAddCS();
                    return;
                }
            } else {
                header('Location: /401');
                return;
            }
        } else if ($url == '/add_client') {
            if (isset($_SESSION['id'])) {
                if ($_SESSION['status'] != 0) {
                    header('Location: /403');
                } else {
                    echo $csController->viewAddClient();
                    return;
                }
            } else {
                header('Location: /401');
                return;
            }
        } else if ($url == '/edit_client') {
            if (isset($_SESSION['id'])) {
                if ($_SESSION['status'] != 0) {
                    header('Location: /403');
                } else {
                    echo $csController->viewEditClient();
                    return;
                }
            } else {
                header('Location: /401');
                return;
            }
        } else if ($url == '/view_report') {
            if (!isset($_SESSION['id'])) {
                header('Location: /401');
                return;
            } else {
                if ($_SESSION['status'] != 0) {
                    header('Location: /403');
                    return;
                } else {
                    echo $csController->viewReport();
                    return;
                }
            }
        } else if ($url == '/add_kota') {
            if (isset($_SESSION['id'])) {
                if ($_SESSION['status'] != 1) {
                    header('Location: /403');
                } else {
                    echo $adminController->viewAddKota();
                    return;
                }
            } else {
                header('Location: /401');
                return;
            }
        } else if ($url == '/add_region') {
            if (isset($_SESSION['id'])) {
                if ($_SESSION['status'] != 1) {
                    header('Location: /403');
                } else {
                    echo $adminController->viewAddRegion();
                    return;
                }
            } else {
                header('Location: /401');
                return;
            }
        } else if ($url == '/edit_region') {
            if (isset($_SESSION['id'])) {
                if ($_SESSION['status'] != 1) {
                    header('Location: /403');
                } else {
                    echo $adminController->viewEditRegion();
                    return;
                }
            } else {
                header('Location: /401');
                return;
            }
        } else if ($url == '/modify_client_cs') {
            if (isset($_SESSION['id'])) {
                if ($_SESSION['status'] != 1) {
                    header('Location: /403');
                } else {
                    echo $adminController->viewModifyClientCS();
                    return;
                }
            } else {
                header('Location: /401');
                return;
            }
        } else if ($url == '/profile_settings') {
            if (isset($_SESSION['id'])) {
                echo $userController->viewSelfInfo();
            } else {
                header('Location: /401');
                return;
            } 
        } else if ($url == '/search_region') {
            if (isset($_SESSION['id'])) {
                if ($_SESSION['status'] != 0) {
                    header('Location: /403');
                } else {
                    echo $csController->viewSearchRegion();
                    return;
                }
            } else {
                header('Location: /401');
                return;
            }
        } else if ($url == '/401') {
            echo View::renderStatic('401.html');
            return;
        } else if ($url == '/404') {
            echo View::renderStatic('404.html');
            return;
        } else if ($url == '/403') {
            echo View::renderStatic('403.html');
            return;
        } else {
            header('Location: /404');
            return;
        }
    } else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if ($url == '/login') {
            echo $userController->login();
            return;
        } else if ($url == '/logout') {
            $userController->logout();
            return;
        } else if ($url == '/add_cs') {
            if (!isset($_SESSION['id'])) {
                header('Location: /401');
                return;
            } else {
                if ($_SESSION['status'] != 1) {
                    header('Location: /403');
                    return;
                } else {
                    echo $adminController->addCS();
                    return;
                }
            }
        } else if ($url == '/add_kota') {
            if (!isset($_SESSION['id'])) {
                header('Location: /401');
                return;
            } else {
                if ($_SESSION['status'] != 1) {
                    header('Location: /403');
                    return;
                } else {
                    echo $adminController->addKota();
                    return;
                }
            }
        } else if ($url == '/add_region') {
            if (!isset($_SESSION['id'])) {
                header('Location: /401');
                return;
            } else {
                if ($_SESSION['status'] != 1) {
                    header('Location: /403');
                    return;
                } else {
                    echo $adminController->addRegion();
                    return;
                }
            }
        } else if ($url == '/edit_region') {
            if (!isset($_SESSION['id'])) {
                header('Location: /401');
                return;
            } else {
                if ($_SESSION['status'] != 1) {
                    header('Location: /403');
                    return;
                } else {
                    echo $adminController->changeCityReg();
                    return;
                }
            }
        } else if ($url == '/profile_settings') {
            if (!isset($_SESSION['id'])) {
                header('Location: /401');
                return;
            } else {
                echo $userController->changeData();
                return;
            }
        } else if ($url == '/modify_client_cs') {
            if (!isset($_SESSION['id'])) {
                header('Location: /401');
                return;
            } else {
                if ($_SESSION['status'] != 1) {
                    header('Location: /403');
                    return;
                } else {
                    echo $adminController->changeCSClient();
                    return;
                }
            }
        } else if ($url == '/add_client') {
            if (!isset($_SESSION['id'])) {
                header('Location: /401');
                return;
            } else {
                if ($_SESSION['status'] != 0) {
                    header('Location: /403');
                    return;
                } else {
                    echo $csController->addClient();
                    return;
                }
            }
        } else if ($url == '/get_report') {
            if (!isset($_SESSION['id'])) {
                header('Location: /401');
                return;
            } else {
                if ($_SESSION['status'] != 0) {
                    header('Location: /403');
                    return;
                } else {
                    echo $csController->kategoriReport();
                    return;
                }
            }
        } else if ($url == '/edit_client') {
            if (!isset($_SESSION['id'])) {
                header('Location: /401');
                return;
            } else {
                if ($_SESSION['status'] != 0) {
                    header('Location: /403');
                    return;
                } else {
                    echo $csController->editClient();
                    return;
                }
            }
        }
    }
?>