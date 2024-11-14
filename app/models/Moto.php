<?php
// Model/Moto.php
class Moto {
    $marca;
    $modelo;
    $combustivel;
    $cor;
    $preco;
    $ano;
    $potenciaCavalos;
    $consumo;

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