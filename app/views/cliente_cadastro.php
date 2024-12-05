<div class="d-flex flex-column vh-100">
  <!-- HEADER -->
  <header class="d-flex justify-content-between align-items-center border-bottom py-2 mt-1">
    <!-- Nome do site e da página atual -->
    <?php
    use App\Components\navbar;
    $navbar = new navbar();
    echo $navbar->render();
    ?>
    </header>
    <div class="flex-grow-1 d-flex flex-column justify-content-center align-items-center">
<form class="row g- form-border">
<span class="material-symbols-outlined"></span>
      <h1 class="brand-name fw-semibold fs-1 mt-1 d-flex flex-column gap-3">Cadastro de Clientes</h1>
      <div id="subtitle"
      <p class="fs-5">Insira as informações do cliente para cadastrá-lo</p>
      </div>
    <div class="col-md-4">
        <label for="inputNome" class="form-label">Nome</label>
        <input type="text" class="form-control input-field" id="inputNome1">
    </div>
    <div class="col-md-4">
        <label for="inputNome2" class="form-label">Sobrenome</label>
        <input type="text" class="form-control input-field" id="inputNome2">
    </div>
    <div class="col-md-4">
        <label for="inputTelefone" class="form-label">Telefone</label>
        <input type="text" class="form-control input-field" id="inputTelefone" data-mask="(00) 0000-0000" data-mask-maxlength="14">
    </div>
    <div class="col-md-4">
        <label for="inputCPF" class="form-label">CPF</label>
        <input type="text" class="form-control input-field" id="inputCPF">
    </div>
    <div class="col-md-6">
        <label for="inputEmail4" class="form-label">Email</label>
        <input type="email" class="form-control" id="inputEmail4">
    </div>
    <div class="col-md-4">
        <label for="inputCEP" class="form-label">CEP</label>
        <input type="text" class="form-control input-field" id="inputCEP" data-mask="00000-000">
    </div>
    <div class="col-md-4">
      <label for=inputNumber>Número</label>
      <input type="number" class="form-control input-field" id=inputNumber>
    </div>
    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ratione, quam! </p>
    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
  <button class="btn btn-primary me-md-2 btn-wide" type="button">Cadastrar</button>
  </div>
    </form>
          </div>  
              </div>