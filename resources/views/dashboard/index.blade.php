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
            @if($transfers->count() > 0)
              <button
                type="button"
                class="btn btn-sm btn-white btn-icon d-flex align-items-center ms-md-auto mb-sm-0 mb-2"
                data-bs-toggle="modal" data-bs-target="#modalCollect"
              >
                <span class="btn-inner--icon">
                  <span class="p-1 bg-success rounded-circle d-flex ms-auto me-2">
                    <span class="visually-hidden">New</span>
                  </span>
                </span>
                <span class="btn-inner--text">Coletar</span>
              </button>
            @endif
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
                                <small class="text-secondary">{{ $transfer->expiration }}</small>
                              @endif    
                            </div>
                          </div>
                        </td>
                        <td class="text-end">
                          @if($transfer->status === 'requested')
                            <span class="badge badge-warning text-xs">pendente</span>
                          @else
                            <span class="badge badge-success text-xs">separado</span>
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
                        <td><span class="text-sm font-weight-normal">Wed 3:00pm</span></td>
                        <td class="align-middle">
                          <a href="javascript:;" class="text-secondary font-weight-bold text-xs"
                            data-bs-toggle="tooltip" data-bs-title="Edit user">
                            <svg width="14" height="14" viewBox="0 0 15 16"
                              fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path
                                d="M11.2201 2.02495C10.8292 1.63482 10.196 1.63545 9.80585 2.02636C9.41572 2.41727 9.41635 3.05044 9.80726 3.44057L11.2201 2.02495ZM12.5572 6.18502C12.9481 6.57516 13.5813 6.57453 13.9714 6.18362C14.3615 5.79271 14.3609 5.15954 13.97 4.7694L12.5572 6.18502ZM11.6803 1.56839L12.3867 2.2762L12.3867 2.27619L11.6803 1.56839ZM14.4302 4.31284L15.1367 5.02065L15.1367 5.02064L14.4302 4.31284ZM3.72198 15V16C3.98686 16 4.24091 15.8949 4.42839 15.7078L3.72198 15ZM0.999756 15H-0.000244141C-0.000244141 15.5523 0.447471 16 0.999756 16L0.999756 15ZM0.999756 12.2279L0.293346 11.5201C0.105383 11.7077 -0.000244141 11.9624 -0.000244141 12.2279H0.999756ZM9.80726 3.44057L12.5572 6.18502L13.97 4.7694L11.2201 2.02495L9.80726 3.44057ZM12.3867 2.27619C12.7557 1.90794 13.3549 1.90794 13.7238 2.27619L15.1367 0.860593C13.9869 -0.286864 12.1236 -0.286864 10.9739 0.860593L12.3867 2.27619ZM13.7238 2.27619C14.0917 2.64337 14.0917 3.23787 13.7238 3.60504L15.1367 5.02064C16.2875 3.8721 16.2875 2.00913 15.1367 0.860593L13.7238 2.27619ZM13.7238 3.60504L3.01557 14.2922L4.42839 15.7078L15.1367 5.02065L13.7238 3.60504ZM3.72198 14H0.999756V16H3.72198V14ZM1.99976 15V12.2279H-0.000244141V15H1.99976ZM1.70617 12.9357L12.3867 2.2762L10.9739 0.86059L0.293346 11.5201L1.70617 12.9357Z"
                                fill="#64748B" />
                            </svg>
                          </a>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <x-modals.modal-collect/>
      <x-app.footer/>
    </div>
  </main>

</x-app-layout>
