<?php
// Model/Funcionario.php
class Funcionario {
    $id;
    $nome;
    $cpf; 
    $dataNascimento;
    $endereco;
    $telefone;
    $email;
    $cargo;
    $dataAdmissao;
    $dataDemissao;
    $salario;
    $numCarteiraTrabalho;
    $horarioTrabalho;
    $status;
    $fotoPerfil;

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
