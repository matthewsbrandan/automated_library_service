  <!-- Button trigger modal -->
  <button type="button" class="btn bg-gradient-info btn-block" >
    SignUp Modal
  </button>

<!-- Modal -->
<div class="modal fade" id="modalAddBook" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-body p-0">
        <div class="card card-plain">
          <div class="card-header pb-0 text-left">
              <h3 class="font-weight-bolder text-dark">Novo Livro</h3>
              <p class="mb-0">Adicione um novo livro ao acervo</p>
          </div>
          <div class="card-body pb-3">
            <form role="form text-left">
              <label>ISBN</label>
              <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="isbn" aria-label="isbn" aria-describedby="isbn-addon">
              </div>
              <label>Título</label>
              <div class="input-group mb-3">
                <input type="title" class="form-control" placeholder="título" aria-label="title" aria-describedby="title-addon">
              </div>
              <label>Subtítulo</label>
              <div class="input-group mb-3">
                <input type="subtitle" class="form-control" placeholder="subtítulo" aria-label="subtitle" aria-describedby="subtitle-addon">
              </div>
              <label>Autores</label>
              <div class="input-group mb-3">
                <input type="authors" class="form-control" placeholder="autores" aria-label="authors" aria-describedby="authors-addon">
              </div>
              <label>Data de publicação</label>
              <div class="input-group mb-3">
                <input type="published_date" class="form-control" placeholder="data" aria-label="published_date" aria-describedby="published_date-addon">
              </div>
              <label>Descrição</label>
              <div class="input-group mb-3">
                <input type="description" class="form-control" placeholder="descrição" aria-label="description" aria-describedby="description-addon">
              </div>
              <label>Categorias</label>
              <div class="input-group mb-3">
                <input type="categories" class="form-control" placeholder="categorias" aria-label="categories" aria-describedby="categories-addon">
              </div>
              <div class="text-center">
                <button type="button" class="btn btn-dark btn-lg btn-rounded w-100 mt-4 mb-0">Cadastrar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
