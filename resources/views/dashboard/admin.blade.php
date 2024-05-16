<x-app-layout>

  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <x-app.navbar />
    <div class="container-fluid py-4 px-5">
      <div class="row">
        <div class="col-md-12">
          <div class="d-md-flex align-items-center mb-3 mx-2">
            <div class="mb-md-0 mb-3">
              <h3 class="font-weight-bold mb-0">Olá, {{ auth()->user()->name }}</h3>
              <p class="mb-0">Como está a biblioteca hoje?</p>
            </div>
            <button
              type="button"
              class="btn btn-sm btn-white btn-icon d-flex align-items-center mb-0 ms-md-auto me-2"
              data-bs-toggle="modal" data-bs-target="#modalCollect"
            >
              <span class="btn-inner--icon">
                <span class="p-1 bg-success rounded-circle d-flex ms-auto me-2">
                  <span class="visually-hidden">New</span>
                </span>
              </span>
              <span class="btn-inner--text">Registrar Coleta</span>
            </button>
            <button
              type="button"
              class="btn btn-sm btn-dark btn-icon d-flex align-items-center mb-0"
              data-bs-toggle="modal" data-bs-target="#modalDevolution"
            >
              <span class="btn-inner--icon">
                <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg" fill="none"
                  viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="d-block me-2">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                </svg>
              </span>
              <span class="btn-inner--text">Registrar Devolução</span>
            </button>
          </div>
        </div>
      </div>
      <div class="row my-4">
        <div class="col-lg-4 col-md-6 mb-md-0 mb-4">
          <div class="card shadow-xs border h-100">
            <div class="card-header pb-0">
              <h6 class="font-weight-semibold text-lg mb-0">Coletas / Devoluções</h6>
              <p class="text-sm">Somatória registrada nos últimos dias</p>
              <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                <input type="radio" class="btn-check" name="btnradio" id="btnradio1"
                  autocomplete="off" checked>
                <label class="btn btn-white px-3 mb-0" for="btnradio1">12 meses</label>
                <input type="radio" class="btn-check" name="btnradio" id="btnradio2"
                  autocomplete="off">
                <label class="btn btn-white px-3 mb-0" for="btnradio2">30 dias</label>
                <input type="radio" class="btn-check" name="btnradio" id="btnradio3"
                  autocomplete="off">
                <label class="btn btn-white px-3 mb-0" for="btnradio3">7 dias</label>
              </div>
            </div>
            <div class="card-body py-3">
              <div class="chart mb-2">
                <canvas id="chart-bars" class="chart-canvas" height="240"></canvas>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-8 col-md-6">
          <div class="card shadow-xs border">
            <div class="card-header border-bottom pb-0">
              <div class="d-sm-flex align-items-center mb-3">
                <h6 class="font-weight-semibold text-lg mb-0">Próximas Coletas / Devoluções</h6>
              </div>
              <div class="pb-3 d-sm-flex align-items-center">
                <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                  <input type="radio" class="btn-check" name="btnradiotable" id="btnradiotable1"
                    autocomplete="off" checked>
                  <label class="btn btn-white px-3 mb-0" for="btnradiotable1">Todos</label>
                  <input type="radio" class="btn-check" name="btnradiotable" id="btnradiotable2"
                    autocomplete="off">
                  <label class="btn btn-white px-3 mb-0" for="btnradiotable2">Coletas</label>
                  <input type="radio" class="btn-check" name="btnradiotable" id="btnradiotable3"
                    autocomplete="off">
                  <label class="btn btn-white px-3 mb-0" for="btnradiotable3">Devoluções</label>
                </div>
                <div class="input-group w-sm-25 ms-auto">
                  <span class="input-group-text text-body">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px"
                      fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                      stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z">
                      </path>
                    </svg>
                  </span>
                  <input type="text" class="form-control" placeholder="Pesquisar">
                </div>
              </div>
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
                    @if($transfers->count() === 0)
                      <tr>
                        <td colspan="3">
                          <small class="w-100 py-3 d-block text-center">Você não possui reservas</small>
                        </td>
                      </tr>
                    @endif
                    @foreach($transfers as $transfer)
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
                          @if($transfer->status === 'reserved')
                            <span class="badge badge-success text-xs">p/ coleta</span>
                          @elseif($transfer->status === 'borrowed')
                            <span class="badge badge-primary text-xs">p/ devolução</span>
                          @elseif($transfer->status === 'expired')
                            <span class="badge badge-danger text-xs">devolução expirada</span>
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
      </div>
      <div class="row">
        <div class="col-xl-3 col-sm-6 mb-xl-0">
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
                    <p class="text-sm text-secondary mb-1">Total de reservas pendentes</p>
                    <h4 class="mb-2 font-weight-bold">{{ $analytics->pendingReservations }}</h4>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0">
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
                    <p class="text-sm text-secondary mb-1">Coletas Vencidas</p>
                    <h4 class="mb-2 font-weight-bold">{{ $analytics->expiratedCollects }}</h4>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0">
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
                    <p class="text-sm text-secondary mb-1">Livros emprestados</p>
                    <h4 class="mb-2 font-weight-bold">{{ $analytics->borroweds }}</h4>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6">
          <div class="card border shadow-xs mb-4">
            <div class="card-body text-start p-3 w-100">
              <div
                class="icon icon-shape icon-sm bg-dark text-white text-center border-radius-sm d-flex align-items-center justify-content-center mb-3">
                <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 24 24" fill="currentColor">
                  <path fill-rule="evenodd"
                    d="M5.25 2.25a3 3 0 00-3 3v4.318a3 3 0 00.879 2.121l9.58 9.581c.92.92 2.39 1.186 3.548.428a18.849 18.849 0 005.441-5.44c.758-1.16.492-2.629-.428-3.548l-9.58-9.581a3 3 0 00-2.122-.879H5.25zM6.375 7.5a1.125 1.125 0 100-2.25 1.125 1.125 0 000 2.25z"
                    clip-rule="evenodd" />
                </svg>
              </div>
              <div class="row">
                <div class="col-12">
                  <div class="w-100">
                    <p class="text-sm text-secondary mb-1">Devoluções em atraso</p>
                    <h4 class="mb-2 font-weight-bold">{{ $analytics->expiratedDevolutions }}</h4>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <x-modals.modal-collect/>
      <x-modals.modal-devolution/>
      <x-app.footer />
    </div>
  </main>
  @php if(!isset($isChartStarted)){ $isChartStarted = true; @endphp
    <script src="../assets/js/plugins/chartjs.min.js"></script>
  @php } @endphp
  <script>
    var ctx = document.getElementById("chart-bars").getContext("2d");
    if(ctx) new Chart(ctx, {
      type: "bar",
      data: {
        labels: {!! json_encode(array_keys(get_object_vars($collectChart))) !!},
        datasets: [{
            label: "Coletas",
            tension: 0.4,
            borderWidth: 0,
            borderSkipped: false,
            backgroundColor: "#2ca8ff",
            data: {!! json_encode(array_values(get_object_vars($collectChart))) !!},
            maxBarThickness: 6
          },
          {
            label: "Devoluções",
            tension: 0.4,
            borderWidth: 0,
            borderSkipped: false,
            backgroundColor: "#7c3aed",
            data: {!! json_encode(array_values(get_object_vars($devolutionChart))) !!},
            maxBarThickness: 6
          },
        ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false,
          },
          tooltip: {
            backgroundColor: '#fff',
            titleColor: '#1e293b',
            bodyColor: '#1e293b',
            borderColor: '#e9ecef',
            borderWidth: 1,
            usePointStyle: true
          }
        },
        interaction: {
          intersect: false,
          mode: 'index',
        },
        scales: {
          y: {
            stacked: true,
            grid: {
              drawBorder: false,
              display: true,
              drawOnChartArea: true,
              drawTicks: false,
              borderDash: [4, 4],
            },
            ticks: {
              beginAtZero: true,
              padding: 10,
              font: {
                size: 12,
                family: "Noto Sans",
                style: 'normal',
                lineHeight: 2
              },
              color: "#64748B"
            },
          },
          x: {
            stacked: true,
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false
            },
            ticks: {
              font: {
                size: 12,
                family: "Noto Sans",
                style: 'normal',
                lineHeight: 2
              },
              color: "#64748B"
            },
          },
        },
      },
    });
  </script>
</x-app-layout>