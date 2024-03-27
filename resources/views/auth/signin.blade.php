<x-guest-layout>
  <div class="container position-sticky z-index-sticky top-0">
    <div class="row">
      <div class="col-12">
        <x-guest.sidenav-guest />
      </div>
    </div>
  </div>
  <main class="main-content  mt-0">
    <section>
      <div class="page-header min-vh-100">
        <div class="container">
          <div class="row">
            <div class="col-xl-4 col-md-6 d-flex flex-column mx-auto">
              <div class="card card-plain mt-8">
                <div class="card-header pb-0 bg-transparent text-center">
                  <h3 class="font-weight-black text-dark display-6">Login</h3>
                  <p class="mb-0">Bem vindo ao {{ Config::get('app.name') }}!</p>
                </div>
                <div class="text-center">
                  @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600">
                      {{ session('status') }}
                    </div>
                  @endif
                  @error('message')
                    <div class="alert alert-danger text-sm" role="alert">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
                <div class="card-body">
                  <form role="form" class="text-start" method="POST" action="sign-in">
                    @csrf
                    <label>Email</label>
                    <div class="mb-3">
                      <input
                        type="email" id="email" name="email" class="form-control"
                        placeholder="Digite seu email"
                        value="{{ old('email') ? old('email') : '' }}"
                        aria-label="Email"
                        aria-describedby="email-addon"
                        required
                      >
                    </div>
                    <label>Senha</label>
                    <div class="mb-3">
                      <input
                        type="password" id="password" name="password"
                        value="{{ old('password') ? old('password') : '' }}"
                        class="form-control" placeholder="Enter password" aria-label="Password"
                        aria-describedby="password-addon"
                        required
                      >
                    </div>
                    <div class="d-flex align-items-center">
                      <div class="form-check form-check-info text-left mb-0">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                        <label class="font-weight-normal text-dark mb-0" for="flexCheckDefault">
                          Manter conectado
                        </label>
                      </div>
                      <a href="{{ route('password.request') }}" class="text-xs font-weight-bold ms-auto">Esqueci a senha</a>
                    </div>
                    <div class="text-center">
                      <button type="submit" class="btn btn-dark w-100 mt-4 mb-3">Entrar</button>
                      {{-- 
                        <button type="button" class="btn btn-white btn-icon w-100 mb-3">
                          <span class="btn-inner--icon me-1">
                            <img class="w-5" src="../assets/img/logos/google-logo.svg" alt="google-logo" />
                          </span>
                          <span class="btn-inner--text">Entrar com o Google</span>
                        </button>
                       --}}
                    </div>
                  </form>
                </div>
                <div class="card-footer text-center pt-0 px-lg-2 px-1">
                  <p class="mb-4 text-xs mx-auto">
                    Não tem uma conta?
                    <a href="{{ route('sign-up') }}" class="text-dark font-weight-bold">Cadastre-se</a>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="position-absolute w-40 top-0 end-0 h-100 d-md-block d-none">
                <div
                  class="oblique-image position-absolute fixed-top ms-auto h-100 z-index-0 bg-cover ms-n8"
                  style="background-image:url('../assets/img/book-and-phone.avif')"
                >
                  <div
                    class="blur mt-12 p-4 text-center border border-white border-radius-md position-absolute fixed-bottom m-4">
                    <h2 class="mt-3 text-dark font-weight-bold">Navegue pelo conhecimento através dos livros.</h2>
                    <h6 class="text-dark text-sm mt-5">Copyright © 2024 PI Univesp.</h6>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
</x-guest-layout>