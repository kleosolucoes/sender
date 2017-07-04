<?php

namespace Application\Controller;

use Doctrine\ORM\EntityManager;
use Zend\View\Model\ViewModel;
use Application\Model\Entity\Responsavel;
use Application\Model\Entity\ResponsavelSituacao;
use Application\Model\Entity\Loja;
use Application\Model\Entity\LojaSituacao;
use Application\Model\Entity\Shopping;
use Application\Model\Entity\Campanha;
use Application\Model\Entity\CampanhaSituacao;
use Application\Model\Entity\CampanhaCategoria;
use Application\Model\Entity\Categoria;
use Application\Model\ORM\RepositorioORM;
use Application\Form\CadastroResponsavelForm;
use Application\Form\CadastroLojaForm;
use Application\Form\CadastroShoppingForm;
use Application\Form\ResponsavelSituacaoForm;
use Application\Form\ResponsavelAtualizacaoForm;
use Application\Form\ResponsavelSenhaAtualizacaoForm;
use Application\Form\LojaSituacaoForm;
use Application\Form\CadastroCampanhaForm;
use Application\Form\CadastroCategoriaForm;
use Application\Form\KleoForm;

/**
 * Nome: AdmController.php
 * @author Leonardo Pereira Magalhães <falecomleonardopereira@gmail.com>
 * Descricao: Controle de todas ações da admintração
 */
class AdmController extends KleoController {

    /**
     * Contrutor sobrecarregado com os serviços de ORM
     */
    public function __construct(EntityManager $doctrineORMEntityManager = null) {

        if (!is_null($doctrineORMEntityManager)) {
            parent::__construct($doctrineORMEntityManager);
        }
    }

    public function indexAction() {

        return new ViewModel();
    }

    /**
     * Função padrão, traz a tela principal
     * GET /admResponsaveis
     */
    public function responsaveisAction() {

        $repositorioORM = new RepositorioORM($this->getDoctrineORMEntityManager());
        $responsaveis = $repositorioORM->getResponsavelORM()->encontrarTodos();
        return new ViewModel(
                array(
            'responsaveis' => $responsaveis,
                )
        );
    }

    /**
     * Formulario para alterar situacao
     * GET /admResponsavelSituacao
     */
    public function responsavelSituacaoAction() {

        $this->getSessao();

        $repositorioORM = new RepositorioORM($this->getDoctrineORMEntityManager());
        $sessao = self::getSessao();
        $idResponsavel = $sessao->idSessao;
        if (empty($idResponsavel)) {
            return $this->redirect()->toRoute(self::rotaAdm, array(
                        self::stringAction => 'responsaveis',
            ));
        }
        unset($sessao->idSessao);

        $responsavel = $repositorioORM->getResponsavelORM()->encontrarPorId($idResponsavel);
        $situacoes = $repositorioORM->getSituacaoORM()->encontrarTodos();

        $responsavelSituacaoForm = new ResponsavelSituacaoForm('ResponsavelSituacao', $idResponsavel, $situacoes, $responsavel->getResponsavelSituacaoAtivo()->getSituacao()->getId());
        return new ViewModel(
                array(
            self::stringFormulario => $responsavelSituacaoForm,
            'responsavel' => $responsavel,
        ));
    }

    /**
     * Ação para alterar situacao
     * GET /admResponsavelSituacaoFinalizar
     */
    public function responsavelSituacaoFinalizarAction() {
        $request = $this->getRequest();
        if ($request->isPost()) {
            try {
                $post_data = $request->getPost();
                $repositorioORM = new RepositorioORM($this->getDoctrineORMEntityManager());
                $responsavel = $repositorioORM->getResponsavelORM()->encontrarPorId($post_data[KleoForm::inputId]);

                $gerar = false;
                if ($responsavel->getResponsavelSituacaoAtivo()->getSituacao()->getId() !== intval($post_data[KleoForm::inputSituacao])) {
                    $gerar = true;
                }
                if ($gerar) {
                    $token = '';
                    $situacaoAtivo = 1;

                    $responsavelSituacaoAtivo = $responsavel->getResponsavelSituacaoAtivo();
                    $responsavelSituacaoAtivo->setDataEHoraDeInativacao();
                    $repositorioORM->getResponsavelSituacaoORM()->persistir($responsavelSituacaoAtivo, false);

                    $situacao = $repositorioORM->getSituacaoORM()->encontrarPorId($post_data[KleoForm::inputSituacao]);
                    $responsavelSituacao = new ResponsavelSituacao();
                    $responsavelSituacao->setResponsavel($responsavel);
                    $responsavelSituacao->setSituacao($situacao);

                    $repositorioORM->getResponsavelSituacaoORM()->persistir($responsavelSituacao);

                    $emails[] = $responsavel->getEmail();
                    $titulo = self::emailTitulo;
                    $mensagem = '';
                    if (intval($post_data[KleoForm::inputSituacao]) === $situacaoAtivo) {
                        $mensagem = '<p>Cadastro ativado</p>';
                        $mensagem .= '<p>Usuario: ' . $responsavel->getEmail() . '</p>';
                        $mensagem .= '<p><a href="' . self::url . 'pubResponsavelSenhaAtualizacao/' . $token . '">Clique aqui cadastrar sua senha</a></p>';
                    }
                    self::enviarEmail($emails, $titulo, $mensagem);
                }

                return $this->redirect()->toRoute(self::rotaAdm, array(
                            self::stringAction => 'responsaveis',
                ));
            } catch (Exception $exc) {
                echo $exc->getMessage();
            }
        }
    }

    /**
     * Formulario para ver responsavel
     * GET /admResponsavelVer
     */
    public function responsavelVerAction() {

        $this->getSessao();

        $repositorioORM = new RepositorioORM($this->getDoctrineORMEntityManager());
        $sessao = self::getSessao();
        $idResponsavel = $sessao->idSessao;
        if (empty($idResponsavel)) {
            return $this->redirect()->toRoute(self::rotaAdm, array(
                        self::stringAction => 'responsaveis',
            ));
        }
        unset($sessao->idSessao);

        $responsavel = $repositorioORM->getResponsavelORM()->encontrarPorId($idResponsavel);

        return new ViewModel(
                array(
            'responsavel' => $responsavel,
        ));
    }

    /**
     * Tela com listagem de campanhas
     * GET /admCampanhas
     */
    public function campanhasAction() {

        $repositorioORM = new RepositorioORM($this->getDoctrineORMEntityManager());
        $campanhas = $repositorioORM->getCampanhaORM()->encontrarTodos();
        return new ViewModel(
                array(
            'campanhas' => $campanhas,
                )
        );
    }

    /**
     * Tela com listagem de campanha
     * GET /admCampanha
     */
    public function campanhaAction() {
        $formulario = $this->params()->fromRoute(self::stringFormulario);

        if ($formulario) {
            $cadastroCampanhaForm = $formulario;
        } else {
            $cadastroCampanhaForm = new CadastroCampanhaForm('cadastroCampanha');
        }
        return new ViewModel(
                array(self::stringFormulario => $cadastroCampanhaForm,)
        );
    }

    /**
     * Função para validar e finalizar cadastro
     * GET /admCampanhaFinalizar
     */
    public function campanhaFinalizarAction() {
        $request = $this->getRequest();
        if ($request->isPost()) {
            try {

                $campanha = new Campanha();
                $repositorioORM = new RepositorioORM($this->getDoctrineORMEntityManager());


                $cadastrarCampanhaForm = new CadastroCampanhaForm(null);
                $cadastrarCampanhaForm->setInputFilter($campanha->getInputFilterCadastrarCampanha());

                $post = array_merge_recursive(
                        $request->getPost()->toArray(), $request->getFiles()->toArray()
                );

                $cadastrarCampanhaForm->setData($post);

                /* validação */
                if ($cadastrarCampanhaForm->isValid()) {
                    $validatedData = $cadastrarCampanhaForm->getData();
                    $campanha->exchangeArray($cadastrarCampanhaForm->getData());

                    $apenasAjustarEntidade = false;
                    $campanha = self::escreveDocumentos($campanha, $apenasAjustarEntidade);

                    $idResposanvelLogado = 50; // temporario
                    $responsavel = $repositorioORM->getResponsavelORM()->encontrarPorId($idResposanvelLogado);
                    $campanha->setResponsavel($responsavel);
                    $repositorioORM->getCampanhaORM()->persistir($campanha);

                    $campanha = self::escreveDocumentos($campanha);
                    $repositorioORM->getCampanhaORM()->persistir($campanha);

                    $situacao = $repositorioORM->getSituacaoORM()->encontrarPorId(Situacao::ativo);
                    $campanhaSituacao = new CampanhaSituacao();
                    $campanhaSituacao->setCampanha($campanha);
                    $campanhaSituacao->setSituacao($situacao);
                    $repositorioORM->getCampanhaSituacaoORM()->persistir($campanhaSituacao);

                    return $this->redirect()->toRoute(self::rotaAdm, array(
                                self::stringAction => 'campanhas',
                    ));
                } else {
                    return $this->forward()->dispatch(self::controllerAdm, array(
                                self::stringAction => 'campanha',
                                self::stringFormulario => $cadastrarCampanhaForm,
                    ));
                }
            } catch (Exception $exc) {
                echo $exc->getMessage();
            }
        }
        return new ViewModel();
    }

}
