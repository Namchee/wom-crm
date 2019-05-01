<?php
    class View {
        public static function render($view, $param) {
            foreach($param as $key=>$value) {
                // rebind
                $$key = $value;
            }

            ob_start();
            require_once 'view/' . $view;
            $content = ob_get_contents();
            ob_end_clean();

            ob_start();
            require_once 'view/layout/layout.php';
            $fullPage = ob_get_contents();
            ob_end_clean();

            return $fullPage;
        }

        public static function renderStatic($view) {
            require_once 'view/static/' . $view;
            $content = ob_get_contents();
            ob_end_clean();

            return $content;
        }
    }
?>