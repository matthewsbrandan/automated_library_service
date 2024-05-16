<x-app-layout>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <x-app.navbar />
    <div class="container-fluid py-4 px-5">
      <div class="row">
        <div class="col-12">
          <div class="card border shadow-xs mb-4">
            {{-- HEADER --}}
            <div class="card-header border-bottom pb-0">
              <div class="d-sm-flex align-items-center">
                <div>
                  <h6 class="font-weight-semibold text-lg mb-0">Livros</h6>
                  <p class="text-sm">Acervo de livros da biblioteca</p>
                </div>
                <div class="ms-auto d-flex">
                  <button
                    type="button"
                    class="btn btn-sm btn-white me-2"
                    data-bs-toggle="modal" data-bs-target="#modalAddBook"
                  >Adicionar Livro</button>
                </div>
              </div>
            </div>
            <x-tables.books :pagination="$pagination" :books="$books"/>
          </div>
        </div>
      </div>
      <x-app.footer />
    </div>
  </main>
  <x-modals.modal-add-book/>
  <script>
    const books = {!! $books->toJson() !!};
  </script>
  <x-modals.modal-edit-book/>
</x-app-layout>
