import { DataTable } from "simple-datatables";
import "simple-datatables/dist/style.css";

const myTable = new DataTable("#tabla-posts", {
    searchable: true,
    fixedHeight: true,
    perPage: 10,
    labels: {
        placeholder: "Buscar...",
        perPage: "Registros por página",
        noRows: "No se encontraron registros",
        info: "Mostrando {start} a {end} de {rows} registros",
    }
});

document.addEventListener('DOMContentLoaded', function() {

    document.addEventListener('click', async  function (e) {

        //sE carga la informacion de los registos
        if (e.target.classList.contains('btn-editar')) {

            try {

                const id = e.target.dataset.id;
                const form = document.getElementById('form-update');
                // AQUÍ SE CREA EL ACTION DINÁMICAMENTE
                form.action = `/Posts/${id}`; 

                const { data } = await axios.get(`/Posts/${id}/edit`);
                document.getElementById('title_update').value  = data.title;
                document.getElementById('categoria_update').value  = data.categoria;
                document.getElementById('content_update').value  = data.content;
                
            } catch (error) {
                window.mistake.fire({
                    text: 'No se pudo cargar el post. Inténtalo de nuevo.',
                });
            }
            
        }

        if (e.target.classList.contains('btn-insert')) {

            document.getElementById('titulo').value  = "";
            document.getElementById('categoria').value  = "";
            document.getElementById('contenido').value  = "";
            
        }

        if (e.target.classList.contains('btn-eliminar')) {

            const boton = e.target.closest('.btn-eliminar');
            const idElimi = e.target.dataset.id;

            const ejecutarEliminacion  = async (id) => {
                const resultEli = await Swal.fire({
                    title: '¿Confirmar eliminación?',
                    text: "Esta acción es permanente",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                });

                if (resultEli.isConfirmed) {

                    try {

                        // Petición Axios
                        const responseDelete = await axios.delete(`/Posts/${id}`);
                        if (responseDelete.data.success) {

                            window.successful.fire({
                                text: "eliminado con éxito!",
                            });

                            cargarDatosTabla();
                        }

                    } catch (error) {

                        const mensajeServidor1 = error.response?.data?.message;
                        window.mistake.fire({
                            text: mensajeServidor1 || 'Error al procesar la solicitud',
                        });


                    }

                }

            }

            ejecutarEliminacion(idElimi);

        }

    });

    cargarDatosTabla();

});

const formInsert = document.getElementById('form-insert');
formInsert.addEventListener('submit', async function(e) {

    e.preventDefault(); 
    const formData1 = new FormData(this);
    formData1.append('_method', 'POST'); 

    document.getElementById('btn-insert').style.display = 'none';
    document.getElementById('cerrarModalInsert').style.display = 'none';

    try {

        const response1 = await axios.post('/Posts', formData1);
        if (response1.data.success) {

            window.successful.fire({
                text: "¡Creado con éxito!",
            });

            document.getElementById('cerrarModalInsert').click();
            cargarDatosTabla();
        }

    } catch (error) {

        const mensajeServidor = error.response?.data?.message;
        window.mistake.fire({
            text: mensajeServidor || 'No se pudo crear el post. Inténtalo de nuevo.',
        });

    }finally{

        document.getElementById('btn-insert').style.display = 'block';
        document.getElementById('cerrarModalInsert').style.display = 'block';

    }

});

//Capturar el envío del formulario Modificar
const formUpdate = document.getElementById('form-update');
formUpdate.addEventListener('submit', async function(e) {

    e.preventDefault(); 
    const formData = new FormData(this);
    const actionUrl = this.action;
    formData.append('_method', 'PATCH'); 

    document.getElementById('btn-update').style.display = 'none';
    document.getElementById('cerrarModalUpdate').style.display = 'none';

    try {

        // Enviar datos con Axios
        const response = await axios.post(actionUrl, formData);
        if (response.data.success) {

            window.successful.fire({
                text: "¡Actualizado con éxito!",
            });

            document.getElementById('cerrarModalUpdate').click();
            cargarDatosTabla();
        }

    } catch (error) {

        const mensajeServidor3 = error.response?.data?.message;

        window.mistake.fire({
            text: mensajeServidor3 || 'No se pudo Modificar el post. Inténtalo de nuevo.',
        });
        
    }finally{

        document.getElementById('btn-update').style.display = 'block';
        document.getElementById('cerrarModalUpdate').style.display = 'block';

    }

});

async function cargarDatosTabla() {
    try {
        const response1 = await axios.get('/Posts/json-data'); // Ruta que crearemos en Laravel
        
        // Formateamos los datos para la tabla
        const bodyData = response1.data.map(post => [
            post.id.toString(), // Asegúrate de enviarlo como texto
            post.title,
            post.categoria,
            post.content,
            post.created_at,
            post.updated_at,
            `<button class="btn btn-sm btn-primary btn-editar" data-id="${post.id}" data-bs-toggle="modal" data-bs-target="#editModal">Editar</button>
            <button class="btn btn-sm btn-primary btn-eliminar" data-id="${post.id}" >Borrar</button>`
        ]);

        const tablep = myTable.currentPage;
        if (myTable.activeRows) {
            myTable.rows.remove(Array.from({ length: myTable.data.data.length }, (_, i) => i));
        } else {
            // Si lo anterior falla, reiniciamos el contenedor de datos
            myTable.data.data = [];
        }
        
        myTable.insert({
            data: bodyData
        })

        setTimeout(() => {
            myTable.page(tablep);
        }, 100);


    } catch (error) {
        console.error("Error al obtener datos de MySQL:", error);
    }
}