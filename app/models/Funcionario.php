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


    public function create(array $user){
        banco_de_dados::conectar();
        $query = "INSERT INTO 
            funcionario(
                    login_funcionario, senha, nome, cpf, dataNascimento, endereco, telefone, email,
                    cargo, dataAdmissao, dataDemissao, salario, numCarteiraTrabalho, horarioTrabalho,
                    status_funcionario, fotoPerfil
            ) 
            VALUES (
                '$user[login_funcionario]', '$user[senha]', '$user[nome]', '$user[cpf]', '$user[data_nascimento]',
                '$user[endereco]', '$user[telefone]', '$user[email]', '$user[cargo]', '$user[data_admissao]',
                '$user[data_demissao]', '$user[salario]', '$user[status_funcionario]', '$user[foto_perfil]'
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
