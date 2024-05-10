<x-app-layout>

  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <x-app.navbar />
    <div class="container-fluid py-4 px-5">
      <div class="row"> {{-- HEADER --}}
        <div class="col-md-12">
          <div class="d-md-flex align-items-center mb-3 mx-2">
            <div class="mb-md-0 mb-3">
              <h3 class="font-weight-bold mb-0">Olá, {{ auth()->user()->name }}</h3>
              <p class="mb-0">Qual livro você irá ler hoje?</p>
            </div>
          </div>
        </div>
      </div>
      <hr class="my-0">
      @if($book_suggestions->count() > 0)
        <div class="row">
          <div class="position-relative overflow-hidden">
            <div class="swiper mySwiper mt-4 mb-2">
              <div class="swiper-wrapper">
                @foreach($book_suggestions as $book)
                  <div class="swiper-slide">
                    <div>
                      <div class="card card-background shadow-none border-radius-xl card-background-after-none align-items-start mb-0 border">
                        <div class="card-body text-start px-3 py-3 w-100 d-flex">
                          <img src="{{ $book->image }}" class="rounded-lg border-none" alt="{{ $book->title }}" style="
                            width: 10rem;
                            max-width: 10rem;
                            background: black;
                            height: 18rem;
                            flex: 1;
                            object-fit: cover;
                          "/>
                          <div class="ms-3 ps-3" style="border-left: 1px solid #0001;">
                            <h4 class="text-dark font-weight-bolder">{{ $book->title }}</h4>
                            <p class="text-dark opacity-6 text-xs font-weight-bolder mb-0">Disponíveis</p>
                            <small class="text-dark font-weight-bolder">{{ $book->available }}</small>
                            <p class="text-dark opacity-6 text-xs font-weight-bolder mb-0">Autores</p>
                            <small class="text-dark font-weight-bolder d-block">{{ $book->getAuthorNames()->implode(', ') }}</small>
                            <a href="{{ route('reservation.request', ['book_id' => $book->id]) }}" class="btn btn-sm btn-dark mt-4">Solicitar Reserva</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
          </div>
        </div>
      @endif
      <div class="row my-4">
        <div class="col-lg-4 col-md-6 mb-md-0 mb-4">
          <div class="card shadow-xs border h-100">
            <div class="card-header pb-0">
              <h6 class="font-weight-semibold text-lg mb-0">Suas Reservas</h6>
              <p class="text-sm">As reservas vencem no prazo de 24h</p>
            </div>
            <div class="card-body px-0 py-0">
              <div class="table-responsive p-0">
                <table class="table align-items-center justify-content-center mb-0">
                  <thead class="bg-gray-100">
                    <tr>
                      <th class="text-secondary text-xs font-weight-semibold opacity-7">Livro</th>
                      <th class="text-center text-secondary text-xs font-weight-semibold opacity-7"></th>
                    </tr>
                  </thead>
                  <tbody>
                    @if($reservations->count() === 0)
                      <tr>
                        <td colspan="3">
                          <small class="w-100 py-3 d-block text-center">Você não possui reservas</small>
                        </td>
                      </tr>
                    @endif
                    @foreach($reservations as $transfer)
                      <tr>
                        <td>
                          <div class="d-flex px-2">
                            <div class="avatar avatar-sm rounded-md bg-gray-100 me-2 my-2">
                              <img src="{{ $transfer->book->image }}" class="w-80" alt="spotify">
                            </div>
                            <div class="my-auto">
                              <h6 class="mb-0 text-sm">{{ $transfer->book->title }}</h6>
                              @if($transfer->status === 'reserved' && $transfer->expiration)
                                <small class="text-secondary">{{ $transfer->getExpiration() }}</small>
                              @endif    
                            </div>
                          </div>
                        </td>
                        <td class="text-end">
                          @if($transfer->status === 'requested')
                            <span class="badge badge-warning text-xs">pendente</span>
                          @else
                            <button
                              type="button"
                              class="btn btn-sm btn-white btn-icon d-flex align-items-center ms-auto my-auto me-2"
                              onclick="handleOpenModalCollectToken({ token: '{{ $transfer->token }}', book: '{{ $transfer->book->title }}', rf_id: '{{ $transfer->rf_id }}' })"
                            >
                              <span class="btn-inner--icon">
                                <span class="p-1 bg-success rounded-circle d-flex ms-auto me-2">
                                  <span class="visually-hidden">New</span>
                                </span>
                              </span>
                              <span class="btn-inner--text">
                                @if($transfer->token) Ver Token @else Gerar Token @endif
                              </span>
                            </button>
                          @endif
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-8 col-md-6">
          <div class="card shadow-xs border">
            <div class="card-header border-bottom pb-0">
              <div class="d-sm-flex align-items-center justify-content-between mb-3">
                <div>
                  <h6 class="font-weight-semibold text-lg mb-0">Livros Emprestados</h6>
                  <p class="text-sm mb-sm-0 mb-2">Este são os livros que estão em sua posse</p>
                </div>
                <div>
                  <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                    <input type="radio" class="btn-check" name="btnradiotable" id="btnradiotable1" autocomplete="off" checked>
                    <label class="btn btn-white px-3 mb-0" for="btnradiotable1">Todos</label>
                    <input type="radio" class="btn-check" name="btnradiotable" id="btnradiotable2" autocomplete="off">
                    <label class="btn btn-white px-3 mb-0" for="btnradiotable2">Vencidos</label>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-body px-0 py-0">
              <div class="table-responsive p-0">
                <table class="table align-items-center justify-content-center mb-0">
                  <thead class="bg-gray-100">
                    <tr>
                      <th class="text-secondary text-xs font-weight-semibold opacity-7">Livro</th>
                      <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Expiração</th>
                      <th class="text-center text-secondary text-xs font-weight-semibold opacity-7"></th>
                    </tr>
                  </thead>
                  <tbody>
                    @if($transfers->count() === 0)
                      <tr>
                        <td colspan="3">
                          <small class="w-100 py-3 d-block text-center">Você não possui nenhum livro</small>
                        </td>
                      </tr>
                    @endif
                    @foreach($transfers as $transfer)
                      <tr>
                        <td>
                          <div class="d-flex px-2">
                            <div class="avatar avatar-sm rounded-md bg-gray-100 me-2 my-2">
                              <img src="{{ $transfer->book->image }}"
                                class="w-80" alt="spotify">
                            </div>
                            <div class="my-auto">
                              <h6 class="mb-0 text-sm">{{ $transfer->book->title }}</h6>
                            </div>
                          </div>
                        </td>
                        <td><span class="text-sm font-weight-normal">{{ $transfer->getExpiration() }}</span></td>
                        <td class="align-middle"></td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <x-modals.modal-collect-token/>
      <x-app.footer/>
    </div>
  </main>

</x-app-layout>
