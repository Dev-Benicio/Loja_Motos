<div class="d-flex flex-column vh-100">
  <?php
  use App\Components\navbar;
  $navbar = new navbar();
  echo $navbar->render("Bem-vindo");
  ?>
  <main class="container d-flex flex-column justify-content-center gap-3 h-100">
    <?php
    foreach ($motos as $moto) {
      echo <<<HTML
      <div class="card flex-row overflow-hidden rounded-3">
        <!-- Imagem da moto -->
        <div class="ratio ratio-1x1" style="max-height: 400px; max-width: 300px;">
          <img
            src="{$moto['foto']}"
            alt="Foto da moto"
            class="object-fit-cover h-100 w-100" />
        </div>
        <!-- Informações da moto -->
        <div class="card-body bg-secondary-subtle p-4 d-flex flex-column justify-content-between">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <h4>{$moto['modelo']}</h4>
              <span>{$motos['marca']} - {$motos['tipo_motor']}</span>
            </div>
            <button
              class="border-0 outline-0 bg-transparent"
              title="Adicionar ao carrinho">
              <i class="bi bi-plus-circle fs-3"></i>
            </button>
          </div>
          <div class="d-flex justify-content-between align-items-end">
            <div>
              <span>Á partir de</span>
              <h2 class="h1 fw-semibold">R$ {$moto['preco']}</h2>
            </div>
            <span class="text-end text-secondary">
              Quantidade disponível: {$moto['quantidade_disponivel']}
            </span>
          </div>
        </div>
      </div>
      HTML;
    }
    ?>
  </main>
</div>