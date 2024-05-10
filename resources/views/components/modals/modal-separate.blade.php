<!-- Modal -->
<div class="modal fade" id="modalSeparate" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-body p-0">
        <button
          type="button"
          class="d-none"
          id="openModalSeparate"
          data-bs-toggle="modal" data-bs-target="#modalSeparate"
        ></button>
        <div class="card card-plain">
          <div class="card-header pb-0 text-left">
              <h3 class="font-weight-bolder text-dark">Separar Livro</h3>
              <p class="mb-0">Finalize a solicitação de reserva separando o livro</p>
          </div>
          <div class="card-body pb-3">
            <div class="row">
              <div class="col-md-12">
                <label for="field-separate-rf-id">RF ID</label>
                <div class="input-group mb-3">
                  <input
                    type="number"
                    class="form-control"
                    placeholder="Digite o RF ID do livro"
                    aria-label="RF ID"
                    id="field-separate-rf-id"
                  />
                </div>
              </div>
            </div>
            <div class="text-center">
              <button
                type="button"
                class="btn btn-dark btn-lg btn-rounded w-100 mt-4"
                onclick="handleSubmitSeparate()"
              >Separar</button>
              <button
                type="button"
                class="btn btn-light btn-lg btn-rounded w-100 mb-2"
                data-bs-dismiss="modal"
              >Cancelar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
    let currentBookToSeparate = undefined;

    function handleSeparateBook(transfer_id){
      document.getElementById('openModalSeparate').click();
      currentBookToSeparate = transfer_id;
    }
    function handleSubmitSeparate(){
      if(!currentBookToSeparate){
        notify('Não foi possível identificar a qual transferência se refere');
        return;
      }

      const rf_id = document.getElementById('field-separate-rf-id').value;

      if(!rf_id){
        notify('É obrigatório inserir o RF-ID');
        return;
      }

      const baseURL = "{{ substr(route('reservation.separate', ['transfer_id' => 0,'rf_id' => 0]),0,-3) }}";
      const url = `${baseURL}${currentBookToSeparate}/${rf_id}`;
      window.location.href = url;
    }
    
  </script>
</div>
