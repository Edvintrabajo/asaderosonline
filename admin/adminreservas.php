<?php 
session_start();
if(!isset($_SESSION['usuario'])) {
    header("location: ../index.php");
} else {
    if(!$_SESSION['usuario']['admin']) {
        header("location: ../index.php");
    }
}

include "../parts/adminheader.php"; ?>

<!-- Navigation-->
<nav class="navbar navbar-expand-lg bg-secondary text-uppercase fixed-top" id="subNav">
    <div class="container">
        <a class="navbar-brand" href="../index.php">Asaderos Online</a>
        <button class="navbar-toggler text-uppercase font-weight-bold bg-primary text-white rounded" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            Menu
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="adminasaderos.php">Asaderos</a></li>
                <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="adminusuarios.php">Usuarios</a></li>
                <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded active" href="adminreservas.php">Reservas</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Reservas Section-->
<section class="page-section portfolio mt-5" id="reservas">
    <div class="container">
        <!-- Reservas Section Heading-->
        <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">Reservas</h2>
        <!-- Icon Divider-->
        <div class="divider-custom">
            <div class="divider-custom-line"></div>
            <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
            <div class="divider-custom-line"></div>
        </div>
        <!-- Reservas Grid Items-->
        <div class="row justify-content-center">
            <?php include "adminverreservas.php"; ?>
        </div>
    </div>
</section>

<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Core theme JS-->
<script src="src/js/scripts.js"></script>