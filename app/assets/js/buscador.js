function buscarViajes() {
    // 1. Obtener valores de los inputs
    const destino = document.getElementById('destino').value;
    const fecha = document.getElementById('fecha').value;
    const tipo = document.getElementById('tipo').value;
    const contenedor = document.getElementById('resultados-busqueda');

    // 2. Configurar la petición AJAX
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'buscador.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    // Mostrar mensaje de carga
    contenedor.innerHTML = '<p style="text-align:center; width:100%;">Buscando destinos...</p>';

    xhr.onload = function() {
        if (this.status === 200) {
            // 3. Inyectar el HTML que devuelve el PHP
            contenedor.innerHTML = this.responseText;
        }
    };

    // 4. Enviar datos
    xhr.send(`destino=${destino}&fecha=${fecha}&tipo=${tipo}`);
}