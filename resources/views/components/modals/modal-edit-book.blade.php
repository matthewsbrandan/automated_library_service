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
                  (object)['name' => 'isbn',           'label' => 'ISBN',           'type' => 'text'  ],
                  (object)['name' => 'title',          'label' => 'Title',          'type' => 'text'  ],
                  (object)['name' => 'subtitle',       'label' => 'Subtitle',       'type' => 'text'  ],
                  (object)['name' => 'authors',        'label' => 'Authors',        'type' => 'text', 'is_array' => true ],
                  (object)['name' => 'published_date', 'label' => 'Published Date', 'type' => 'text'  ],
                  (object)['name' => 'description',    'label' => 'Description',    'type' => 'text'  ],
                  (object)['name' => 'categories',     'label' => 'Categories',     'type' => 'text', 'is_array' => true ],
                  (object)['name' => 'image',          'label' => 'Image',          'type' => 'url'   ],
                  (object)['name' => 'stock',          'label' => 'Stock',          'type' => 'number'],
                  (object)['name' => 'available',      'label' => 'Available',      'type' => 'number'],  
                  (object)['name' => 'reserved',       'label' => 'Reserved',       'type' => 'number'],
                  (object)['name' => 'borrowed',       'label' => 'Borrowed',       'type' => 'number'],
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
                        required
                      />
                    </div>
                  </div>
                @endforeach
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
    function notify(type, message){
      alert(message)
    }
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
        stock: 0, available: 0, reserved: 0, borrowed: 0
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
          this.stock = current_book.stock;
          this.available = current_book.available;
          this.reserved = current_book.reserved;
          this.borrowed = current_book.borrowed;

          const update_url = `{{ substr(route('manage.book.update', ['id'=> '0']),0,-1) }}${current_book.id}`;
          document.getElementById('form-modal-edit-book').action = update_url;
          const delete_url = `{{ substr(route('manage.book.delete', ['id' => '0']),0,-1) }}${current_book.id}`;
          document.getElementById('form-modal-delete-book').action = delete_url;
        }
      }
    })
  </script>
</div>