<div class="d-flex flex-column vh-100">
  <?php
  use App\Components\navbar;
  $navbar = new navbar();
  echo $navbar->render("Motos");
  ?>
  <main class="container d-flex flex-column gap-4 mt-5 pb-4">
    <!-- Stepper de progresso -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div class="d-flex align-items-center gap-2">
        <?php
        if (count($motos) > 0) {
          echo '<div class="bg-primary rounded-circle text-white d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">
            <i class="bi bi-check-lg"></i>
          </div>';
        } else {
          echo '<div class="bg-secondary rounded-circle text-white d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">
            1
          </div>';
        }
        ?>
        <span class="fw-medium">Motos selecionadas</span>
      </div>
      <div class="border-bottom border-2 flex-grow-1 mx-3"></div>
      <div class="d-flex align-items-center gap-2">
        <?php
        if (!empty($id_cliente)) {
          echo '<div class="bg-primary rounded-circle text-white d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">
            <i class="bi bi-check-lg"></i>
          </div>';
        } else {
          echo '<div class="bg-secondary rounded-circle text-white d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">
            2
          </div>';
        }
        ?>
        <span class="fw-medium">Cliente</span>
      </div>
      <div class="border-bottom border-2 flex-grow-1 mx-3"></div>
      <div class="d-flex align-items-center gap-2">
        <?php
        if (!empty($forma_pagamento) && !empty($parcelas)) {
          echo '<div class="bg-primary rounded-circle text-white d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">
            <i class="bi bi-check-lg"></i>
          </div>';
        } else {
          echo '<div class="bg-secondary rounded-circle text-white d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">
            3
          </div>';
        }
        ?>
        <span class="fw-medium">Pagamento</span>
      </div>
    </div>
    <!-- Etapa 1: Motos selecionadas -->
    <div class="card rounded-3 shadow-sm mb-4">
      <div class="card-header bg-transparent border-0 py-3">
        <h5 class="card-title mb-0">Motos selecionadas</h5>
      </div>
      <div class="card-body">
        <?php
        if (!empty($motos)) {
          foreach ($motos as $moto) {
            echo <<<HTML
              <div class="card flex-row overflow-hidden rounded-3 shadow-sm mb-3">
                <div class="ratio ratio-1x1" style="max-height: 200px; max-width: 150px;">
                  <img src="{$moto['foto_moto']}" alt="Foto da moto" class="object-fit-contain h-100 w-100" loading="lazy" />
                </div>
                <div class="card-body bg-body-secondary p-3">
                  <div class="d-flex justify-content-between align-items-start h-100">
                    <div>
                      <h5 class="mb-1">{$moto['modelo']} {$moto['tipo_motor']}</h5>
                      <span class="text-secondary">{$moto['marca']} - {$moto['ano']}</span>
                    </div>
                    <div class="d-flex flex-column align-items-end justify-content-between h-100">
                      <h5 class="mb-0">{$moto['preco']}</h5>
                      <span class="text-secondary">
                        Quantidade: {$moto['quantidade_carrinho']}
                      </span>
                    </div>
                  </div>
                </div>
              </div>
            HTML;
          }
        } else {
          echo '<div class="alert alert-info">Não há motos selecionadas</div>';
        }
        ?>
      </div>
    </div>
    <!-- Etapa 2: Seleção do cliente -->
    <div class="card rounded-3 shadow-sm mb-4">
      <div class="card-header bg-transparent border-0 py-3">
        <h5 class="card-title mb-0">Selecione o cliente</h5>
      </div>
      <div class="card-body">
        <form class="row g-3">
          <div class="col-md-6">
            <label for="cpf" class="form-label">CPF do cliente</label>
            <input
              type="text"
              class="form-control bg-body-tertiary"
              id="cpf"
              name="cpf"
              placeholder="000.000.000-00"
              value="<?= $cpf_cliente ?? "" ?>">
          </div>
          <div class="col-12">
            <button type="submit" class="btn btn-dark rounded-pill">
              Buscar cliente
            </button>
          </div>
        </form>
      </div>
    </div>
    <!-- Etapa 3: Dados de pagamento -->
    <div class="card rounded-3 shadow-sm">
      <div class="card-header bg-transparent border-0 py-3">
        <h5 class="card-title mb-0">Dados de pagamento</h5>
      </div>
      <div class="card-body">
        <form class="row g-3" method="POST">
          <div class="col-md-6">
            <label for="forma_pagamento" class="form-label">Forma de pagamento</label>
            <select class="form-select bg-body-tertiary" id="forma_pagamento" name="forma_pagamento">
              <option selected>Escolha...</option>
              <option value="1">À vista</option>
              <option value="2">Cartão de crédito</option>
              <option value="3">Financiamento</option>
            </select>
          </div>
          <div class="col-md-6">
            <label for="parcelas" class="form-label">Parcelas</label>
            <select class="form-select bg-body-tertiary" id="parcelas" name="parcelas">
              <option selected>Escolha...</option>
              <option value="12">12x sem juros</option>
              <option value="24">24x sem juros</option>
              <option value="36">36x sem juros</option>
              <option value="48">48x sem juros</option>
            </select>
          </div>
          <div class="col-12">
            <button type="submit" class="btn btn-dark rounded-pill">
              Finalizar venda
            </button>
          </div>
        </form>
      </div>
    </div>
  </main>
</div>