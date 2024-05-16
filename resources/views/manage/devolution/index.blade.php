<x-app-layout>

  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <x-app.navbar />
    <div class="container-fluid py-4 px-5">
      <div class="row">
        <div class="col-12">
          <div class="card border shadow-xs mb-4">
            {{-- HEADER --}}
            <div class="card-header border-bottom pb-0">
              <div class="d-sm-flex align-items-center mb-3">
                <div>
                  <h6 class="font-weight-semibold text-lg mb-0">Livros p/ Devolução</h6>
                  <p class="text-sm mb-0">Livros aguardando devolução do usuário</p>
                </div>
              </div>
            </div>
            <x-tables.devolutions :transfers="$transfers" :pagination="$pagination"/>
          </div>
        </div>
      </div>
      <x-app.footer />
    </div>
  </main>
</x-app-layout>
