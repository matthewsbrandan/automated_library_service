<div class="card-body px-0 py-0">
  <div id="table-devolutions">
    <div class="border-bottom py-3 px-3 d-sm-flex align-items-center">
      <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
        <input 
          type="radio" class="btn-check"
          name="btnradiotable" id="btn-table-devolutions-all"
          autocomplete="off"
          v-bind:checked="filter === 'all' ? true : false"
          v-on:click="filter = 'all'"
        >
        <label class="btn btn-white px-3 mb-0" for="btn-table-devolutions-all">Todos</label>
        <input 
          type="radio" class="btn-check"
          name="btnradiotable" id="btn-table-devolutions-pending"
          autocomplete="off"
          v-bind:checked="filter === 'pending' ? true : false"
          v-on:click="filter = 'pending'"
        >
        <label class="btn btn-white px-3 mb-0" for="btn-table-devolutions-pending">Pendentes</label>
        <input 
          type="radio" class="btn-check"
          name="btnradiotable" id="btn-table-devolutions-late"
          autocomplete="off"
          v-bind:checked="filter === 'late' ? true : false"
          v-on:click="filter = 'late'"
        >
        <label class="btn btn-white px-3 mb-0" for="btn-table-devolutions-late">Atrasados</label>
      </div>
      <div class="input-group w-sm-25 ms-auto">
        <span class="input-group-text text-body">
          <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px"
            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z">
            </path>
          </svg>
        </span>
        <input type="text" class="form-control" placeholder="Pesquisar..." v-model="search">
      </div>
    </div>
    <div class="table-responsive p-0">
      <table class="table align-items-center mb-0">
        <thead class="bg-gray-100">
          <tr>
            <th class="text-secondary text-xs font-weight-semibold opacity-7">Livro</th>
            <th class="px-2 text-secondary text-xs font-weight-semibold opacity-7">Usuário</th>
            <th class="px-2 text-secondary text-xs font-weight-semibold opacity-7">Expiração</th>
          </tr>
        </thead>
        <tbody>
          @if($transfers->count() === 0)
            <tr>
              <td colspan="3">
                <div
                  class="d-flex align-items-center justify-content-center font-weight-semibold text-center text-secondary bg-gray-100 opacity-7 text-xs"
                  style="width: 100%; min-height: 10rem;"
                >Não há nenhum livro aguardando devolução!</div>
              </td>
            </tr>
          @endif
          @foreach ($transfers as $transfer)
            <tr v-if="(
              filter === 'all' || 
              (filter === 'pending' && {{ $transfer->status === 'borrowed' ? 'true':'false' }}) ||
              (filter === 'late' && {{ $transfer->status === 'expired' ? 'true':'false' }})
            ) && (!search || '{{ $transfer->book->title }}'.toLowerCase().includes(search.toLowerCase()))">
              <td>
                <div class="d-flex px-2 py-1">
                  <div class="d-flex align-items-center">
                    <img src="{{ $transfer->book->image }}" class="rounded-md me-2" alt="{{ $transfer->book->title }}" style="
                      width: 3rem;
                      background: black;
                      height: 4rem;
                      object-fit: cover;
                    "/>
                  </div>
                  <div class="d-flex flex-column justify-content-center ms-1">
                    <h6 class="mb-0 text-sm font-weight-semibold">{{  $transfer->book->title }}</h6>
                    <p class="text-sm text-secondary mb-0">{{  $transfer->book->subtitle }}</p>
                    <em class="text-xs text-secondary mb-0" style="opacity: .7;">- {{  $transfer->book->getAuthorNames()->join(', ') }}</em>
                  </div>
                </div>
              </td>
              <td>
                <h6 class="mb-0 text-sm font-weight-semibold">{{  $transfer->user->name }}</h6>
                <p class="text-sm text-secondary mb-0">{{  $transfer->user->email }}</p>
              </td>
              <td>
                <span class="text-secondary text-sm font-weight-normal">{{ $transfer->expiration }}</span>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div class="border-top py-3 px-3 d-flex align-items-center">
      <button class="btn btn-sm btn-white d-sm-block d-none mb-0" disabled="false">Anterior</button>
      <nav aria-label="..." class="ms-auto">
        <ul class="pagination pagination-light mb-0">
          @for($i = 1; $i <= $pagination->pages; $i++)
            <li class="page-item {{ $i === 1 ? 'active' : '' }}" aria-current="{{ $i === 1 ? 'page' : '' }}">
              <a class="page-link {{ $i === 1 ? '' : 'border-0' }} font-weight-bold" href="javascript:;">{{ $i }}</a>
            </li>
          @endfor
        </ul>
      </nav>
      <button
        class="btn btn-sm btn-white d-sm-block d-none mb-0 ms-auto"
        disabled="{{ $pagination->pages === 1 ? "true": "false" }}"
      >Próximo</button>
    </div>
  </div>
  @php if(!isset($isVueStarted)){ $isVueStarted = true; @endphp
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14"></script>
  @php } @endphp
  <script>
    new Vue({
      el: '#table-devolutions',
      data: { filter: 'all', search: '' },
      methods: { }
    })
  </script>
</div>