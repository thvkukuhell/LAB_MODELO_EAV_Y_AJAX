document.addEventListener("DOMContentLoaded", function () {
    const inputBuscar = document.getElementById("buscarProducto");
    const tablaBody = document.getElementById("productosTablaBody");
    let timer = null;

    if (!inputBuscar || !tablaBody) {
        return;
    }

    inputBuscar.addEventListener("input", function () {
        clearTimeout(timer);

        timer = setTimeout(function () {
            buscarProductos(inputBuscar.value);
        }, 400);
    });

    async function buscarProductos(texto) {
        try {
            const respuesta = await fetch(PRODUCTOS_BUSCAR_URL + "?q=" + encodeURIComponent(texto));
            const productos = await respuesta.json();

            pintarProductos(productos);
        } catch (error) {
            pintarMensaje("Error al buscar productos.");
        }
    }

    function pintarProductos(productos) {
        tablaBody.textContent = "";

        if (!productos.length) {
            pintarMensaje("No se encontraron productos.");
            return;
        }

        productos.forEach(function (producto) {
            const fila = document.createElement("tr");
            const celdaId = document.createElement("td");
            const celdaNombre = document.createElement("td");
            const celdaCategoria = document.createElement("td");

            celdaId.textContent = producto.id;
            celdaNombre.textContent = producto.nombre;
            celdaCategoria.textContent = producto.categoria || "Sin categoria";

            fila.appendChild(celdaId);
            fila.appendChild(celdaNombre);
            fila.appendChild(celdaCategoria);
            tablaBody.appendChild(fila);
        });
    }

    function pintarMensaje(mensaje) {
        tablaBody.textContent = "";

        const fila = document.createElement("tr");
        const celda = document.createElement("td");

        celda.colSpan = 3;
        celda.textContent = mensaje;
        fila.appendChild(celda);
        tablaBody.appendChild(fila);
    }
});
