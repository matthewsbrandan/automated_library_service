<div class="card shadow-xs border" id="table-next-collect-devolutions">
  <div class="card-header border-bottom pb-0">
    <div class="d-sm-flex align-items-center mb-3">
      <h6 class="font-weight-semibold text-lg mb-0">Próximas Coletas / Devoluções</h6>
    </div>
    <div class="pb-3 d-sm-flex align-items-center">
      <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
        <input
          type="radio" class="btn-check"
          id="next-collect-devolutions-all" autocomplete="off"
          v-bind:checked="filter === 'all' ? true : false"
          v-on:click="filter = 'all'"
        />
        <label class="btn btn-white px-3 mb-0" for="next-collect-devolutions-all">Todos</label>
        <input
          type="radio" class="btn-check"
          id="next-collect-devolutions-collect" autocomplete="off"
          v-bind:checked="filter === 'collects' ? true : false"
          v-on:click="filter = 'collects'"
        />
        <label class="btn btn-white px-3 mb-0" for="next-collect-devolutions-collect">Coletas</label>
        <input
          type="radio" class="btn-check"
          id="next-collect-devolutions-devolutions" autocomplete="off"
          v-bind:checked="filter === 'devolutions' ? true : false"
          v-on:click="filter = 'devolutions'"
        />
        <label class="btn btn-white px-3 mb-0" for="next-collect-devolutions-devolutions">Devoluções</label>
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
        <input type="text" class="form-control" placeholder="Pesquisar" v-model="search">
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
            <tr v-if="(
              filter === 'all' || (
                filter === 'collects' && '{{ $transfer->status }}' === 'reserved'
              ) || (
                filter === 'devolutions' && ['borrowed','expired'].includes('{{ $transfer->status }}')
              )
            ) && (
              !search || '{{ $transfer->book->title }}'.toLowerCase().includes(search.toLowerCase())
            )">
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
  @php if(!isset($isVueStarted)){ $isVueStarted = true; @endphp
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14"></script>
  @php } @endphp
  <script>
    new Vue({
      el: '#table-next-collect-devolutions',
      data: { filter: 'all', search: '' },
      methods: { }
    })
  </script>
</div>