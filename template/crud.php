<?php

$ger_nome     = "Agenda Telefonica";
$ger_slug     = "agenda";
$ger_arquivo  = "crud.php";

require_once "cabecalho.php";
require_once "../Api.php";
$api = new Api();
?>

<section id="<?=$ger_slug?>">
    <div class="row">


        <div class="span9">

            <div id="alert-heading">

            </div>

            <?php
            switch(@$_GET['act']) {
                case "Inserir":
                    ?>
                    <form method="post" name="cadform" id="cadform" action="<?=$ger_arquivo?>?x=inserirContato&act=Gravar" class="well form-horizontal">
                        <fieldset>
                            <div class="control-group" id="grp_nome">
                                <label class="control-label">Nome</label>
                                <div class="controls">
                                    <input type="text" class="input-xlarge" name="nome" id="nome" value="" maxlength="255">
                                </div>
                            </div>
                            <div class="control-group" id="grp_telefone">
                                <label class="control-label">Telefone</label>
                                <div class="controls">
                                    <input type="text" class="input-xlarge" name="telefone" id="telefone" value="" maxlength="255">
                                </div>
                            </div>
                            <div class="control-group" id="grp_celular">
                                <label class="control-label">Celular</label>
                                <div class="controls">
                                    <input type="text" class="input-xlarge" name="celular" id="celular" value="" maxlength="20">
                                </div>
                            </div>
                            <br />
                            <div class="form-actions">
                                <button class="btn btn-primary" type="submit">Inserir</button>
                                <a href="<?=$ger_arquivo?>?x=contatos" class="btn">Voltar</a>
                            </div>
                        </fieldset>
                    </form>
                    <?php
                    break;
                case "Alterar":

                    $rs = $api->processaApi();
                    ?>
                    <form method="post" name="cadform" id="cadform" action="<?=$ger_arquivo?>?x=atualizarContato&act=Atualizar" class="well form-horizontal">
                        <fieldset>
                            <div class="control-group" id="grp_nome">
                                <label class="control-label">Nome</label>
                                <div class="controls">
                                    <input type="text" class="input-xlarge" name="nome" id="nome" value="<?=$rs[0]['nome']?>" maxlength="255">
                                </div>
                            </div>
                            <div class="control-group" id="grp_telefone">
                                <label class="control-label">Telefone</label>
                                <div class="controls">
                                    <input type="text" class="input-xlarge" name="telefone" id="telefone" value="<?=$rs[0]['telefone']?>" maxlength="255">
                                </div>
                            </div>
                            <div class="control-group" id="grp_celular">
                                <label class="control-label">Celular</label>
                                <div class="controls">
                                    <input type="text" class="input-xlarge" name="celular" id="celular" value="<?=$rs[0]['celular']?>">
                                </div>
                            </div>
                            <br />
                            <div class="form-actions">
                                <input type="hidden" name="id" id="id" value="<?=$rs[0]['id']?>">
                                <button class="btn btn-primary" type="submit">Alterar</button>
                                <a href="<?=$ger_arquivo?>?x=contatos" class="btn">Voltar</a>
                            </div>
                        </fieldset>
                    </form>
                    <?php
                    break;
                default:
                    ?>
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Telefone</th>
                            <th>Celular</th>
                            <th>Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php

                        $rs = $api->processaApi();
                        if(is_array($rs)) {
                            foreach ($rs as $key => $row) {
                                ?>
                                <tr>
                                    <td><?= $row['nome'] ?></td>
                                    <td><?= $row['telefone'] ?></td>
                                    <td><?= $row['celular'] ?></td>
                                    <td class="span1"><a href="crud.php?x=contato&act=Alterar&id=<?= $row['id'] ?>"><i
                                                    class="material-icons">&#xE147;</i>Editar</a></td>
                                    <td class="span1"><a
                                                href="crud.php?x=deletarContato&act=Alterar&id=<?= $row['id'] ?>"
                                                class="botexcluir" rel="<?= $row['id'] ?>"><i class="material-icons">&#xE15C;</i>Excluir</a>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                    <?php
                    break;
            }
            ?>

        </div>
</section>
<?php require_once "rodape.php";?>
