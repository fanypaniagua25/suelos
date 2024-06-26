<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tipos de Suelos</title>
    <link rel="icon" type="image/png" href="/storage/logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        :root {
            --primary-color: #1E88E5;
            --secondary-color: #4DB6AC;
            --accent-color: #81D4FA;
            --background-color: #F5F5F5;
            --text-color: #333333;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--background-color);
            color: var(--text-color);
        }

        .navbar {
    background: linear-gradient(to right, #1a237e, #283593);
    padding: 15px 0;
    transition: all 0.3s ease;
}

.navbar-brand {
    font-weight: 600;
    font-size: 1.4rem;
    transition: all 0.3s ease;
}

.navbar-brand img {
    transition: all 0.3s ease;
}

.nav-link {
    color: rgba(255, 255, 255, 0.8) !important;
    font-weight: 500;
    transition: all 0.3s ease;
    position: relative;
    padding: 8px 15px;
}

.nav-link:hover {
    color: #ffffff !important;
}

.nav-link::after {
    content: '';
    position: absolute;
    width: 0;
    height: 2px;
    bottom: 0;
    left: 50%;
    background-color: #ffffff;
    transition: all 0.3s ease;
    transform: translateX(-50%);
}

.nav-link:hover::after {
    width: 70%;
}

.navbar-toggler {
    border: none;
    padding: 0.25rem 0.75rem;
}

.navbar-toggler-icon {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(255, 255, 255, 0.8)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
}

@media (max-width: 991.98px) {
    .navbar-nav {
        background-color: rgba(26, 35, 126, 0.95);
        padding: 15px;
        border-radius: 8px;
    }
}

        .page-title {
            font-family: 'Playfair Display', serif;
            color: var(--primary-color);
            font-size: 3.5em;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 40px;
            position: relative;
            display: inline-block;
        }

        .page-title::after {
            content: "";
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80%;
            height: 3px;
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
        }

        .soil-card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            animation: fadeIn 0.5s ease-out forwards;
        }

        .soil-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        }

        .soil-card .card-body {
            background-color: #FFFFFF;
        }

        .soil-card .card-title {
            color: var(--secondary-color);
            font-weight: 600;
        }

        .soil-card img {
            height: 200px;
            object-fit: cover;
        }

        .footer {
    background-color: #333;
    color: #fff;
    padding: 40px 0;
    font-size: 14px;
}

.footer-content {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
}

.footer-left, .footer-center, .footer-right {
    flex: 1;
    margin: 10px;
    min-width: 250px;
}

.footer-logo {
    max-width: 80px;
    margin-bottom: 10px;
}

.footer-left h2 {
    margin: 0;
    font-size: 24px;
    color: #fff;
}

.footer-left p {
    margin: 5px 0;
}

.footer-copyright {
    font-size: 12px;
    margin-top: 20px;
}

.footer-center i {
    margin-right: 10px;
    color: #4DB6AC;
}

.footer-right h3 {
    color: #4DB6AC;
    font-size: 18px;
    margin-bottom: 10px;
}

.social-icons {
    margin-top: 20px;
}

.social-icons a {
    color: #fff;
    font-size: 18px;
    margin-right: 15px;
    transition: color 0.3s ease;
}

.social-icons a:hover {
    color: #4DB6AC;
}

@media (max-width: 768px) {
    .footer-content {
        flex-direction: column;
    }

    .footer-left, .footer-center, .footer-right {
        margin-bottom: 30px;
    }
}

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .soil-card:nth-child(2) {
            animation-delay: 0.1s;
        }

        .soil-card:nth-child(3) {
            animation-delay: 0.2s;
        }

        .soil-card:nth-child(4) {
            animation-delay: 0.3s;
        }

        .soil-card:nth-child(5) {
            animation-delay: 0.4s;
        }

        .soil-card:nth-child(6) {
            animation-delay: 0.5s;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="/storage/logo.png" alt="Logo" style="height: 40px; margin-right: 10px;">
                Sistema de Información Taxonómica
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/home') }}"><i class="fas fa-home"></i> Inicio</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}"><i class="fas fa-sign-in-alt"></i> Iniciar
                                sesión</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}"><i class="fas fa-user-plus"></i>
                                    Registrarse</a>
                            </li>
                        @endif
                    @endauth
                </ul>
            </div>
        </div>
    </nav>
    <div class="container py-5">
        <h1 class="text-center page-title">Tipos de Suelos</h1>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <div class="col">
                <div class="card soil-card h-100">
                    <img src="/images/ultisol.jpg" class="card-img-top" alt="Ultisol">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-leaf mr-2"></i> Ultisol</h5>
                        <p class="card-text">Los Ultisoles son suelos rojos, amarillos o amarronados, ácidos y bien
                            drenados, que se encuentran en regiones tropicales y subtropicales húmedas. Presentan un
                            horizonte de arcilla de alta actividad y se caracterizan por su baja fertilidad natural.</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card soil-card h-100">
                    <img src="/images/alfisol.jpg" class="card-img-top" alt="Alfisol">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-seedling mr-2"></i> Alfisol</h5>
                        <p class="card-text">Los Alfisoles son suelos fértiles, de color rojizo o pardo, que se
                            encuentran principalmente en regiones de clima templado. Tienen un horizonte de arcilla
                            enriquecido y una alta capacidad de retención de nutrientes. Se desarrollan en áreas con una
                            buena precipitación y drenaje adecuado, y son aptos para la agricultura.</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card soil-card h-100">
                    <img src="/images/oxisol.jpg" class="card-img-top" alt="Oxisol">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-mountain mr-2"></i> Oxisol</h5>
                        <p class="card-text">Los Oxisoles son suelos muy antiguos, rojos o amarillos, que se encuentran
                            principalmente en regiones tropicales y subtropicales. Tienen una alta concentración de
                            óxidos de hierro y aluminio, y son generalmente muy ácidos y de baja fertilidad.</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card soil-card h-100">
                    <img src="/images/entisol.jpg" class="card-img-top" alt="Entisol">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-water mr-2"></i> Entisol</h5>
                        <p class="card-text">Los Entisoles son suelos jóvenes, poco desarrollados, que se encuentran en
                            áreas recientes de deposición o erosión. Carecen de horizontes de diagnóstico y su
                            fertilidad depende de los materiales parentales. Estos suelos son comunes en zonas
                            desérticas, áreas costeras, riberas de ríos y terrenos montañosos.</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card soil-card h-100">
                    <img src="/images/inceptisol.jpg" class="card-img-top" alt="Inceptisol">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-tree mr-2"></i> Inceptisol</h5>
                        <p class="card-text">Los Inceptisoles son suelos jóvenes, poco desarrollados, que se encuentran
                            en una amplia variedad de climas y materiales parentales. Presentan horizontes de
                            diagnóstico incipientes y una mayor fertilidad que los Entisoles.</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card soil-card h-100">
                    <img src="/images/miscellaneous.jpg" class="card-img-top" alt="Tierras Misceláneas">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-globe-americas mr-2"></i> Tierras Misceláneas</h5>
                        <p class="card-text">Las Tierras Misceláneas incluyen áreas que no se ajustan a ninguno de los
                            otros órdenes de suelos, como zonas áridas, áreas urbanas, cuerpos de agua, afloramientos
                            rocosos y áreas perturbadas por actividades humanas. Estas tierras no son aptas para la
                            agricultura y tienen un uso limitado.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-left">
                    <img src="/storage/logo.png" alt="Logo FCyT" class="footer-logo">
                    <h2>PORTAL SUELOS</h2>
                    <p>Facultad de Ciencias y Tecnologías</p>
                    <a href="http://www.fctunca.edu.py/">Sitio Web </a>
                    <p class="footer-copyright">FCyT © 2024 </p>
                </div>
                <div class="footer-center">
                    <p><i class="fas fa-map-marker-alt"></i> Sgto. Florentino Benítez e/ Padre Molas y Fabián Ojeda,
                        Coronel Oviedo, Paraguay</p>
                    <p><i class="fas fa-phone"></i> +595 521 201548</p>
                    <p><i class="fas fa-envelope"></i> soporte@fctunca.edu.py</p>
                </div>
                <div class="footer-right">
                    <div class="social-icons">
                        <a href="https://www.facebook.com/fcyt.unca/"><i class="fab fa-facebook"></i></a>
                        <a href="https://x.com/FcytUnca"><i class="fab fa-twitter"></i></a>
                        <a href="https://www.youtube.com/channel/UCgR6pDGuyrN-OZ5a2PjgZnQ"><i
                                class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
