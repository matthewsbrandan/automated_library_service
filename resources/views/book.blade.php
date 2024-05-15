<x-app-layout>
  <main class="main-content h-100">
    <div class="pb-6 bg-cover text-white" style="background-image: url('../assets/img/header-blue-purple.jpg')">
      <x-app.navbar />
    </div>
    <div class="container my-3 py-3">
      <div class="row mt-n6 mb-6">
        @foreach($books as $book)        
          <div class="col-lg-3 col-sm-6">
            <div class="card rounded-lg blur border border-white mb-4 shadow-xs">
              <div class="card-body p-2">
                <div class="d-flex justify-content-center max-w-full overflow-hidden">
                  <img class="rounded-md" src="{{ $book->image }}" alt="{{ $book->title }}" style="max-width: 17rem; height: 15rem;">
                </div>
                <div class="p-2">
                  <p class="text-xs mt-2 mb-0">{{ $book->getAuthorNames()->join(', ') }}</p>
                  <h4 class="mb-0 font-weight-bold">{{ $book->title }}</h4>
                </div>
                
                @if(!$book->status)
                  <a href="{{ route('reservation.request', ['book_id' => $book->id]) }}" class="btn btn-sm btn-dark mb-0 w-100">
                    Reservar
                  </a>
                @else
                  <div class="btn btn-sm btn-white mb-0 w-100" style="cursor: default;">
                    {{ $book->status }}
                  </div>
                @endif
              </div>
            </div>
          </div>
        @endforeach
      </div>
      <x-app.footer />
    </div>
  </main>

</x-app-layout>
