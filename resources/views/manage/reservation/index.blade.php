<x-app-layout>

  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <x-app.navbar />
    <div class="container-fluid py-4 px-5">
      <div class="row">
        <div class="col-12">
          <x-tables.reservations :requesteds="$requesteds" :pagination="$pagination"/>
        </div>
        <div class="col-12">
          <x-tables.separate-reservations :reserveds="$reserveds" :pagination="$pagination"/>
        </div>
      </div>
      <x-modals.modal-separate/>
      <x-app.footer />
    </div>
  </main>
</x-app-layout>