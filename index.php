<?php include "parts/header.php"; 
error_reporting(0);// PARA QUE NO APAREZCAN EL WARNING Y NOTICE ?>
<!-- Navigation-->
<nav class="navbar navbar-expand-lg bg-secondary text-uppercase fixed-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand" href="index.php">Asaderos Online</a>
        <button class="navbar-toggler text-uppercase font-weight-bold bg-primary text-white rounded" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            Menu
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="#asaderos">Asaderos</a></li>
                <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="#about">About</a></li>
                <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="#contacto">Contacto</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Masthead-->
<header class="masthead text-white text-center">
    <div class="shadow container d-flex align-items-center flex-column">
        <!-- Masthead Avatar Image-->
        <img class="masthead-avatar mb-5" src="src/assets/img/avataaars.svg" alt="..." />
        <!-- Masthead Heading-->
        <h1 class="masthead-heading text-uppercase mb-0">Asaderos Online</h1>
        <!-- Icon Divider-->
        <div class="divider-custom divider-light">
            <div class="divider-custom-line"></div>
            <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
            <div class="divider-custom-line"></div>
        </div>
        <!-- Masthead Subheading-->
        <p class="masthead-subheading font-weight-light mb-0">Gestor de Asaderos Online</p>
        <p class="masthead-subheading font-weight-light mb-0">Invita a tus amigos :)</p>
    </div>
</header>

<!-- Asaderos Section-->
<section class="page-section portfolio" id="asaderos">
    <div class="container">
        <!-- Asaderos Section Heading-->
        <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">Asaderos</h2>
        <!-- Icon Divider-->
        <div class="divider-custom">
            <div class="divider-custom-line"></div>
            <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
            <div class="divider-custom-line"></div>
        </div>
        <!-- Asaderos Grid Items-->
        <div class="row justify-content-center">
            <?php include "verasaderos.php"; ?>
        </div>
    </div>
</section>

<!-- Acerca de Section-->
<section class="page-section bg-primary text-white mb-0" id="about">
    <div class="container">
        <!-- About Section Heading-->
        <h2 class="page-section-heading text-center text-uppercase text-white">Acerca de</h2>
        <!-- Icon Divider-->
        <div class="divider-custom divider-light">
            <div class="divider-custom-line"></div>
            <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
            <div class="divider-custom-line"></div>
        </div>
        <!-- About Section Content-->
        <div class="row">
            <div class="col-lg-4 ms-auto"><p class="lead">Esta página está hecha por el desarrollador web Edvin, como proyecto para la asignatura DSW.</p></div>
            <div class="col-lg-4 me-auto"><p class="lead">Se ha creado con HTML, CSS, JavaScript, MySQL y PHP.</p></div>
        </div>
        <!-- About Section Button-->
        <div class="text-center mt-4">
            <a class="btn btn-xl btn-outline-light" href="https://github.com/Edvintrabajo?tab=repositories" target="_blank">
                <i class="fas fa-download me-2"></i>
                Si quieres ver más proyecto mios, click aquí!
            </a>
        </div>
    </div>
</section>

<!-- Contacto Section-->
<section class="page-section" id="contacto">
    <div class="container">
        <!-- Contacto Section Heading-->
        <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">Contacta Conmigo</h2>
        <!-- Icon Divider-->
        <div class="divider-custom">
            <div class="divider-custom-line"></div>
            <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
            <div class="divider-custom-line"></div>
        </div>
        <!-- Contacto Section Form-->
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-7">
                <form id="contactForm" data-sb-form-api-token="API_TOKEN">
                    <!-- Name input-->
                    <div class="form-floating mb-3">
                        <input class="form-control" id="name" type="text" placeholder="Introduce tu nombre..." data-sb-validations="required" />
                        <label for="name">Nombre</label>
                        <div class="invalid-feedback" data-sb-feedback="name:required">El nombre es obligatorio.</div>
                    </div>
                    <!-- Email address input-->
                    <div class="form-floating mb-3">
                        <input class="form-control" id="email" type="email" placeholder="nombre@ejemplo.com" data-sb-validations="required,email" />
                        <label for="email">Correo electrónico</label>
                        <div class="invalid-feedback" data-sb-feedback="email:required">El email es obligatorio</div>
                        <div class="invalid-feedback" data-sb-feedback="email:email">Email no válido.</div>
                    </div>
                    <!-- Phone number input-->
                    <div class="form-floating mb-3">
                        <input class="form-control" id="phone" type="tel" placeholder="666666666" data-sb-validations="required" />
                        <label for="phone">Número de teléfono</label>
                        <div class="invalid-feedback" data-sb-feedback="phone:required">El número de teléfono es obligatorio.</div>
                    </div>
                    <!-- Message input-->
                    <div class="form-floating mb-3">
                        <textarea class="form-control" id="message" type="text" placeholder="Introduce tu mensaje aquí..." style="height: 10rem" data-sb-validations="required"></textarea>
                        <label for="message">Mensaje</label>
                        <div class="invalid-feedback" data-sb-feedback="message:required">El mensaje es obligatorio.</div>
                    </div>
                    <!-- Submit success message-->
                    <!---->
                    <!-- This is what your users will see when the form-->
                    <!-- has successfully submitted-->
                    <div class="d-none" id="submitSuccessMessage">
                        <div class="text-center mb-3">
                            <div class="fw-bolder">Se ha enviado el mensaje correctamente!</div>
                        </div>
                    </div>
                    <!-- Submit error message-->
                    <!---->
                    <!-- This is what your users will see when there is-->
                    <!-- an error submitting the form-->
                    <div class="d-none" id="submitErrorMessage"><div class="text-center text-danger mb-3">Error al enviar el mensaje!</div></div>
                    <!-- Submit Button-->
                    <button class="btn btn-primary btn-xl" id="submitButton" type="submit">Enviar</button>
                </form>
            </div>
        </div>
    </div>
</section>

<?php include "parts/footer.php"; ?>