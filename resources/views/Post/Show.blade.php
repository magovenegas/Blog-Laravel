<x-app-layout>
    <h1>Bienvenido a mi Blogs</h1>
    <div class="container mt-5">
    <h2 class="mb-4">Lista de Registros</h2>
    <!-- Botón para abrir el modal -->
    <button type="button" class="btn btn-primary mb-4 btn-insert" data-bs-toggle="modal" data-bs-target="#modalRegistro">
        Nuevo Registro
    </button>
    <div class="table-responsive" > 
        <table id="tabla-posts" class="table table-striped table-hover table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Titulo</th>
                    <th>Categoria</th>
                    <th>Contenido</th>
                    <th>Fecha Creacion</th>
                    <th>Fecha Actualizacion</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>
<!-- Estructura del Modal Ingreso -->
<div class="modal fade" id="modalRegistro"  data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Registrar Post</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <!-- Formulario -->
        <form id="form-insert" method="POST" autocomplete="off">
            @csrf
            @method('POST')
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Titulo</label>
                    <input type="text" name="title" id="titulo" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Categoria</label>
                    <input type="text" name="categoria" id="categoria" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Contenido</label><br>
                    <textarea  class="form-control mb-3" placeholder="Contenido" name="content" id="contenido" required></textarea>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary"  id="cerrarModalInsert" data-bs-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-success"  id="btn-insert">Guardar Registro</button>
            </div>
        </form>
    </div>
  </div>
</div>
<!-- Estructura del Modal Ingreso -->
<div class="modal fade" id="editModal" tabindex="-1"  data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modificar Post</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <!-- Formulario -->
      <form id="form-update" method="POST" autocomplete="off">
        @csrf
        @method('PATCH')
        <div class="modal-body">
            <div class="mb-3">
                <label class="form-label">Titulo</label>
                <input type="text" name="title" id="title_update" class="form-control" disabled>
            </div>
            <div class="mb-3">
                <label class="form-label">Categoria</label>
                <input type="text" name="categoria" id="categoria_update" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Contenido</label><br>
                <textarea  class="form-control mb-3" placeholder="Contenido" name="content" id="content_update" required></textarea>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" id="cerrarModalUpdate" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-success" id="btn-update" >Modificar Registro</button>
        </div>
      </form>
    </div>
  </div>
</div>
@push('scripts')
    @vite(['resources/js/modules/posts.js'])
@endpush
@stack('scripts') 
</x-app-layout>