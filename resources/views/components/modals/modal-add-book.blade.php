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
                ] as $field)
                  <div class="col-md-6">
                    <label for="field-{{ $field->name }}">{{ $field->label }}</label>
                    <div class="input-group mb-3">
                      <input
                        type="{{ $field->type }}"
                        class="form-control"
                        placeholder="{{ $field->label }}"
                        aria-label="{{ $field->label }}"
                        id="field-{{ $field->name }}"
                        name="{{ $field->name . (isset($field->is_array) ? '[]':'' )}}"
                        required
                      />
                    </div>
                  </div>
                @endforeach
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
</div>
