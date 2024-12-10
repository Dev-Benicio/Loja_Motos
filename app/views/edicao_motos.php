<div class="d-flex flex-column vh-100">
  <!-- HEADER -->
  <?php
  use App\Components\navbar;
  $navbar = new navbar();
  echo $navbar->render("Motos");
  ?>
  <main class="flex-grow-1 d-flex flex-column justify-content-center align-items-center">
    <form method="POST" class="w-50 border border-1 border-secondary-subtle rounded-3 shadow-sm p-4">
      <!-- Cabeçalho do formulário -->
      <header class="d-flex gap-3 mb-4">
        <img
          src="/loja_motos/assets/icons/motobike.svg"
          alt="Cadastro de Clientes"
          class="brand-icon"
          style="height: 80px; width: 80px;" />
        <div class="lh-sm">
          <h1 class="brand-name fw-semibold fs-2 mt-1 d-flex flex-column gap-3">
            Atualizar motos
          </h1>
          <p class="fs-5 text-secondary">
            Atualize as informações da moto
          </p>
        </div>
      </header>
      <div class="d-grid gap-4">
        <!-- Primeira linha do formulário -->
        <div class="row">
          <div class="col-md-4">
            <label for="marca" class="form-label">Marca</label>
            <input required type="text" class="form-control bg-body-tertiary" id="marca">
          </div>
          <div class="col-md-4">
            <label for="modelo" class="form-label">Modelo</label>
            <input required type="text" class="form-control bg-body-tertiary" id="modelo">
          </div>
          <div class="col-md-4">
            <label for="tipo_motor" class="form-label">Tipo de motor</label>
            <select
              required
              name="tipo_motor"
              id="tipo_motor"
              class="form-select bg-body-tertiary"
            >
              <option value="Combustão">Combustão</option>
              <option value="Elétrico">Elétrico</option>
              <option value="Híbrido">Híbrido</option>
            </select>
          </div>
        </div>
        <!-- Segunda linha do formulário -->
        <div class="row">
          <div class="col-md-4">
            <label for="preco" class="form-label">Preço</label>
            <input type="number" required class="form-control bg-body-tertiary" id="preco">
          </div>
          <div class="col-md-4">
            <label for="ano" class="form-label">Ano</label>
            <input type="number" max="<?= date('Y') + 1 ?>" min="<?= date('Y') - 50 ?>" required class="form-control bg-body-tertiary" id="ano">
          </div>
          <div class="col-md-4">
            <label for="potencia" class="form-label">Potência</label>
            <input type="number" required class="form-control bg-body-tertiary" id="potencia">
          </div>
        </div>
        <!-- Terceira linha do formulário -->
        <div class="row">
          <div class="col-md-4">
            <label for="consumo_km" class="form-label">Consumo</label>
            <input type="number" required min="1" class="form-control bg-body-tertiary" id="consumo_km">
          </div>
          <div class="col-md-8">
            <label for="foto_moto" class="form-label">Foto da moto</label>
            <input type="file" required class="form-control bg-body-tertiary" id="foto_moto">
          </div>
        </div>
      </div>
      <!-- Footer do formulário -->
      <footer class="d-flex justify-content-between align-items-start mt-5">
        <span class="text-secondary fw-light">
          * Certifique-se que os dados estão corretos antes de prosseguir.
          <?php /* Mensagem de erro */ ?>
        </span>
        <div class="d-flex gap-3">
          <button
            type="button"
            class="btn outline-btn px-5 rounded-pill"
            onclick="history.back()">
            Cancelar
          </button>
          <button class="btn btn-dark px-5 rounded-pill">
            Cadastrar
          </button>
        </div>
      </footer>
    </form>
  </main>
</div>