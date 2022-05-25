<?php
session_start();
date_default_timezone_set('America/Sao_Paulo');
ob_start();
require_once("funcoes.php");

$botaoRegistrar = filter_input(INPUT_POST, 'botaoRegistrar');

if ($botaoRegistrar) {
    
    require_once 'conexao.php';
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    //var_dump($dados);
    $dados["senha"] = password_hash($dados["senha"], PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuario VALUES (null, ?, ?, ?, ?, ?, ?, ?, '2',  ?, ?)";
    
    if($stmt = mysqli_prepare($conexao, $sql)) {

        mysqli_stmt_bind_param($stmt, 'ssssiisss', $param_usu_nome, $param_usu_nascimento, $param_usu_nomemat, $param_usu_cpf, $param_usu_celular, $param_usu_fixo, $param_usu_endereco, $param_usu_login, $param_usu_senha);

        $param_usu_nome = $dados['nome'];
        $param_usu_nascimento = $dados['nascimento'];
        $param_usu_nomemat = $dados['nomemat'];
        $param_usu_cpf = $dados['cpf'];
        $param_usu_celular = $dados['celular'];
        $param_usu_fixo = $dados['fixo'];
        $param_usu_endereco = $dados['endereco'];
        $param_usu_login = $dados['login'];
        $param_usu_senha = $dados['senha'];

        if(mysqli_stmt_execute($stmt)){

            //comitar a transação
            mysqli_commit($conexao);
            mysqli_stmt_close($stmt);
            mysqli_close($conexao);

            $_SESSION['msgcad'] = "Usuário cadastrado com sucesso";
            header("location: index.php");
        }
        else{

            $_SESSION['msg'] = "<p class='status-bar-field alinhaCentro'>Erro ao cadastrar o usuário</p>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style2.css">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="icon" type="image/x-icon" href="Imagens/favicon.ico" />
    <title>Fiction - Soluções em tecnologia</title>
</head>
<body>
    <div class="container">
            <div class="row">
                <div class="col-md-8 col-lg-12 col-sm-12">
                    <div class="position-absolute top-0 start-0 end-0">
                        <nav class="navbar navbar-light bg-light">
                        <a class="navbar-brand degradeMovimento" id="titulo" href="<?php echo mudaLink() ?>">
                            <img src="Imagens/fiction-icon.png" alt="" width="78.4px" height="78.4px" class="d-inline-block align-text-top">
                            Fiction
                            </a>
                            <ul class="d-flex">
                                <?php mostraBotaoLogout() ?>
                                <li><a class="navbar-brand degradeMovimento" href="cadastro.php">Cadastro</a></li>
                                <li><a class="navbar-brand degradeMovimento" href="modelagem.php">Modelo de dados</a></li>
                                <li><a class="navbar-brand degradeMovimento " href="queries.php">Queries SQL</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    <div class="card position-absolute top-50 start-50 translate-middle" id="formulario" style="width:1500px; margin-top:55px">
        <div class="card-body">
            <?php
                if(isset($_SESSION['msg'])){
                    echo $_SESSION['msg'];
                    unset($_SESSION['msg']);
                }
            ?>
            <form action="" method="POST">
                <div class="input-group mb-3">
                    <label for="nomeId" class="col-sm-2 col-form-label col-form-label-lg">Nome*</label>
                    <input type="text" name="nome" class="form-control" id="nomeId" placeholder="Digite seu nome" aria-label="Recipients username" aria-describedby="button-addon2" autofocus>
                </div>
                    
                <div class="input-group mb-3">
                    <label for="nascimentoId" class="col-sm-2 col-form-label col-form-label-lg">Data de nascimento*</label>
                    <input type="date" name="nascimento" class="form-control" id="nascimentoId" max="<?php dataLimite() ?>" aria-label="Recipients username" aria-describedby="button-addon2" required>
                </div>

                <div class="input-group mb-3">
                    <label for="nomeMatId" class="col-sm-2 col-form-label col-form-label-lg">Nome materno*</label>
                    <input type="text" name="nomemat" class="form-control" id="nomeMatId" placeholder="Digite o nome da sua mãe" aria-label="Recipients username" aria-describedby="button-addon2" required>
                </div>

                <div class="input-group mb-3">
                    <label for="cpfId" class="col-sm-2 col-form-label col-form-label-lg">CPF*</label>
                    <input type="text" name="cpf" class="form-control" id="cpfId" maxlength="11" placeholder="Digite seu número de cpf" aria-label="Recipients username" aria-describedby="button-addon2" required>
                </div>

                <div class="input-group mb-3">
                    <label for="celularId" class="col-sm-2 col-form-label col-form-label-lg">Celular*</label>
                    <input type="text" name="celular" class="form-control" id="celularId" maxlength="11" placeholder="Digite seu número" aria-label="Recipients username" aria-describedby="button-addon2" required>
                </div>

                <div class="input-group mb-3">
                    <label for="fixoId" class="col-sm-2 col-form-label col-form-label-lg">Telefone</label>
                    <input type="text" name="fixo" class="form-control" maxlength="10" id="fixoId" placeholder="Digite seu númer" aria-label="Recipients username" aria-describedby="button-addon2">
                </div>

                <div class="input-group mb-3">
                    <label for="enderecoId" class="col-sm-2 col-form-label col-form-label-lg">Endereço</label>
                    <input type="text" name="endereco" class="form-control" id="enderecoId" placeholder="Digite seu endereço completo" aria-label="Recipients username" aria-describedby="button-addon2">
                </div>

                <div class="input-group mb-3">
                    <label for="login" class="col-sm-2 col-form-label col-form-label-lg">Login*</label>
                    <input type="text" name="login" id="login" maxlength="15" class="form-control" id="8" placeholder="Crie seu login" aria-label="Recipients username" aria-describedby="button-addon2" required>
                </div>

                <div class="input-group mb-3">
                    <label for="senha" class="col-sm-2 col-form-label col-form-label-lg">Senha*</label>
                    <input type="password" maxlength="15" name="senha" maxlength="15"  class="form-control" id="senha" placeholder="Recipients username" aria-label="Recipiens username" aria-describedby="button-addon2" required>
                </div>
                    <button type="submit" name="botaoRegistrar" value="registrar" class="btn btn-primary">Cadastrar</button>
            </form>
        </div>
    </div>
    <canvas id="nokey" width="100%" height="100%" oncontextmenu="return false;"></canvas>
    <script src="script.js"></script>
</body>
</html>