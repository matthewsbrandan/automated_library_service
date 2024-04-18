<!-- Modal -->
<div class="modal fade" id="modalCollect" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-body p-0">
        <div class="card card-plain">
          <div class="card-header pb-0 text-left">
              <h3 class="font-weight-bolder text-dark">Coletar</h3>
              <p class="mb-0">Registrar coleta do livro</p>
          </div>
          <div class="card-body pb-3">
            <form role="form" method="POST" action="{{ route('reservation.collect') }}">
              @csrf
              @method('PUT')
              <div class="row">
                <div class="col-md-12">
                  <label for="field-rf-id">RF ID</label>
                  <div class="input-group mb-3">
                    <input
                      type="number"
                      class="form-control"
                      placeholder="Digite o RF ID do livro"
                      aria-label="RF ID"
                      id="field-rf-id"
                      name="rf_id"
                      required
                    />
                  </div>
                </div>
              </div>
              <div class="text-center">
                <button type="submit" class="btn btn-dark btn-lg btn-rounded w-100 mt-4">Coletar</button>
                <button
                  type="button"
                  class="btn btn-light btn-lg btn-rounded w-100 mb-2"
                  data-bs-dismiss="modal"
                >Cancelar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
