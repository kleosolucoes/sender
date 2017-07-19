<?php

namespace Application\Controller;

use Doctrine\ORM\EntityManager;
use Zend\Authentication\AuthenticationService;
use Zend\View\Model\ViewModel;
use Application\Model\Entity\Responsavel;
use Application\Model\Entity\ContaCorrente;
use Application\Model\Entity\ContaCorrenteSituacao;
use Application\Model\Entity\ResponsavelSituacao;
use Application\Model\Entity\Situacao;
use Application\Model\ORM\RepositorioORM;
use Application\Form\CadastroResponsavelForm;
use Application\Form\ResponsavelAtualizacaoForm;
use Application\Form\ResponsavelSenhaAtualizacaoForm;
use Application\Form\LoginForm;
use Application\Form\KleoForm;

class PubController extends KleoController {

  private $_doctrineAuthenticationService;

  /**
     * Contrutor sobrecarregado com os serviços de ORM
     */
  public function __construct(EntityManager $doctrineORMEntityManager = null, AuthenticationService $doctrineAuthenticationService = null) {

    if (!is_null($doctrineORMEntityManager)) {
      parent::__construct($doctrineORMEntityManager);
    }
    if (!is_null($doctrineAuthenticationService)) {
      $this->_doctrineAuthenticationService = $doctrineAuthenticationService;
    }
  }

  /**
     * Função padrão, traz a tela principal
     * GET /
     */
  public function indexAction() {

    $this->setLayoutSite();

    $formulario = $this->params()->fromRoute(self::stringFormulario);
    if ($formulario) {
      $cadastroResponsavelForm = $formulario;
    } else {
      $cadastroResponsavelForm = new CadastroResponsavelForm('cadastroResponsavel');
    }

    return new ViewModel(
      array(
      self::stringFormulario => $cadastroResponsavelForm,
    )
    );
  }

  /**     
     * POST /responsavelFinalizar
     */
  public function responsavelFinalizarAction() {
    $request = $this->getRequest();
    if ($request->isPost()) {
      $repositorioORM = new RepositorioORM($this->getDoctrineORMEntityManager());
      try {
        $repositorioORM->iniciarTransacao();
        $post_data = $request->getPost();
        $responsavel = new Responsavel();
        $cadastrarResponsavelForm = new CadastroResponsavelForm();
        $cadastrarResponsavelForm->setInputFilter($responsavel->getInputFilterCadastrarResponsavel());
        $cadastrarResponsavelForm->setData($post_data);

        /* validação */
        if ($cadastrarResponsavelForm->isValid()) {

          $validatedData = $cadastrarResponsavelForm->getData();
          $responsavel->exchangeArray($cadastrarResponsavelForm->getData());

          $repositorioORM->getResponsavelORM()->persistir($responsavel);

          $situacaoPrimeiroContato = $repositorioORM->getSituacaoORM()->encontrarPorId(Situacao::primeiroContato);
          $responsavelSituacao = new ResponsavelSituacao();
          $responsavelSituacao->setResponsavel($responsavel);
          $responsavelSituacao->setSituacao($situacaoPrimeiroContato);

          $repositorioORM->getResponsavelSituacaoORM()->persistir($responsavelSituacao);

          $emails[] = $validatedData[KleoForm::inputEmail];

          $titulo = self::emailTitulo;
          $mensagem = '<p>Seu cadastro inicial foi concluido</p>
          <p>Em breve um dos nosso executivos entrará em contato.</p>';

          self::enviarEmail($emails, $titulo, $mensagem);
          unset($emails);
          //$emails[] = self::emailLeo;
          $emails[] = self::emailKort;
          $emails[] = self::emailSilverio;
          $urlResponsaveis = self::url . 'admResponsaveis';

          $titulo = 'Primeiro Contato';
          $mensagem .= '<p>Resposavel ' . $responsavel->getNome() . '</p>';
          $mensagem .= '<p>Telefone <a href="tel:' . $responsavel->getTelefone() . '">' . $responsavel->getTelefone() . '</a></p>';
          $mensagem .= '<p>Email ' . $responsavel->getEmail() . '</p>';
          $mensagem .= '<p><a href="' . $urlResponsaveis . '">Visualizar</a></p>';

          self::enviarEmail($emails, $titulo, $mensagem);

          $repositorioORM->fecharTransacao();

          return $this->redirect()->toRoute(self::rotaPub, array(
            self::stringAction => 'responsavelFinalizado',
          ));

        } else {
          //self::mostrarMensagensDeErroFormulario($cadastrarResponsavelForm->getMessages());

          $repositorioORM->desfazerTransacao();       

          return $this->forward()->dispatch(self::controllerPub, array(
            self::stringAction =>  self::stringIndex,
            self::stringFormulario => $cadastrarResponsavelForm,
          ));

        }
      } catch (Exception $exc) {
        $repositorioORM->desfazerTransacao();
        echo $exc->getMessage();
      }
    }
  }

  /**
     * Função padrão, traz a tela principal
     * GET /cadastroResponsavelFinalizado
     */
  public function responsavelFinalizadoAction() {
    return new ViewModel();
  }

  /**
     * Função padrão, traz a tela principal
     * GET /cadastroResponsavelAlterado
     */
  public function responsavelAlteradoAction() {
    return new ViewModel();
  }

  /**
     * Função padrão, traz a tela principal
     * GET /cadastroResponsavelAlterado
     */
  public function responsavelSenhaCadastradoAction() {
    return new ViewModel();
  }

  /**
     * Formulario para alterar dados do responsavel
     * GET /cadastroResponsavelSenhaAtualizacao
     */
  public function responsavelSenhaAtualizacaoAction() {

    $repositorioORM = new RepositorioORM($this->getDoctrineORMEntityManager());
    $formulario = $this->params()->fromRoute(self::stringFormulario);
    if ($formulario) {
      $responsavelSenhaAtualizacaoForm = $formulario;
      $inputToken = $formulario->get(KleoForm::inputId);
      $responsavel = $repositorioORM->getResponsavelORM()->encontrarPorToken($inputToken->getValue());
      $responsavel->setId($inputToken->getValue());
    } else {
      $token = $this->getEvent()->getRouteMatch()->getParam(self::stringToken);
      $responsavel = $repositorioORM->getResponsavelORM()->encontrarPorToken($token);
      $responsavel->setId($token);
      $responsavelSenhaAtualizacaoForm = new ResponsavelSenhaAtualizacaoForm('ResponsavelSenhaAtualizacao', $responsavel);
    }

    return new ViewModel(
      array(
      self::stringFormulario => $responsavelSenhaAtualizacaoForm,
      KleoForm::inputEmail => $responsavel->getEmail(),
    ));
  }

  /**
     * Atualiza a senha do responsavel
     * GET /cadastroResponsavelSenhaAtualizar
     */
  public function responsavelSenhaAtualizarAction() {
    $request = $this->getRequest();
    if ($request->isPost()) {
      $repositorioORM = new RepositorioORM($this->getDoctrineORMEntityManager());
      try {
        $repositorioORM->iniciarTransacao();

        $post_data = $request->getPost();
        $token = $post_data[KleoForm::inputId];
        $responsavel = $repositorioORM->getResponsavelORM()->encontrarPorToken($token);

        $responsavelSenhaAtualizacaoForm = new ResponsavelSenhaAtualizacaoForm(null, $responsavel);
        $responsavelSenhaAtualizacaoForm->setInputFilter($responsavel->getInputFilterCadastrarSenhaResponsavel());

        $responsavelSenhaAtualizacaoForm->setData($post_data);

        if ($responsavelSenhaAtualizacaoForm->isValid()) {

          $responsavel->exchangeArray($responsavelSenhaAtualizacaoForm->getData());
          $responsavel->setToken(null);

          $repositorioORM = new RepositorioORM($this->getDoctrineORMEntityManager());
          $repositorioORM->getResponsavelORM()->persistir($responsavel);

          /* Colocando 10 creditos */
          $contaCorrente = new ContaCorrente();
          $contaCorrente->setResponsavel($responsavel);
          $contaCorrente->setValor(10);
          $repositorioORM->getContaCorrenteORM()->persistir($contaCorrente);

          $situacaoAtivo = $repositorioORM->getSituacaoORM()->encontrarPorId(Situacao::ativo);
          $contaCorrenteSituacao = new ContaCorrenteSituacao();
          $contaCorrenteSituacao->setConta_corrente($contaCorrente);
          $contaCorrenteSituacao->setSituacao($situacaoAtivo);
          $repositorioORM->getContaCorrenteSituacaoORM()->persistir($contaCorrenteSituacao);
          /* Fim creditos */

          $emails[] = $responsavel->getEmail();
          $titulo = self::emailTitulo;
          $mensagem = '';
          $mensagem = '<p>Senha Cadastra com Sucesso</p>';
          $mensagem .= '<p>Usuario: ' . $responsavel->getEmail() . '</p>';
          $mensagem .= '<p>Senha: ' . $post_data[KleoForm::inputSenha] . '</p>';
          $mensagem .= '<p><a href="' . self::url . 'login">Clique aqui acessar</a></p>';
          self::enviarEmail($emails, $titulo, $mensagem);

          $repositorioORM->fecharTransacao();

          return $this->redirect()->toRoute(self::rotaPub, array(
            self::stringAction => 'responsavelSenhaCadastrado',
          ));
        } else {
          $repositorioORM->desfazerTransacao();
          return $this->forward()->dispatch(self::controllerPub, array(
            self::stringAction => 'responsavelSenhaAtualizacao',
            self::stringFormulario => $responsavelSenhaAtualizacaoForm,
          ));
        }
      } catch (Exception $exc) {
        $repositorioORM->desfazerTransacao();
        echo $exc->getMessage();
      }
    }
    return new ViewModel();
  }

  public function loginAction() {

    $formulario = $this->params()->fromRoute(self::stringFormulario);
    if ($formulario) {
      $loginForm = $formulario;
    } else {
      $loginForm = new LoginForm('login');
    }
    $token = $this->getEvent()->getRouteMatch()->getParam(self::stringToken);
    return new ViewModel(
      array(
      self::stringFormulario => $loginForm,
      'error' => $token,
    )
    );
  }

  public function logarAction() {

    $data = $this->getRequest()->getPost();

    $usuarioTrim = trim($data[KleoForm::inputEmail]);
    $senhaTrim = trim($data[KleoForm::inputSenha]);
    $adapter = $this->getDoctrineAuthenticationServicer()->getAdapter();
    $adapter->setIdentityValue($usuarioTrim);
    $adapter->setCredentialValue(md5($senhaTrim));
    $authenticationResult = $this->getDoctrineAuthenticationServicer()->authenticate();

    if ($authenticationResult->isValid()) {
      /* Autenticacao valida */
      /* Helper Controller */
      $repositorioORM = new RepositorioORM($this->getDoctrineORMEntityManager());
      /* Verificar se existe responsavel por email informado */
      $responsavel = $repositorioORM->getResponsavelORM()->encontrarPorEmail($usuarioTrim);
      /* Se o responsavel esta ativo */
      $reponsavelSituacaoAtivo = $responsavel->getResponsavelSituacaoAtivo();

      if ($reponsavelSituacaoAtivo->getSituacao()->getId() === Situacao::ativo) {
        /* Registro de sessão */
        $sessao = $this->getSessao();
        $sessao->idResponsavel = $responsavel->getId();

        return $this->redirect()->toRoute(self::rotaAdm, array(
          self::stringAction => self::stringCampanhas,
        ));
      } else {
        return $this->forward()->dispatch(self::controllerPub, array(
          self::stringAction => self::stringLogin,
        ));
      }
    } else {
      return $this->forward()->dispatch(KleoController::controllerPub, array(
        self::stringAction => self::stringLogin,
        self::stringToken => 'Login invalido',
      ));
    }
  }

  /**
     * Recupera autenticação doctrine
     * @return AuthenticationService
     */
  public function getDoctrineAuthenticationServicer() {
    return $this->_doctrineAuthenticationService;
  }

}
