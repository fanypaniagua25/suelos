<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Tipos de Suelos</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f5f5;
            color: #4d4d4d;
        }

        .navbar {
            background-color: #8b4513;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            color: #ffffff !important;
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        .navbar-brand img {
            height: 40px;
            margin-right: 10px;
        }

        .nav-link {
            color: #ffffff !important;
        }

        .soil-card {
            height: 100%;
            max-width: 500px;
            margin: 0 auto;
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            background-color: #ffffff;
        }

        .soil-card:hover {
            transform: translateY(-5px);
        }

        .soil-card img {
            max-height: 250px;
            object-fit: cover;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .soil-card .card-body {
            background-color: #ffffff;
            color: #4d4d4d;
        }

        .soil-card .card-title {
            color: #8b4513;
            font-family: 'Playfair Display', serif;
            font-weight: 700;
        }

        h1.text-center {
            font-family: 'Playfair Display', serif;
            color: #8b4513;
            font-size: 4em;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
            letter-spacing: 2px;
            margin-bottom: 30px;
            text-transform: uppercase;
            position: relative;
            display: inline-block;
            padding: 10px 20px;
            background-color: #f5f5f5;
        }

        h1.text-center::before {
            content: "";
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80%;
            height: 3px;
            background-color: #8b4513;
        }

        .footer {
            background-color: #8b4513;
            color: #ffffff;
            padding: 20px 0;
            text-align: center;
        }

        /* Opciones de diseño adicionales */
        .option-1 {
            background-color: #f8f9fa;
        }

        .option-2 {
            background-image: linear-gradient(to bottom right, #deb887, #d2691e);
            color: #ffffff;
        }

        .option-2 .soil-card {
            background-color: #ffffff;
            color: #4d4d4d;
        }

        .option-2 .soil-card .card-title {
            color: #d2691e;
        }

        .option-2 h1.text-center {
            color: #ffffff;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            background-color: transparent;
        }

        .option-2 h1.text-center::before {
            background-color: #ffffff;
        }

        .option-2 .navbar {
            background-color: #d2691e;
        }

        .option-2 .footer {
            background-color: #d2691e;
        }
    </style>
</head>

<body class="option-1">
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="/images/images.png">
                Sistema de Información Taxonómica
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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
                        <a class="nav-link" href="{{ route('login') }}"><i class="fas fa-sign-in-alt"></i> Iniciar sesión</a>
                    </li>
                    @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}"><i class="fas fa-user-plus"></i> Registrarse</a>
                    </li>
                    @endif
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <div class="container py-5">
        <h1 class="text-center mb-5">Tipos de Suelos</h1>
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card soil-card h-100">
                    <img src="/images/ultisol.jpg" class="card-img-top" alt="Ultisol">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Ultisol</h5>
                        <p class="card-text flex-grow-1">Los Ultisoles son suelos rojos, amarillos o amarronados, ácidos y bien drenados, que se encuentran en regiones tropicales y subtropicales húmedas. Presentan un horizonte de arcilla de alta actividad y se caracterizan por su baja fertilidad natural.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card soil-card h-100">
                    <img src="/images/alfisol.jpg" class="card-img-top" alt="Alfisol">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Alfisol</h5>
                        <p class="card-text flex-grow-1">Los Alfisoles son suelos fértiles, de color rojizo o pardo, que se encuentran principalmente en regiones de clima templado. Tienen un horizonte de arcilla enriquecido y una alta capacidad de retención de nutrientes. Se desarrollan en áreas con una buena precipitación y drenaje adecuado, y son aptos para la agricultura.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card soil-card h-100">
                    <img src="/images/oxisol.jpg" class="card-img-top" alt="Oxisol">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Oxisol</h5>
                        <p class="card-text flex-grow-1">Los Oxisoles son suelos muy antiguos, rojos o amarillos, que se encuentran principalmente en regiones tropicales y subtropicales. Tienen una alta concentración de óxidos de hierro y aluminio, y son generalmente muy ácidos y de baja fertilidad.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card soil-card h-100">
                    <img src="/images/entisol.jpg" class="card-img-top" alt="Entisol">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Entisol</h5>
                        <p class="card-text flex-grow-1">Los Entisoles son suelos jóvenes, poco desarrollados, que se encuentran en áreas recientes de deposición o erosión. Carecen de horizontes de diagnóstico y su fertilidad depende de los materiales parentales. Estos suelos son comunes en zonas desérticas, áreas costeras, riberas de ríos y terrenos montañosos.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card soil-card h-100">
                    <img src="/images/inceptisol.jpg" class="card-img-top" alt="Inceptisol">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Inceptisol</h5>
                        <p class="card-text flex-grow-1">Los Inceptisoles son suelos jóvenes, poco desarrollados, que se encuentran en una amplia variedad de climas y materiales parentales. Presentan horizontes de diagnóstico incipientes y una mayor fertilidad que los Entisoles.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card soil-card h-100">
                    <img src="/images/miscellaneous.jpg" class="card-img-top" alt="Tierras Misceláneas">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Tierras Misceláneas</h5>
                        <p class="card-text flex-grow-1">Las Tierras Misceláneas incluyen áreas que no se ajustan a ninguno de los otros órdenes de suelos, como zonas áridas, áreas urbanas, cuerpos de agua, afloramientos rocosos y áreas perturbadas por actividades humanas. Estas tierras no son aptas para la agricultura y tienen un uso limitado.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p>&copy; 2024 Universidad Nacional del Caaguazú.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
