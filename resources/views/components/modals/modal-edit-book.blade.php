<div class="modal fade" id="modalEditBook" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-body p-0">
        <button
          type="button"
          class="d-none"
          id="openModalEditBook"
          data-bs-toggle="modal" data-bs-target="#modalEditBook"
          v-on:click="open()"
        ></button>
        <div class="card card-plain">
          <div class="card-header pb-0 text-left">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <h3 class="font-weight-bolder text-dark">Editar Livro</h3>
                <p class="mb-0">Edite os detalhes do livro</p>
              </div>
  
              <form method="POST" id="form-modal-delete-book">
                @csrf
                @method('DELETE')
                <button type="submit" class="p-2 btn">
                  <i class="fas fa-trash" aria-hidden="true"></i>
                </button>
              </form>
            </div>
          </div>
          <div class="card-body pb-3">
            <form role="form text-left" method="POST" id="form-modal-edit-book">
              @csrf
              @method('PUT')
              <div class="row">
                @foreach ([
                  (object)[
                    'name' => 'isbn', 'label' => 'ISBN', 'type' => 'text',
                    'placeholder' => 'Digite o ISBN do livro', 'required' => false
                  ], (object)[
                    'name' => 'title', 'label' => 'Título', 'type' => 'text',
                    'placeholder' => 'Digite o título', 'required' => true
                  ], (object)[
                    'name' => 'subtitle', 'label' => 'Subtítulo', 'type' => 'text',
                    'placeholder' => 'Digite o subtítulo', 'required' => false
                  ], (object)[
                    'name' => 'authors', 'label' => 'Autores', 'type' => 'text', 'is_array' => true,
                    'placeholder' => 'Digite os autores separados por virgula', 'required' => true
                  ], (object)[
                    'name' => 'published_date', 'label' => 'Data de Publicação', 'type' => 'text',
                    'placeholder' => 'Digite a data de publicação', 'required' => true
                  ], (object)[
                    'name' => 'description', 'label' => 'Descrição', 'type' => 'text',
                    'placeholder' => 'Digite a descrição', 'required' => true
                  ], (object)[
                    'name' => 'categories', 'label' => 'Categorias', 'type' => 'text', 'is_array' => true,
                    'placeholder' => 'Digite as categorias separadas por virgula', 'required' => false
                  ], (object)[
                    'name' => 'image', 'label' => 'Imagem', 'type' => 'url',
                    'placeholder' => 'Digite a url da imagem', 'required' => false
                  ]
                ] as $field)
                  <div class="col-md-6">
                    <label for="field-update-{{ $field->name }}">{{ $field->label }}</label>
                    <div class="input-group mb-3">
                      <input
                        type="{{ $field->type }}"
                        class="form-control"
                        placeholder="{{ $field->label }}"
                        aria-label="{{ $field->label }}"
                        id="field-update-{{ $field->name }}"
                        v-model="{{ $field->name }}"
                        name="{{ $field->name . (isset($field->is_array) ? '[]':'' )}}"
                        {{ $field->required ? 'required':'' }}
                      />
                    </div>
                  </div>
                @endforeach
                <div class="col-md-6">
                  <label for="field-rf-id">RF-ID</label>
                  <div class="input-group mb-3">
                    <input
                      type="text"
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
                <button type="submit" class="btn btn-dark btn-lg btn-rounded w-100 mt-4">Atualizar</button>
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
    let current_book = null;
    function handleOpenEditBook(id){
      const findedBook = books.find((book) => book.id === id);
      if(!findedBook){
        notify('error', 'Livro não encontrado');
        return;
      }

      current_book = findedBook;
      document.getElementById('openModalEditBook').click();
    }

    const app = new Vue({
      el: '#modalEditBook',
      data: {
        authors: [], categories: [],
        isbn: '', title: '', subtitle: '',
        published_date: '', description: '', image: '',
        curr_rf_id: '',
        rf_ids: []
      },
      methods: {
        open: function(){
          if(!current_book) return;

          this.isbn = current_book.isbn;
          this.title = current_book.title;
          this.subtitle = current_book.subtitle;
          this.authors = (current_book.authors ?? []).length > 0 ? current_book.authors[0].name:'';
          this.published_date = current_book.published_date;
          this.description = current_book.description;
          this.categories = (current_book.categories ?? []).length > 0 ? current_book.categories[0].name:'';
          this.image = current_book.image;
          this.rf_ids = current_book.book_stocks ? current_book.book_stocks.map(stock => stock.rf_id) : [];

          const update_url = `{{ substr(route('manage.book.update', ['id'=> '0']),0,-1) }}${current_book.id}`;
          document.getElementById('form-modal-edit-book').action = update_url;
          const delete_url = `{{ substr(route('manage.book.delete', ['id' => '0']),0,-1) }}${current_book.id}`;
          document.getElementById('form-modal-delete-book').action = delete_url;
        },
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
    })
  </script>
</div>