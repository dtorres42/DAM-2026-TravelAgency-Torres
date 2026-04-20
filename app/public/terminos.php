<?php
session_start();
include __DIR__ . '/../vistas/header.php';
include __DIR__ . '/../vistas/nav.php';
?>

<main class="main-container">
    <div class="legal-container">
        <h1>Términos y Condiciones de Uso</h1>
        <p>Última actualización: Abril 2026</p>

        <section>
            <h2>1. Aceptación de los Términos</h2>
            <p>Al acceder y utilizar el portal NeoHorizon, usted acepta cumplir con estos términos. Si no está de acuerdo con alguna parte, le rogamos que no utilice nuestros servicios de reserva de viajes temporales.</p>
        </section>

        <section>
            <h2>2. Uso del Servicio</h2>
            <p>El usuario se compromete a hacer un uso lícito de la plataforma. Queda prohibido:</p>
            <ul>
                <li>Intentar alterar las paradojas temporales mediante el uso indebido de los datos.</li>
                <li>Suplantar la identidad de otros viajeros en el sistema de favoritos.</li>
                <li>Realizar reservas fraudulentas en el catálogo de destinos.</li>
            </ul>
        </section>

        <section>
            <h2>3. Propiedad Intelectual</h2>
            <p>Todo el contenido de este sitio (imágenes de destinos, descripciones, itinerarios y logotipos) es propiedad de NeoHorizon. No está permitida su reproducción total o parcial sin autorización previa.</p>
        </section>

        <section>
            <h2>4. Responsabilidad</h2>
            <p>NeoHorizon actúa como intermediario en la gestión de expediciones. No nos hacemos responsables de cambios en la línea de tiempo causados por eventos fuera de nuestro control técnico.</p>
        </section>

        <section>
            <h2>5. Modificaciones</h2>
            <p>Nos reservamos el derecho de modificar estos términos en cualquier momento para adaptarlos a nuevas normativas galácticas o mejoras técnicas en nuestra base de datos.</p>
        </section>

        <div style="margin-top: 40px; text-align: center; border-top: 1px solid #eee; padding-top: 30px;">
            <a href="index.php" class="btn-legal">
                He leído y acepto los términos
            </a>
        </div>
    </div>
</main>

<?php include __DIR__ . '/../vistas/footer.php'; ?>