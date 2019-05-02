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
                if ($_SESSION['id'] != 1) {
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
                if ($_SESSION['id'] != 1) {
                    header('Location: /403');
                } else {
                    echo $adminController->getRegionById();
                    return;
                }
            } else {
                header('Location: /401');
                return;
            }
        } else if ($url == '/add_cs') {
            if (isset($_SESSION['id'])) {
                if ($_SESSION['id'] != 1) {
                    header('Location: /403');
                } else {
                    echo $adminController->viewAddCS();
                    return;
                }
            } else {
                header('Location: /401');
                return;
            }
        } else if ($url == '/move_client') {
            if (isset($_SESSION['id'])) {
                if ($_SESSION['id'] != 1) {
                    header('Location: /403');
                } else {
                    echo 'yay';
                    return;
                }
            } else {
                header('Location: /401');
                return;
            }
        } else if ($url == '/add_kota') {
            if (isset($_SESSION['id'])) {
                if ($_SESSION['id'] != 1) {
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
                if ($_SESSION['id'] != 1) {
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
                if ($_SESSION['id'] != 1) {
                    header('Location: /403');
                } else {
                    echo $adminController->viewEditRegion();
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
        } else if ($url == '/401') {
            echo View::renderStatic('401.html');
            return;
        } else if ($url == '/404') {
            echo View::renderStatic('404.html');
            return;
        } else if ($url == '/403') {
            echo 'No rights for you!';
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
                } else {
                    echo $adminController->addCS();
                }
            }
        } else if ($url == '/add_kota') {
            if (!isset($_SESSION['id'])) {
                header('Location: /401');
                return;
            } else {
                if ($_SESSION['status'] != 1) {
                    header('Location: /403');
                } else {
                    echo $adminController->addKota();
                }
            }
        } else if ($url == '/add_region') {
            if (!isset($_SESSION['id'])) {
                header('Location: /401');
                return;
            } else {
                if ($_SESSION['status'] != 1) {
                    header('Location: /403');
                } else {
                    echo $adminController->addRegion();
                }
            }
        } else if ($url == '/edit_region') {
            if (!isset($_SESSION['id'])) {
                header('Location: /401');
                return;
            } else {
                if ($_SESSION['status'] != 1) {
                    header('Location: /403');
                } else {
                    $adminController->changeCityReg();
                }
            }
        } else if ($url == '/profile_settings') {
            if (!isset($_SESSION['id'])) {
                header('Location: /401');
                return;
            } else {
                echo $userController->changeData();
            }
        }
    }
?>