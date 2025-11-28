<?php
session_start();
include("conexion.php");
?>
<!DOCTYPE html>
    <html lang="es">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noticias que Inspiran - MascotAR</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Amatic+SC:wght@700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    </head>

    <body>
    <?php include("header.php"); ?>
    <section class="prensa-hero">
        <img src="imagenesong/noticiasimg3.webp" alt="Fondo Prensa" class="fondo-img">
        
        <div class="hero-text">
        <h1>Noticias que Inspiran</h1>
        <p>
            En este espacio podrás acceder a las noticias más recientes, entrevistas y notas de prensa sobre MascotAR.  
            Encontrarás historias reales de rescates, adopciones y el trabajo que realizamos día a día para transformar vidas.
        </p>
        </div>
    </section>

    <section class="prensa-contenido">
        <h2>Últimas novedades</h2>
        <div class="noticias-grid">
        <article class="noticia-card">
            <img src="imagenesong/prensaimg2.png" alt="Noticia 1">
            <h3>Un nuevo hogar para Luna</h3>
            <p>Conocé la historia de Luna, una perrita que encontró familia gracias al programa de adopciones.</p>
            <a href="noticias_mas.php?id=1">Leer más</a>
        </article>
        
        <article class="noticia-card">
            <img src="imagenesong/prensaimg.png" alt="Noticia 2">
            <h3>La historia de Tomás, el gato con ruedas</h3>
            <p>Compartimos esta historia de superación.</p>
            <a href="noticias_mas.php?id=2">Leer más</a>
        </article>
        
        <article class="noticia-card">
            <img src="imagenesong/noticiasimg4.webp.png" alt="Noticia 3">
            <h3>Nos entrevistaron para el medio internacional</h3>
            <p>Amigos, compartimos la nota que nos realizaron para el medio internacional.  
            Vinieron a filmar al refugio y les agradecemos muchísimo el espacio.
            </p>
            <a href="noticias_mas.php?id=3">Leer más</a>
        </article>
        </div>
    </section>

    <?php include("footer.php"); ?>
    </body>
</html> 
