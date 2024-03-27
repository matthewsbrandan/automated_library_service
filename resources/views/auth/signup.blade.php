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
            <div class="col-md-6">
              <div class="position-absolute w-40 top-0 start-0 h-100 d-md-block d-none">
                <div
                  class="oblique-image position-absolute d-flex fixed-top ms-auto h-100 z-index-0 bg-cover me-n8"
                  style="background-image:url('../assets/img/corredor-biblioteca.jpg')"
                >
                  <div style="background: #2248; position: absolute; inset: 0;"></div>
                  <div class="my-auto text-start max-width-350 ms-7" style="z-index: 1">
                    <h1 class="mt-3 text-white font-weight-bolder">Inicie sua <br> exploração.</h1>
                    <p class="text-white text-lg mt-4 mb-4">Nós estamos prontos para te ajudar a encontrar o conhecimento que tanto procura!</p>
                    {{-- <div class="d-flex align-items-center">
                      <div class="avatar-group d-flex">
                        <a href="javascript:;" class="avatar avatar-sm rounded-circle"
                          data-bs-toggle="tooltip" data-original-title="Jessica Rowland">
                          <img alt="Image placeholder" src="../assets/img/team-3.jpg"
                            class="">
                        </a>
                        <a href="javascript:;" class="avatar avatar-sm rounded-circle"
                          data-bs-toggle="tooltip" data-original-title="Audrey Love">
                          <img alt="Image placeholder" src="../assets/img/team-4.jpg"
                            class="rounded-circle">
                        </a>
                        <a href="javascript:;" class="avatar avatar-sm rounded-circle"
                          data-bs-toggle="tooltip" data-original-title="Michael Lewis">
                          <img alt="Image placeholder" src="../assets/img/marie.jpg"
                            class="rounded-circle">
                        </a>
                        <a href="javascript:;" class="avatar avatar-sm rounded-circle"
                          data-bs-toggle="tooltip" data-original-title="Audrey Love">
                          <img alt="Image placeholder" src="../assets/img/team-1.jpg"
                            class="rounded-circle">
                        </a>
                      </div>
                      <p class="font-weight-bold text-white text-sm mb-0 ms-2">Join 2.5M+ users
                      </p>
                    </div> --}}
                  </div>
                  <div class="text-start position-absolute fixed-bottom ms-7">
                    <h6 class="text-white text-sm mb-5">Copyright © 2024 PI Univesp.</h6>
                  </div>
                  
                </div>
              </div>
            </div>
            <div class="col-md-4 d-flex flex-column mx-auto">
              <div class="card card-plain mt-8">
                <div class="card-header pb-0 text-left bg-transparent">
                  <h3 class="font-weight-black text-dark display-6">Cadastre-se</h3>
                  <p class="mb-0">Estamos quase lá, precisamos apenas de algumas informações.</p>
                </div>
                <div class="card-body">
                  <form role="form" method="POST" action="sign-up">
                    @csrf
                    <label>Nome</label>
                    <div class="mb-3">
                      <input
                        type="text" id="name" name="name" class="form-control"
                        placeholder="Digite seu nome"
                        value="{{old("name")}}"
                        aria-label="Name"
                        aria-describedby="name-addon"
                        required
                      >
                      @error('name')
                        <span class="text-danger text-sm">{{ $message }}</span>
                      @enderror
                    </div>
                    <label>Email</label>
                    <div class="mb-3">
                      <input
                        type="email" id="email" name="email" class="form-control"
                        placeholder="Digite seu email" value="{{old("email")}}" aria-label="Email"
                        aria-describedby="email-addon"
                        required
                      >
                      @error('email')
                        <span class="text-danger text-sm">{{ $message }}</span>
                      @enderror
                    </div>
                    <label>Senha</label>
                    <div class="mb-3">
                      <input type="password" id="password" name="password" class="form-control"
                        placeholder="Crie uma senha" aria-label="Password"
                        aria-describedby="password-addon">
                      @error('password')
                        <span class="text-danger text-sm">{{ $message }}</span>
                      @enderror
                    </div>
                    <div class="form-check form-check-info text-left mb-0">
                      <input class="form-check-input" type="checkbox" name="terms"
                        id="terms" required>
                      <label class="font-weight-normal text-dark mb-0" for="terms">
                        Eu aceito os <a href="javascript:;"
                          class="text-dark font-weight-bold">Termos e Condições</a>.
                      </label>
                      @error('terms')
                        <span class="text-danger text-sm">{{ $message }}</span>
                      @enderror
                    </div>
                    <div class="text-center">
                      <button type="submit" class="btn btn-dark w-100 mt-4 mb-3">Cadastrar</button>
                      {{-- 
                        <button type="button" class="btn btn-white btn-icon w-100 mb-3">
                          <span class="btn-inner--icon me-1">
                            <img class="w-5" src="../assets/img/logos/google-logo.svg" alt="google-logo" />
                          </span>
                          <span class="btn-inner--text">Cadastrar com o Google</span>
                        </button>
                      --}}
                    </div>
                  </form>
                </div>
                <div class="card-footer text-center pt-0 px-lg-2 px-1">
                  <p class="mb-4 text-xs mx-auto">
                    Já possui uma conta?
                    <a href="{{ route('sign-in') }}" class="text-dark font-weight-bold">Logar</a>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

</x-guest-layout>
