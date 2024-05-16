<div class="modal fade" id="modalCollect" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-body p-0">
        <div class="card card-plain">
          <div class="card-header pb-0 text-left">
              <h3 class="font-weight-bolder text-dark">Registrar Coleta</h3>
              <p class="mb-0">Registre manualmente a coleta  de algum livro</p>
          </div>
          <div class="card-body pb-3">
            <div class="row">
              <div class="col-md-12">
                <label for="field-collect-token">Token</label>
                <div class="input-group mb-3">
                  <input
                    type="text"
                    class="form-control"
                    placeholder="Digite o Token de coleta"
                    aria-label="Token"
                    id="field-collect-token"
                    required
                  />
                </div>
              </div>
            </div>
            <div class="text-center">
              <button
                type="button"
                class="btn btn-dark btn-lg btn-rounded w-100 mt-4"
                onclick="handleRegisterCollect()"
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
    async function handleRegisterCollect(){
      const token = document.getElementById('field-collect-token')?.value;
      if(!token){
        notify('danger', 'É obrigatório informar o token de coleta');
        return;
      }
      
      const res = await api.post('{{ route('api.collect') }}', { token });

      if(!res.result){
        notify('danger', res.response);
        return;
      }

      notify('success', res.response);
      window.location.reload();
    }
  </script>
</div>
