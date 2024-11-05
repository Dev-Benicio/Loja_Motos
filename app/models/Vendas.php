<?php
// Model/Vendas.php
class Vendas {
    $notaFiscal;
    $registroVenda;
    $numeroVendas; 
    $metodoPagamento;
    $valor;
    $dataVenda;

    public function __construct(array $data = []) {
        if (!empty($data)) {
            $this->hydrate($data);
        }
    }

    public function hydrate(array $data) {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }
}
?>
