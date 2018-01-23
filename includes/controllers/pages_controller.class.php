<?php
    class PagesController {
        public function home() {
            require_once('includes/views/pages/home.php');
        }

        public function contact() {
            require_once('includes/views/pages/contact.php');
        }

        public function services() {
            require_once('includes/views/pages/services.php');
        }

        public function about() {
            require_once('includes/views/pages/about.php');
        }

        public function error() {
            require_once('includes/views/pages/error.php');
        }
    }
?>
