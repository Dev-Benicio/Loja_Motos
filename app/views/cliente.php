<div class="d-flex flex-column justify-content-between vh-100">
  <!-- HEADER -->
  <header class="d-flex justify-content-between align-items-center border-bottom py-2 mt-1">
    <!-- Nome do site e da página atual -->
    <div class="d-flex flex-column ps-5">
      <span class="status-text fw-light mb-0 fs-6">Clientes  - Lista</span>
      <h2 class="brand-name fw-semibold fs-5 mt-1">Thunder Gears</h2>
    </div>
    <?php
    use App\Components\navbar;
    $navbar = new navbar();
    echo $navbar->render();
    ?>

<div class="dropdown-menu">
  <form class="px-4 py-3">
    <div class="mb-3">
      <label for="exampleDropdownFormEmail1" class="form-label">Email address</label>
      <input type="email" class="form-control" id="exampleDropdownFormEmail1" placeholder="email@example.com">
    </div>
    <div class="mb-3">
      <label for="exampleDropdownFormPassword1" class="form-label">Password</label>
      <input type="password" class="form-control" id="exampleDropdownFormPassword1" placeholder="Password">
    </div>
    <div class="mb-3">
      <div class="form-check">
        <input type="checkbox" class="form-check-input" id="dropdownCheck">
        <label class="form-check-label" for="dropdownCheck">
          Remember me
        </label>
      </div>
    </div>
    <button type="submit" class="btn btn-primary">Sign in</button>
  </form>
  <div class="dropdown-divider"></div>
  <a class="dropdown-item" href="#">New around here? Sign up</a>
  <a class="dropdown-item" href="#">Forgot password?</a>
</div>