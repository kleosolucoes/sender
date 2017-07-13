<?php

namespace Application\Controller;

use Doctrine\ORM\EntityManager;
use Zend\View\Model\ViewModel;
use Application\Model\Entity\Responsavel;
use Application\Model\Entity\ResponsavelSituacao;
use Application\Model\Entity\Campanha;
use Application\Model\Entity\Lista;
use Application\Model\Entity\CampanhaSituacao;
use Application\Model\Entity\Situacao;
use Application\Model\ORM\RepositorioORM;
use Application\Form\CadastroResponsavelForm;
use Application\Form\ResponsavelSituacaoForm;
use Application\Form\CampanhaSituacaoForm;
use Application\Form\ResponsavelSenhaAtualizacaoForm;
use Application\Form\CadastroCampanhaForm;
use Application\Form\CadastroListaForm;
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
      $repositorioORM = new RepositorioORM($this->getDoctrineORMEntityManager());
      try {
        $repositorioORM->iniciarTransacao();
        $post_data = $request->getPost();
        $responsavel = $repositorioORM->getResponsavelORM()->encontrarPorId($post_data[KleoForm::inputId]);

        $gerar = false;
        if ($responsavel->getResponsavelSituacaoAtivo()->getSituacao()->getId() !== intval($post_data[KleoForm::inputSituacao])) {
          $gerar = true;
        }
        if ($gerar) {
          $token = '';
          $intValIdSituacao = intval($post_data[KleoForm::inputSituacao]);
          if($intValIdSituacao === Situacao::ativo){
            $token = $responsavel->gerarToken();
            $responsavel->setToken($token);
            $repositorioORM->getResponsavelORM()->persistir($responsavel, false);
          }

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

          if ($intValIdSituacao === Situacao::ativo) {
            $mensagem = '<p>Cadastro ativado</p>';
            $mensagem .= '<p>Usuario: ' . $responsavel->getEmail() . '</p>';
            $mensagem .= '<p><a href="' . self::url . 'responsavelSenhaAtualizacao/' . $token . '">Clique aqui cadastrar sua senha</a></p>';
          }
          self::enviarEmail($emails, $titulo, $mensagem);
          $repositorioORM->fecharTransacao();
        }else{
          $repositorioORM->desfazerTransacao();
        }
        return $this->redirect()->toRoute(self::rotaAdm, array(
          self::stringAction => 'responsaveis',
        ));
      } catch (Exception $exc) {
        $repositorioORM->desfazerTransacao();
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
    $sessao = $this->getSessao();
    $repositorioORM = new RepositorioORM($this->getDoctrineORMEntityManager());
    $campanhas = $repositorioORM->getCampanhaORM()->encontrarPorIdResponsavel($sessao->idResponsavel);

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
    $sessao = $this->getSessao();
    $request = $this->getRequest();
    if ($request->isPost()) {
      $repositorioORM = new RepositorioORM($this->getDoctrineORMEntityManager());
      try {
        $repositorioORM->iniciarTransacao();

        $campanha = new Campanha();

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

          $responsavel = $repositorioORM->getResponsavelORM()->encontrarPorId($sessao->idResponsavel);
          $campanha->setResponsavel($responsavel);
          $repositorioORM->getCampanhaORM()->persistir($campanha);

          $campanha = self::escreveDocumentos($campanha);
          $repositorioORM->getCampanhaORM()->persistir($campanha);

          $situacaoPendente = $repositorioORM->getSituacaoORM()->encontrarPorId(Situacao::pendente);
          $campanhaSituacao = new CampanhaSituacao();
          $campanhaSituacao->setCampanha($campanha);
          $campanhaSituacao->setSituacao($situacaoPendente);
          $repositorioORM->getCampanhaSituacaoORM()->persistir($campanhaSituacao);

          $repositorioORM->fecharTransacao();
          return $this->redirect()->toRoute(self::rotaAdm, array(
            self::stringAction => 'campanhas',
          ));
        } else {
          $repositorioORM->desfazerTransacao();
          return $this->forward()->dispatch(self::controllerAdm, array(
            self::stringAction => 'campanha',
            self::stringFormulario => $cadastrarCampanhaForm,
          ));
        }
      } catch (Exception $exc) {
        $repositorioORM->desfazerTransacao();
        echo $exc->getMessage();
      }
    }
    return new ViewModel();
  }

  /**
     * Formulario para alterar situacao
     * GET /admCampanhaSituacao
     */
  public function campanhaSituacaoAction() {

    $this->getSessao();

    $repositorioORM = new RepositorioORM($this->getDoctrineORMEntityManager());
    $sessao = self::getSessao();
    $idSessao = $sessao->idSessao;
    if (empty($idSessao)) {
      return $this->redirect()->toRoute(self::rotaAdm, array(
        self::stringAction => 'campanhas',
      ));
    }
    unset($sessao->idSessao);

    $campanha = $repositorioORM->getCampanhaORM()->encontrarPorId($idSessao);
    $situacoes = $repositorioORM->getSituacaoORM()->encontrarTodos();

    $campanhaSituacaoForm = new CampanhaSituacaoForm('CampanhaSituacao', $idSessao, $situacoes, $campanha->getCampanhaSituacaoAtivo()->getSituacao()->getId());
    return new ViewModel(
      array(
      self::stringFormulario => $campanhaSituacaoForm,
      'campanha' => $campanha,
    ));
  }

  /**
     * Ação para alterar situacao
     * GET /admCampanhaSituacaoFinalizar
     */
  public function campanhaSituacaoFinalizarAction() {
    $request = $this->getRequest();
    if ($request->isPost()) {
      $repositorioORM = new RepositorioORM($this->getDoctrineORMEntityManager());
      try {
        $repositorioORM->iniciarTransacao();
        $post_data = $request->getPost();
        $campanha = $repositorioORM->getCampanhaORM()->encontrarPorId($post_data[KleoForm::inputId]);
        $intValIdSituacao = intval($post_data[KleoForm::inputSituacao]);

        $gerar = false;
        if ($campanha->getCampanhaSituacaoAtivo()->getSituacao()->getId() !== $intValIdSituacao) {
          $gerar = true;
        }
        if ($gerar) {        

          $campanhaSituacaoAtivo = $campanha->getCampanhaSituacaoAtivo();
          $campanhaSituacaoAtivo->setDataEHoraDeInativacao();
          $repositorioORM->getCampanhaSituacaoORM()->persistir($campanhaSituacaoAtivo, false);

          $situacao = $repositorioORM->getSituacaoORM()->encontrarPorId($post_data[KleoForm::inputSituacao]);
          $campanhaSituacao = new CampanhaSituacao();
          $campanhaSituacao->setCampanha($campanha);
          $campanhaSituacao->setSituacao($situacao);
          $repositorioORM->getCampanhaSituacaoORM()->persistir($campanhaSituacao);

          $emails[] = $campanha->getResponsavel()->getEmail();
          $titulo = self::emailTitulo;
          $mensagem = '';

          if ($intValIdSituacao === Situacao::ativo) {
            $mensagem = '<p>Campanha aprovada</p>';
            $mensagem .= '<p>Campanha: ' . $campanha->getNome() . '</p>';
            $mensagem .= '<p>Data de envio: ' . $campanha->getData_envio()->format('d/m/Y') . '</p>';
          }
          self::enviarEmail($emails, $titulo, $mensagem);
          $repositorioORM->fecharTransacao();
        }else{
          $repositorioORM->desfazerTransacao();
        }
        return $this->redirect()->toRoute(self::rotaAdm, array(
          self::stringAction => 'campanhas',
        ));
      } catch (Exception $exc) {
        $repositorioORM->desfazerTransacao();
        echo $exc->getMessage();
      }
    }
  }

  /**
     * Tela com listagem de contatos
     * GET /admlistas
     */
  public function listasAction() {
    $sessao = $this->getSessao();
    $repositorioORM = new RepositorioORM($this->getDoctrineORMEntityManager());
    $listas = $repositorioORM->getListaORM()->encontrarPorIdResponsavel($sessao->idResponsavel);

    return new ViewModel(
      array(
      'listas' => $listas,
    )
    );
  }

  /**
     * Tela com listagem de campanha
     * GET /admlista
     */
  public function listaAction() {
    $formulario = $this->params()->fromRoute(self::stringFormulario);

    if ($formulario) {
      $cadastroListaForm = $formulario;
    } else {
      $cadastroListaForm = new CadastroListaForm('cadastroLista');
    }
    return new ViewModel(
      array(self::stringFormulario => $cadastroListaForm,)
    );
  }

  /**
     * Função para validar e finalizar cadastro
     * GET /admListaFinalizar
     */
  public function listaFinalizarAction() {
    $sessao = $this->getSessao();
    $request = $this->getRequest();
    if ($request->isPost()) {
      $repositorioORM = new RepositorioORM($this->getDoctrineORMEntityManager());
      try {
        $repositorioORM->iniciarTransacao();

        $lista = new Lista();

        $cadastrarListaForm = new CadastroListaForm(null);
        $cadastrarListaForm->setInputFilter($lista->getInputFilterCadastrarLista());

        $post = array_merge_recursive(
          $request->getPost()->toArray(), $request->getFiles()->toArray()
        );

        $cadastrarListaForm->setData($post);

        /* validação */
        if ($cadastrarListaForm->isValid()) {
          $validatedData = $cadastrarListaForm->getData();
          $lista->exchangeArray($cadastrarListaForm->getData());

          $apenasAjustarEntidade = false;
          $resposta = self::escreveDocumentos($lista, $apenasAjustarEntidade);
          if(!$resposta){
            $repositorioORM->desfazerTransacao();
            $cadastrarListaForm->get(KleoForm::inputUpload)->setMessages(array('Não é arquivo CSV'));
            return $this->forward()->dispatch(self::controllerAdm, array(
              self::stringAction => 'lista',
              self::stringFormulario => $cadastrarListaForm,
            ));
          }
          $lista = $resposta;

          $responsavel = $repositorioORM->getResponsavelORM()->encontrarPorId($sessao->idResponsavel);
          $lista->setResponsavel($responsavel);
          $repositorioORM->getListaORM()->persistir($lista);

          $lista = self::escreveDocumentos($lista);
          $repositorioORM->getListaORM()->persistir($lista);        

          $repositorioORM->fecharTransacao();
          return $this->redirect()->toRoute(self::rotaAdm, array(
            self::stringAction => 'listas',
          ));
        } else {
          $repositorioORM->desfazerTransacao();
          return $this->forward()->dispatch(self::controllerAdm, array(
            self::stringAction => 'lista',
            self::stringFormulario => $cadastrarListaForm,
          ));
        }
      } catch (Exception $exc) {
        $repositorioORM->desfazerTransacao();
        echo $exc->getMessage();
      }
    }
    return new ViewModel();
  }

  /**
     * Função que direciona a tela de acesso
     * GET /sair
     */
  public function sairAction() {
    /* Fechando a sessão */
    $sessao = $this->getSessao();
    $sessao->getManager()->destroy();

    /* Redirecionamento */
    return $this->redirect()->toRoute(self::rotaPub, array(
      self::stringAction => self::stringLogin,
    ));
  }

}
