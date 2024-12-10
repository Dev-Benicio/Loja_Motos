<div class="d-flex flex-column vh-100">
  <?php
  use App\Components\navbar;
  $navbar = new navbar();
  echo $navbar->render("Motos");
  ?>
  <main class="container d-flex flex-column gap-4 mt-5 pb-4">
    <div class="d-flex justify-content-between align-items-end">
      <div>
        <h1>Motos a venda</h1>
        <span>Aqui você pode ver as motos disponíveis para compra e adicionar ao carrinho</span>
      </div>
      <div class="d-flex gap-2 btn-group">
        <a
          href="./cadastro"
          class="btn btn-dark rounded-pill px-3">
          <i class="bi bi-plus"></i>
          Registrar moto
        </a>
        <a
          href="./carrinho"
          class="btn btn-outline-dark rounded-2 py-1 px-2"
          title="Ver carrinho de compras">
          <i class="bi bi-cart fs-5 px-1"></i>
        </a>
      </div>
    </div>
    <?php
    foreach ($motos as $moto) {
      echo <<<HTML
        <div class="card flex-row overflow-hidden rounded-3 shadow-sm">
          <!-- Imagem da moto -->
          <div class="ratio ratio-1x1" style="max-height: 400px; max-width: 300px;">
            <img
              src="{$moto['foto_moto']}"
              alt="Foto da moto"
              class="object-fit-cover h-100 w-100"
              loading="lazy" />
          </div>
          <!-- Informações da moto -->
          <div class="card-body bg-body-secondary p-4 d-flex flex-column justify-content-between">
            <div class="d-flex justify-content-between align-items-start">
              <div>
                <h4>
                  {$moto['modelo']} {$moto['tipo_motor']}
                  <small class="text-secondary fs-6 fw-light">
                    {$moto['consumo_km']}km/l
                  </small>
                </h4>
                <span>
                  {$moto['marca']}/{$moto['potencia_cavalos']}cv - {$moto['ano']}
                </span>
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
                <h2 class="h1 fw-semibold">{$moto['preco']}</h2>
              </div>
              <span class="text-end text-secondary">
                Quantidade disponível: {$moto['quantidade_estoque']}
              </span>
            </div>
          </div>
        </div>
        HTML;
    }
    ?>
  </main>
</div>