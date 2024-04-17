<x-app-layout>

  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <x-app.navbar />
    <div class="container-fluid py-4 px-5">
      <div class="row"> {{-- HEADER --}}
        <div class="col-md-12">
          <div class="d-md-flex align-items-center mb-3 mx-2">
            <div class="mb-md-0 mb-3">
              <h3 class="font-weight-bold mb-0">Olá, {{ auth()->user()->name }}</h3>
              <p class="mb-0">Apps you might like!</p>
            </div>
            <button type="button"
              class="btn btn-sm btn-white btn-icon d-flex align-items-center ms-md-auto mb-sm-0 mb-2 me-2">
              <span class="btn-inner--icon">
                <span class="p-1 bg-success rounded-circle d-flex ms-auto me-2">
                  <span class="visually-hidden">New</span>
                </span>
              </span>
              <span class="btn-inner--text">Coletar</span>
            </button>
            <button type="button" class="btn btn-sm btn-dark btn-icon d-flex align-items-center mb-0">
              <span class="btn-inner--icon">
                <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg" fill="none"
                  viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="d-block me-2">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                </svg>
              </span>
              <span class="btn-inner--text">Devolver</span>
            </button>
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
                            <a href="{{ route('reservation', ['book_id' => $book->id]) }}" class="btn btn-sm btn-dark mt-4">Reservar</a>
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
              <p class="text-sm">Here you have details about the balance.</p>
              <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                <input type="radio" class="btn-check" name="btnradio" id="btnradio1"
                  autocomplete="off" checked>
                <label class="btn btn-white px-3 mb-0" for="btnradio1">12 months</label>
                <input type="radio" class="btn-check" name="btnradio" id="btnradio2"
                  autocomplete="off">
                <label class="btn btn-white px-3 mb-0" for="btnradio2">30 days</label>
                <input type="radio" class="btn-check" name="btnradio" id="btnradio3"
                  autocomplete="off">
                <label class="btn btn-white px-3 mb-0" for="btnradio3">7 days</label>
              </div>
            </div>
            <div class="card-body py-3">
              <div class="chart mb-2">
                <canvas id="chart-bars" class="chart-canvas" height="240"></canvas>
              </div>
              <button class="btn btn-white mb-0 ms-auto">View report</button>
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
                            <div class="avatar avatar-sm rounded-circle bg-gray-100 me-2 my-2">
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
      <div class="row">
        <div class="col-xl-4 col-sm-6 mb-xl-0">
          <div class="card border shadow-xs mb-4">
            <div class="card-body text-start p-3 w-100">
              <div
                class="icon icon-shape icon-sm bg-dark text-white text-center border-radius-sm d-flex align-items-center justify-content-center mb-3">
                <svg height="16" width="16" xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 24 24" fill="currentColor">
                  <path d="M4.5 3.75a3 3 0 00-3 3v.75h21v-.75a3 3 0 00-3-3h-15z" />
                  <path fill-rule="evenodd"
                    d="M22.5 9.75h-21v7.5a3 3 0 003 3h15a3 3 0 003-3v-7.5zm-18 3.75a.75.75 0 01.75-.75h6a.75.75 0 010 1.5h-6a.75.75 0 01-.75-.75zm.75 2.25a.75.75 0 000 1.5h3a.75.75 0 000-1.5h-3z"
                    clip-rule="evenodd" />
                </svg>
              </div>
              <div class="row">
                <div class="col-12">
                  <div class="w-100">
                    <p class="text-sm text-secondary mb-1">Livros Reservados</p>
                    <h4 class="mb-2 font-weight-bold">$99,118.5</h4>
                    <div class="d-flex align-items-center">
                      <span class="text-sm text-success font-weight-bolder">
                        <i class="fa fa-chevron-up text-xs me-1"></i>10.5%
                      </span>
                      <span class="text-sm ms-1">from $89,740.00</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-4 col-sm-6 mb-xl-0">
          <div class="card border shadow-xs mb-4">
            <div class="card-body text-start p-3 w-100">
              <div
                class="icon icon-shape icon-sm bg-dark text-white text-center border-radius-sm d-flex align-items-center justify-content-center mb-3">
                <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 24 24" fill="currentColor">
                  <path fill-rule="evenodd"
                    d="M7.5 5.25a3 3 0 013-3h3a3 3 0 013 3v.205c.933.085 1.857.197 2.774.334 1.454.218 2.476 1.483 2.476 2.917v3.033c0 1.211-.734 2.352-1.936 2.752A24.726 24.726 0 0112 15.75c-2.73 0-5.357-.442-7.814-1.259-1.202-.4-1.936-1.541-1.936-2.752V8.706c0-1.434 1.022-2.7 2.476-2.917A48.814 48.814 0 017.5 5.455V5.25zm7.5 0v.09a49.488 49.488 0 00-6 0v-.09a1.5 1.5 0 011.5-1.5h3a1.5 1.5 0 011.5 1.5zm-3 8.25a.75.75 0 100-1.5.75.75 0 000 1.5z"
                    clip-rule="evenodd" />
                  <path
                    d="M3 18.4v-2.796a4.3 4.3 0 00.713.31A26.226 26.226 0 0012 17.25c2.892 0 5.68-.468 8.287-1.335.252-.084.49-.189.713-.311V18.4c0 1.452-1.047 2.728-2.523 2.923-2.12.282-4.282.427-6.477.427a49.19 49.19 0 01-6.477-.427C4.047 21.128 3 19.852 3 18.4z" />
                </svg>
              </div>
              <div class="row">
                <div class="col-12">
                  <div class="w-100">
                    <p class="text-sm text-secondary mb-1">Livros Emprestados</p>
                    <h4 class="mb-2 font-weight-bold">376</h4>
                    <div class="d-flex align-items-center">
                      <span class="text-sm text-success font-weight-bolder">
                        <i class="fa fa-chevron-up text-xs me-1"></i>55%
                      </span>
                      <span class="text-sm ms-1">from 243</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-4 col-sm-6 mb-xl-0">
          <div class="card border shadow-xs mb-4">
            <div class="card-body text-start p-3 w-100">
              <div
                class="icon icon-shape icon-sm bg-dark text-white text-center border-radius-sm d-flex align-items-center justify-content-center mb-3">
                <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 24 24" fill="currentColor">
                  <path fill-rule="evenodd"
                    d="M3 6a3 3 0 013-3h12a3 3 0 013 3v12a3 3 0 01-3 3H6a3 3 0 01-3-3V6zm4.5 7.5a.75.75 0 01.75.75v2.25a.75.75 0 01-1.5 0v-2.25a.75.75 0 01.75-.75zm3.75-1.5a.75.75 0 00-1.5 0v4.5a.75.75 0 001.5 0V12zm2.25-3a.75.75 0 01.75.75v6.75a.75.75 0 01-1.5 0V9.75A.75.75 0 0113.5 9zm3.75-1.5a.75.75 0 00-1.5 0v9a.75.75 0 001.5 0v-9z"
                    clip-rule="evenodd" />
                </svg>
              </div>
              <div class="row">
                <div class="col-12">
                  <div class="w-100">
                    <p class="text-sm text-secondary mb-1">Devoluções Vencidas</p>
                    <h4 class="mb-2 font-weight-bold">$450.53</h4>
                    <div class="d-flex align-items-center">
                      <span class="text-sm text-success font-weight-bolder">
                        <i class="fa fa-chevron-up text-xs me-1"></i>22%
                      </span>
                      <span class="text-sm ms-1">from $369.30</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <x-app.footer />
    </div>
  </main>

</x-app-layout>
