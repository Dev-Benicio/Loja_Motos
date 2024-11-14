<?php
// Model/Funcionario.php
class funcionario {
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


    public static function create(array $user){
        banco_de_dados::conectar();
        $query = "INSERT INTO 
            funcionario(
                    login_funcionario, senha, nome, cpf, data_nascimento, endereco, telefone, email,
                    cargo, data_admissao, data_demissao, salario, status_funcionario, foto_perfil
            ) 
            VALUES (
            ". array_map(fn($value) => "'$value, '", $user) ."
            )"
        ;
        $conexao->query($query);
        banco_de_dados::fechar_conexao();
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
