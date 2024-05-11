<!-- Modal -->
<div class="modal fade" id="modalCollectToken" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-body p-0">
        <button type="button" class="d-none" id="btnCallModalCollectToken" data-bs-toggle="modal" data-bs-target="#modalCollectToken"></button>
        <div class="card card-plain">
          <div class="card-header pb-0 text-left">
              <h3 class="font-weight-bolder text-dark">Token de Coleta</h3>
              <p class="mb-0" v-if="!token">Gere o token de coleta para conseguir retirar o livro <b>@{{ book }}</b></p>
              <p class="mb-0" v-if="!!token">Use este token para conseguir retirar o livro <b>@{{ book }}</b></p>
          </div>
          <div class="card-body pb-3">
            <div class="alert alert-secondary py-4 text-sm" v-if="status === 'without-token'">
              Para sua segurança, gere o token apenas quando for retirar o livro.
            </div>
            <div class="alert alert-secondary py-4 text-sm text-center" v-if="status === 'loading'">
              <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
              </div>
            </div>
            <div class="alert alert-danger py-4 text-sm" v-if="status === 'error'">
              @{{ error_message }}
            </div>
            <div class="alert alert-success py-4 text-sm text-center" v-if="status === 'with-token'">
              <b>@{{ token }}</b>
            </div>
            <div class="text-center">
              <button
                type="button"
                class="btn btn-dark btn-lg btn-rounded w-100 mt-4"
                v-if="!token"
                v-on:click="loadToken()"
              >Gerar Token</button>
              <button
                type="button"
                class="btn btn-light btn-lg btn-rounded w-100 mb-2"
                data-bs-dismiss="modal"
              >Fechar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @php if(!isset($isVueStarted)){ $isVueStarted = true; @endphp
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14"></script>
  @php } @endphp  
  <script>
    const appCollectToken = new Vue({
      el: '#modalCollectToken',
      data: {
        book: '',
        transfer_id: '',
        token: undefined,
        error_message: undefined,
        status: 'without-token' // without-token | loading | error | with-token
      },
      methods: {
        loadToken: async function(){
          if(this.status === 'loading') return;

          this.status = 'loading';

          try{
            const res = await api.get(`{{ substr(route('reservation.generate_token',['transfer_id' => 0]),0,-1) }}${this.transfer_id}`);

            if(res.result){
              this.status = 'with-token';
              this.token = res.data;
            }
            else{
              this.status = 'error';
              this.error_message = res.response;
            }
          }catch(e){
            this.status = 'error';
            this.error_message = 'Houve um erro inesperado';
          }
        }
      }
    })

    function handleOpenModalCollectToken({ token, book, transfer_id }){
      document.getElementById('btnCallModalCollectToken').click();

      appCollectToken.$data.token = token;
      appCollectToken.$data.book  = book;
      appCollectToken.$data.transfer_id = transfer_id;
      appCollectToken.$data.error_message = undefined;
      appCollectToken.$data.status = token ? 'with-token' : 'without-token';
    }
  </script>
</div>