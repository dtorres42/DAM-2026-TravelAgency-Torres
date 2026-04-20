<?php
session_start();
include __DIR__ . '/../vistas/header.php';
include __DIR__ . '/../vistas/nav.php';
?>

<main class="main-container">
    <div class="legal-container">
        <h1>Aviso Legal</h1>
        <p>En cumplimiento con el deber de información general recogido en las normativas de servicios de la sociedad de la información, se exponen los siguientes datos:</p>

        <section>
            <h2>1. Datos Identificativos</h2>
            <p>El sitio web <strong>NeoHorizon.com</strong> es gestionado por la entidad NeoHorizon Corp. (en adelante, la Empresa), con domicilio en el Sector Temporal 7, Planta 4, Nueva York (Año 2145). Correo electrónico de contacto: <em>info@neohorizon.tmp</em>.</p>
        </section>

        <section>
            <h2>2. Usuarios</h2>
            <p>El acceso y/o uso de este portal le atribuye la condición de USUARIO, que acepta, desde dicho acceso, las condiciones generales aquí reflejadas.</p>
        </section>

        <section>
            <h2>3. Propiedad Intelectual e Industrial</h2>
            <p>NeoHorizon es titular de todos los derechos de propiedad intelectual de su página web, así como de los elementos contenidos en la misma (tales como imágenes, audio, vídeo, software o textos; marcas o logotipos, combinaciones de colores, estructura y diseño).</p>
            <p>Queda terminantemente prohibida la reproducción, distribución y comunicación pública de la totalidad o parte de los contenidos de esta página web con fines comerciales sin la autorización de la Empresa.</p>
        </section>

        <section>
            <h2>4. Exclusión de Garantías y Responsabilidad</h2>
            <p>La Empresa no se hace responsable, en ningún caso, de los daños y perjuicios de cualquier naturaleza que pudieran ocasionar errores u omisiones en los contenidos, o la transmisión de virus o programas maliciosos a pesar de haber adoptado todas las medidas tecnológicas para evitarlo.</p>
        </section>

        <div style="margin-top: 40px; text-align: center; border-top: 1px solid #eee; padding-top: 30px;">
            <a href="index.php" class="btn-legal">
                 Entendido, volver al catálogo
            </a>
        </div>
    </div>
</main>

<?php include __DIR__ . '/../vistas/footer.php'; ?>