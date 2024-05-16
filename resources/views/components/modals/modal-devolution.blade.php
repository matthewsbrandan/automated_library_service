<div class="modal fade" id="modalDevolution" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-body p-0">
        <div class="card card-plain">
          <div class="card-header pb-0 text-left">
              <h3 class="font-weight-bolder text-dark">Registrar Devolução</h3>
              <p class="mb-0">Registre manualmente a devoluções de algum livro</p>
          </div>
          <div class="card-body pb-3">
            <div class="row">
              <div class="col-md-12">
                <label for="field-devolution-rf-id">RF ID</label>
                <div class="input-group mb-3">
                  <input
                    type="text"
                    class="form-control"
                    placeholder="Digite o RF ID do livro"
                    aria-label="RF ID"
                    id="field-devolution-rf-id"
                    required
                  />
                </div>
              </div>
            </div>
            <div class="text-center">
              <button
                type="button"
                class="btn btn-dark btn-lg btn-rounded w-100 mt-4"
                onclick="handleRegisterDevolution()"
              >Registrar</button>
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
    async function handleRegisterDevolution(){
      const rf_id = document.getElementById('field-devolution-rf-id')?.value;
      if(!rf_id){
        notify('danger', 'É obrigatório informar o rf_id do livro');
        return;
      }
      
      const res = await api.post('{{ route('api.devolution') }}', { rf_id });

      if(!res.result){
        notify('danger', res.response);
        return;
      }

      notify('success', res.response);
      window.location.reload();
    }
  </script>
</div>
