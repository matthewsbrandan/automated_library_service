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
            <form role="form text-left" method="POST" action="{{ route('manage.book.store') }}">
              @csrf
              <div class="row">
                <div class="col-md-12">
                  <label for="field-isbn">ISBN</label>
                  <div class="input-group mb-3">
                    <input
                      type="number"
                      class="form-control"
                      placeholder="Digite o ISBN do livro"
                      aria-label="ISBN"
                      id="field-isbn"
                      name="isbn"
                      required
                    />
                    <button
                      type="button"
                      class="btn btn-light btn-sm btn-e-rounded mb-0"
                      onclick="completeWithISBN()"
                    >Buscar</button>
                  </div>
                </div>
                @foreach ([
                  (object)[
                    'name' => 'title', 'label' => 'Título', 'type' => 'text',
                    'placeholder' => 'Digite o título', 'required' => true
                  ], (object)[
                    'name' => 'subtitle', 'label' => 'Subtítulo', 'type' => 'text',
                    'placeholder' => 'Digite o subtítulo', 'required' => false
                  ], (object)[
                    'name' => 'authors', 'label' => 'Autores', 'type' => 'text',
                    'placeholder' => 'Digite os autores separados por virgula', 'required' => true
                  ], (object)[
                    'name' => 'published_date', 'label' => 'Data de Publicação', 'type' => 'text',
                    'placeholder' => 'Digite a data de publicação', 'required' => true
                  ], (object)[
                    'name' => 'description', 'label' => 'Descrição', 'type' => 'text',
                    'placeholder' => 'Digite a descrição', 'required' => true
                  ], (object)[
                    'name' => 'categories', 'label' => 'Categorias', 'type' => 'text',
                    'placeholder' => 'Digite as categorias separadas por virgula', 'required' => false
                  ], (object)[
                    'name' => 'image', 'label' => 'Imagem', 'type' => 'url',
                    'placeholder' => 'Digite a url da imagem', 'required' => false
                  ] 
                ] as $field)
                  <div class="col-md-6">
                    <label for="field-{{ $field->name }}">{{ $field->label }}</label>
                    <div class="input-group mb-3">
                      <input
                        type="{{ $field->type }}"
                        class="form-control"
                        placeholder="{{ $field->placeholder }}"
                        aria-label="{{ $field->label }}"
                        id="field-{{ $field->name }}"
                        name="{{ $field->name }}"
                        required="{{ $field->required ? 'true': 'false' }}"
                      />
                    </div>
                  </div>
                @endforeach
                <div class="col-md-6"></div>
                <div class="col-md-6">
                  <label for="field-rf-id">RF-ID</label>
                  <div class="input-group mb-3">
                    <input
                      type="number"
                      class="form-control"
                      placeholder="Digite o RF-ID do livro"
                      aria-label="RF-ID"
                      id="field-rf-id"
                      v-model="curr_rf_id"
                    />
                    <button
                      type="button"
                      class="btn btn-light btn-sm btn-e-rounded mb-0"
                      v-on:click="addNewRfId()"
                    >Adicionar</button>
                  </div>
                  <p class="text-sm text-secondary px-2">
                    Adicione o rf-id de cada unidade de livro.
                  </p>
                </div>
                <div class="col-md-6">
                  <label for="field-rf-id">RF-IDs</label>
                  <ul class="list-group">
                    <li class="list-group-item text-secondary text-sm" v-if="rf_ids.length === 0">Adicione pelo menos 1 RF-ID</li>
                    <li class="list-group-item d-flex align-items-center justify-content-between" v-for="rf_id in rf_ids" :key="rf_id">
                      <span>@{{ rf_id }}</span>
                      <button type="button" class="p-1 btn m-0" v-on:click="removeRfId(rf_id)">
                        <i class="fas fa-trash" aria-hidden="true"></i>
                      </button>
                    </li>
                  </ul>
                  <input type="hidden" name="rf_ids" v-bind:value="JSON.stringify(rf_ids ?? [])"/>
                </div>
              </div>
              <div class="text-center">
                <button type="submit" class="btn btn-dark btn-lg btn-rounded w-100 mt-4">Cadastrar</button>
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
  @php if(!isset($isVueStarted)){ $isVueStarted = true; @endphp
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14"></script>
  @php } @endphp  
  <script>
    function completeWithISBN(){      
      const isbn = document.getElementById('field-isbn').value;

      if(!isbn){
        notify('danger', 'O ISBN é obrigatório para realizar a busca');
        return;
      }
      if(isbn.length !== 10 && isbn.length !== 13){
        notify('danger', 'ISBN inválido. Digite um valor válido');
        return;
      }
      
      const url = `https://www.googleapis.com/books/v1/volumes?q=isbn:${isbn}`;
      fetch(url).then((response) => response.json()).then(function (response) {
        if(!response || !response.items || response.items.length === 0 || !response.items[0].volumeInfo){
          notify('danger', 'Livro não encontrado');
          return;
        }
        
        const volumeInfo = response.items[0].volumeInfo;
        if(volumeInfo?.title) document.getElementById('field-title').value = volumeInfo.title;
        if(volumeInfo?.subtitle) document.getElementById('field-subtitle').value = volumeInfo.subtitle;
        if(volumeInfo?.publishedDate) document.getElementById('field-published_date').value = volumeInfo.publishedDate;
        if(volumeInfo?.description) document.getElementById('field-description').value = volumeInfo.description;
        if(volumeInfo?.imageLinks?.thumbnail) document.getElementById('field-image').value = volumeInfo.imageLinks.thumbnail;
        if(volumeInfo?.authors) document.getElementById('field-authors').value = volumeInfo.authors.join(',');
        if(volumeInfo?.categories) document.getElementById('field-categories').value = volumeInfo.categories.join(',');
      });
    }

    const appAddBook = new Vue({
      el: '#modalAddBook',
      data: {
        curr_rf_id: '',
        rf_ids: []
      },
      methods: {
        addNewRfId: function(){
          if(!this.curr_rf_id){
            notify('danger', 'É obrigatório preencher o RF-ID')
            return;
          }
          
          if(this.rf_ids.find((id) => id === this.curr_rf_id)){
            notify('danger', 'Este RF-ID já foi adicionado')
            return;
          }

          this.rf_ids.push(this.curr_rf_id);
          this.curr_rf_id = '';
        },
        removeRfId: function(rf_id){
          this.rf_ids = this.rf_ids.filter((id) => id !== rf_id)
        }
      }
    });
    
  </script>
</div>
