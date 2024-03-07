<!-- resources/views/custom-home.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taxonomia</title>

    <!-- Enlaces a los archivos de estilos y scripts de AdminLTE3 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.1.0/dist/css/adminlte.min.css">
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.1.0/dist/js/adminlte.min.js"></script>

    <!-- Enlaces a Bootstrap (ya que AdminLTE3 depende de Bootstrap) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <style>
        /* Estilos generales */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
            color: #495057;
        }

        h1 {
            color: #007bff;
        }

        /* Carrusel de fotos del departamento */
        #carouselExampleIndicators {
            max-width: 800px;
            margin: 20px auto;
        }

        .carousel-inner img {
            width: 100%;
            height: 30vh; /* ajusta la altura a 30% del viewport height */
            object-fit: cover; /* escala la imagen sin distorsionar */
            border-radius: 10px;

        }

        /* Tipos de suelos y descripciones */
        .soil-types {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            margin: 20px;
        }

        .soil-type {
            text-align: center;
            margin-bottom: 20px;
            max-width: 200px;
        }

        .soil-type img {
            max-width: 100%;
            border-radius: 10px;
        }

        /* Estilos adicionales según sea necesario */
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn-success:hover {
            background-color: #218838;
            border-color: #218838;
        }
    </style>

</head>
<body class="bg-light">
    <div class="container mt-5">
        <h1 class="text-center mb-4">Bienvenido a la página de inicio personalizada</h1>

        <!-- Carrusel de fotos del departamento

        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="images/carrusel/alfisol.jpg" class="d-block w-100" alt="Foto 1">
                </div>
                <div class="carousel-item">
                    <img src="images/carrusel/ultisol.jpg" class="d-block w-100" alt="Foto 2">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>-->
        <div id="carouselExampleIndicators" class="carousel slide">
            <div class="carousel-indicators">
              <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
              <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
              <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
              <div class="carousel-item active">
                <img src="images/carrusel/ultisol.jpg" class="d-block w-100" alt="...">
              </div>
              <div class="carousel-item">
                <img src="images/carrusel/alfisol.jpg" class="d-block w-100" alt="...">
              </div>
              <div class="carousel-item">
                <img src="images/carrusel/entisol.jpeg" class="d-block w-100" alt="...">
              </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>
        <!-- Cuadros con imágenes y descripciones -->
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card">
                    <img src="images/carrusel/ultisol.jpg" class="card-img-top" alt="Foto 1">
                    <div class="card-body">
                        <p class="card-text">Descripción de la foto 1.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="images/carrusel/alfisol.jpg" class="card-img-top" alt="Foto 2">
                    <div class="card-body">
                        <p class="card-text">Descripción de la foto 2.</p>
                    </div>
                </div>
            </div>
            <!-- Agrega más cuadros según sea necesario -->
        </div>

        <!-- Tipos de suelos y descripciones -->
        <div class="soil-types">
            <!-- Contenido de los tipos de suelos... -->
        </div>

        @guest
            <!-- Contenido para usuarios no autenticados... -->
        @endguest

        <!-- Más contenido de la página aquí -->
    </div>

    <!-- Agrega el script de Bootstrap al final del body -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
