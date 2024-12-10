<script src="/loja_motos/assets/javascript/lista_motos.js"></script>

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
        <span>
          Aqui você pode ver as motos disponíveis para compra e adicionar ao carrinho
        </span>
      </div>
      <div class="d-flex gap-2 btn-group">
        <a
          href="./motos/cadastro"
          class="btn btn-dark rounded-5 px-3 py-0 d-flex align-items-center gap-1">
          <div class="d-grid place-items-center">
            <i class="bi bi-plus fs-4 m-0"></i>
          </div>
          Cadastrar moto
        </a>
        <a
          href="./vendas/carrinho"
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
          <div
          class="position-relative ratio ratio-1x1"
            style="max-height: 400px; max-width: 300px;">
            <img
              src="{$moto['foto_moto']}"
              alt="Foto da moto"
              class="object-fit-contain h-100 w-100"
              loading="lazy" />
            <div class="position-absolute d-flex justify-content-start align-items-end gap-2 p-2">
              <a
                href="./motos/edicao/{$moto['id_moto']}"
                class="btn btn-light rounded-circle shadow-sm">
                <i class="bi bi-pencil fs-5"></i>
              </a>
              <a
                href="./motos/exclusao/{$moto['id_moto']}"
                class="btn btn-dark rounded-circle">
                <i class="bi bi-trash fs-5"></i>
              </a>
            </div>
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
              <a
                href="./vendas/adicionar/{$moto['id_moto']}"
                class="border-0 outline-0 bg-transparent"
                title="Adicionar ao carrinho">
                <i class="bi bi-plus-circle fs-3"></i>
              </a>
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