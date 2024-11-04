<?php
// Model/Funcionario.php
class Funcionario {
    private $id;
    private $nome;
    private $cpf;
    private $dataNascimento;
    private $endereco;
    private $telefone;
    private $email;
    private $cargo;
    private $dataAdmissao;
    private $dataDemissao;
    private $salario;
    private $numCarteiraTrabalho;
    private $horarioTrabalho;
    private $status;
    private $fotoPerfil;

    // Construtor
    public function __construct(array $data = []) {
        if (!empty($data)) {
            $this->hydrate($data);
        }
    }

    // Método para hidratar o objeto com dados
    private function hydrate(array $data) {
        foreach ($data as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    // Getters e Setters
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setNome($nome) {
        $this->nome = $nome;
        return $this;
    }

    public function getCpf() {
        return $this->cpf;
    }

    public function setCpf($cpf) {
        $this->cpf = preg_replace('/[^0-9]/', '', $cpf);
        return $this;
    }

    public function getDataNascimento() {
        return $this->dataNascimento;
    }

    public function setDataNascimento($dataNascimento) {
        $this->dataNascimento = $dataNascimento;
        return $this;
    }

    public function getEndereco() {
        return $this->endereco;
    }

    public function setEndereco($endereco) {
        $this->endereco = $endereco;
        return $this;
    }

    public function getTelefone() {
        return $this->telefone;
    }

    public function setTelefone($telefone) {
        $this->telefone = preg_replace('/[^0-9]/', '', $telefone);
        return $this;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    public function getCargo() {
        return $this->cargo;
    }

    public function setCargo($cargo) {
        $this->cargo = $cargo;
        return $this;
    }

    public function getDataAdmissao() {
        return $this->dataAdmissao;
    }

    public function setDataAdmissao($dataAdmissao) {
        $this->dataAdmissao = $dataAdmissao;
        return $this;
    }

    public function getDataDemissao() {
        return $this->dataDemissao;
    }

    public function setDataDemissao($dataDemissao) {
        $this->dataDemissao = $dataDemissao;
        return $this;
    }

    public function getSalario() {
        return $this->salario;
    }

    public function setSalario($salario) {
        $this->salario = $salario;
        return $this;
    }

    public function getNumCarteiraTrabalho() {
        return $this->numCarteiraTrabalho;
    }

    public function setNumCarteiraTrabalho($numCarteiraTrabalho) {
        $this->numCarteiraTrabalho = $numCarteiraTrabalho;
        return $this;
    }

    public function getHorarioTrabalho() {
        return $this->horarioTrabalho;
    }

    public function setHorarioTrabalho($horarioTrabalho) {
        $this->horarioTrabalho = $horarioTrabalho;
        return $this;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
        return $this;
    }

    public function getFotoPerfil() {
        return $this->fotoPerfil;
    }

    public function setFotoPerfil($fotoPerfil) {
        $this->fotoPerfil = $fotoPerfil;
        return $this;
    }
}

// Model/FuncionarioDAO.php
class FuncionarioDAO {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function inserir(Funcionario $funcionario) {
        $sql = "INSERT INTO funcionarios (
            nome, cpf, data_nascimento, endereco, telefone, 
            email, cargo, data_admissao, data_demissao, salario, 
            num_carteira_trabalho, horario_trabalho, status, foto_perfil
        ) VALUES (
            :nome, :cpf, :data_nascimento, :endereco, :telefone,
            :email, :cargo, :data_admissao, :data_demissao, :salario,
            :num_carteira_trabalho, :horario_trabalho, :status, :foto_perfil
        )";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':nome' => $funcionario->getNome(),
            ':cpf' => $funcionario->getCpf(),
            ':data_nascimento' => $funcionario->getDataNascimento(),
            ':endereco' => $funcionario->getEndereco(),
            ':telefone' => $funcionario->getTelefone(),
            ':email' => $funcionario->getEmail(),
            ':cargo' => $funcionario->getCargo(),
            ':data_admissao' => $funcionario->getDataAdmissao(),
            ':data_demissao' => $funcionario->getDataDemissao(),
            ':salario' => $funcionario->getSalario(),
            ':num_carteira_trabalho' => $funcionario->getNumCarteiraTrabalho(),
            ':horario_trabalho' => $funcionario->getHorarioTrabalho(),
            ':status' => $funcionario->getStatus(),
            ':foto_perfil' => $funcionario->getFotoPerfil()
        ]);
    }

    public function atualizar(Funcionario $funcionario) {
        $sql = "UPDATE funcionarios SET
            nome = :nome,
            cpf = :cpf,
            data_nascimento = :data_nascimento,
            endereco = :endereco,
            telefone = :telefone,
            email = :email,
            cargo = :cargo,
            data_admissao = :data_admissao,
            data_demissao = :data_demissao,
            salario = :salario,
            num_carteira_trabalho = :num_carteira_trabalho,
            horario_trabalho = :horario_trabalho,
            status = :status,
            foto_perfil = :foto_perfil
            WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id' => $funcionario->getId(),
            ':nome' => $funcionario->getNome(),
            ':cpf' => $funcionario->getCpf(),
            ':data_nascimento' => $funcionario->getDataNascimento(),
            ':endereco' => $funcionario->getEndereco(),
            ':telefone' => $funcionario->getTelefone(),
            ':email' => $funcionario->getEmail(),
            ':cargo' => $funcionario->getCargo(),
            ':data_admissao' => $funcionario->getDataAdmissao(),
            ':data_demissao' => $funcionario->getDataDemissao(),
            ':salario' => $funcionario->getSalario(),
            ':num_carteira_trabalho' => $funcionario->getNumCarteiraTrabalho(),
            ':horario_trabalho' => $funcionario->getHorarioTrabalho(),
            ':status' => $funcionario->getStatus(),
            ':foto_perfil' => $funcionario->getFotoPerfil()
        ]);
    }

    public function buscarPorId($id) {
        $sql = "SELECT * FROM funcionarios WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($resultado) {
            return new Funcionario($resultado);
        }
        return null;
    }

    public function listarTodos() {
        $sql = "SELECT * FROM funcionarios";
        $stmt = $this->db->query($sql);
        
        $funcionarios = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $funcionarios[] = new Funcionario($row);
        }
        return $funcionarios;
    }

    public function deletar($id) {
        $sql = "DELETE FROM funcionarios WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}

// Model/FuncionarioService.php
class FuncionarioService {
    private $funcionarioDAO;

    public function __construct(FuncionarioDAO $funcionarioDAO) {
        $this->funcionarioDAO = $funcionarioDAO;
    }

    public function cadastrarFuncionario(array $dados) {
        // Validações
        if (!$this->validarDados($dados)) {
            throw new Exception("Dados inválidos");
        }

        // Verifica CPF duplicado
        if ($this->cpfExiste($dados['cpf'])) {
            throw new Exception("CPF já cadastrado");
        }

        $funcionario = new Funcionario($dados);
        return $this->funcionarioDAO->inserir($funcionario);
    }

    private function validarDados($dados) {
        // Validações básicas
        if (empty($dados['nome']) || strlen($dados['nome']) > 60) {
            return false;
        }

        if (!$this->validarCPF($dados['cpf'])) {
            return false;
        }

        if (!filter_var($dados['email'], FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        if (!empty($dados['salario']) && !is_numeric($dados['salario'])) {
            return false;
        }

        return true;
    }

    private function validarCPF($cpf) {
        $cpf = preg_replace('/[^0-9]/', '', $cpf);
        if (strlen($cpf) != 11) {
            return false;
        }
        return true; // Adicione mais validações conforme necessário
    }

    private function cpfExiste($cpf) {
        // Implementar lógica para verificar CPF duplicado
        return false;
    }

    public function atualizarStatus($id, $novoStatus) {
        $funcionario = $this->funcionarioDAO->buscarPorId($id);
        if (!$funcionario) {
            throw new Exception("Funcionário não encontrado");
        }

        $funcionario->setStatus($novoStatus);
        return $this->funcionarioDAO->atualizar($funcionario);
    }

    public function calcularTempoServico($id) {
        $funcionario = $this->funcionarioDAO->buscarPorId($id);
        if (!$funcionario) {
            return 0;
        }

        $admissao = new DateTime($funcionario->getDataAdmissao());
        $demissao = $funcionario->getDataDemissao() 
            ? new DateTime($funcionario->getDataDemissao())
            : new DateTime();

        $intervalo = $admissao->diff($demissao);
        return $intervalo->y; // retorna anos de serviço
    }
}
