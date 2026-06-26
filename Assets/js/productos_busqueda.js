document.addEventListener("DOMContentLoaded", function () {
    const inputBuscar = document.getElementById("buscarProducto");
    const tablaBody = document.getElementById("productosTablaBody");
    const selectCategoria = document.getElementById("categoriaFiltro");
    const filtrosDinamicos = document.getElementById("filtrosDinamicos");
    let timer = null;

    if (!inputBuscar || !tablaBody) {
        return;
    }

    inputBuscar.addEventListener("input", function () {
        clearTimeout(timer);

        timer = setTimeout(function () {
            filtrarProductos();
        }, 400);
    });

    if (selectCategoria && filtrosDinamicos) {
        selectCategoria.addEventListener("change", async function () {
            const categoriaId = selectCategoria.value;

            if (categoriaId === "") {
                filtrosDinamicos.textContent = "";
                filtrarProductos();
                return;
            }

            await cargarFiltros(categoriaId);
            filtrarProductos();
        });

        if (selectCategoria.value !== "") {
            cargarFiltros(selectCategoria.value);
            filtrarProductos();
        }
    }

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

    async function cargarFiltros(categoriaId) {
        try {
            const respuesta = await fetch(PRODUCTOS_FILTROS_URL + categoriaId);
            const filtros = await respuesta.json();

            pintarFiltros(filtros);
        } catch (error) {
            filtrosDinamicos.textContent = "Error al cargar los filtros.";
        }
    }

    function pintarFiltros(filtros) {
        filtrosDinamicos.textContent = "";

        if (!filtros.length) {
            filtrosDinamicos.textContent = "No hay filtros para esta categoría.";
            return;
        }

        filtros.forEach(function (filtro) {
            const contenedor = document.createElement("div");
            const titulo = document.createElement("strong");
            const select = document.createElement("select");
            select.classList.add("filtro-dinamico");
            select.dataset.atributoId = filtro.atributo_id;
            select.addEventListener("change", filtrarProductos);

            titulo.textContent = filtro.atributo + ": ";

            const opcionInicial = document.createElement("option");
            opcionInicial.value = "";
            opcionInicial.textContent = "Todos";
            select.appendChild(opcionInicial);

            filtro.valores.forEach(function (valor) {
                const option = document.createElement("option");
                option.value = valor;
                option.textContent = valor;
                select.appendChild(option);
            });

            contenedor.appendChild(titulo);
            contenedor.appendChild(select);
            filtrosDinamicos.appendChild(contenedor);
        });
    }

    async function filtrarProductos() {
        try {
            const categoriaId = selectCategoria ? selectCategoria.value : "";
            const filtros = {};

            document.querySelectorAll(".filtro-dinamico").forEach(function (select) {
                if (select.value !== "") {
                    filtros[select.dataset.atributoId] = select.value;
                }
            });

            const url = PRODUCTOS_FILTRAR_URL
                + "?categoria_id=" + encodeURIComponent(categoriaId)
                + "&q=" + encodeURIComponent(inputBuscar.value)
                + "&filtros=" + encodeURIComponent(JSON.stringify(filtros));

            const respuesta = await fetch(url);
            const productos = await respuesta.json();

            pintarProductos(productos);
        } catch (error) {
            pintarMensaje("Error al filtrar productos.");
        }
    }
});
