  <!-- Button trigger modal -->
  <button type="button" class="btn bg-gradient-info btn-block" >
    SignUp Modal
  </button>

<!-- Modal -->
<div class="modal fade" id="modalAddBook" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-body p-0">
        <div class="card card-plain">
          <div class="card-header pb-0 text-left">
              <h3 class="font-weight-bolder text-dark">Novo Livro</h3>
              <p class="mb-0">Adicione um novo livro ao acervo</p>
          </div>
          <div class="card-body pb-3">
            <form role="form text-left">
              <label>Name</label>
              <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Name" aria-label="Name" aria-describedby="name-addon">
              </div>
              <label>Email</label>
              <div class="input-group mb-3">
                <input type="email" class="form-control" placeholder="Email" aria-label="Email" aria-describedby="email-addon">
              </div>
              <label>Password</label>
              <div class="input-group mb-3">
                <input type="password" class="form-control" placeholder="Password" aria-label="Password" aria-describedby="password-addon">
              </div>
              <div class="form-check form-check-info text-left">
                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" checked="">
                <label class="form-check-label" for="flexCheckDefault">
                  I agree the <a href="javascrpt:;" class="text-dark font-weight-bolder">Terms and Conditions</a>
                </label>
              </div>
              <div class="text-center">
                <button type="button" class="btn btn-dark btn-lg btn-rounded w-100 mt-4 mb-0">Sign up</button>
              </div>
            </form>
          </div>
          <div class="card-footer text-center pt-0 px-sm-4 px-1">
            <p class="mb-4 mx-auto">
              Already have an account?
              <a href="javascrpt:;" class="text-dark font-weight-bold">Sign in</a>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
