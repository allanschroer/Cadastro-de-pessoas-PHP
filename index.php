<?php
include 'db.php';
include 'header.php';
include 'body.php';

@$pagina = $_GET['pagina'];

if ($pagina == 'editar') {
    include 'editar.php';
}