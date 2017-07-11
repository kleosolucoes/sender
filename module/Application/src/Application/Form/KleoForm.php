<?php

namespace Application\Form;

use Zend\Form\Element\Hidden;
use Zend\Form\Element\Csrf;
use Zend\Form\Form;

/**
 * Nome: KleoForm.php
 * @author Leonardo Pereira Magalhães <falecomleonardopereira@gmail.com>
 * Descricao: Formulario base  
 *              
 */
class KleoForm extends Form {

  const inputNome = 'inputNome';
  const inputUltimoNome = 'inputUltimoNome';
  const inputTelefone = 'inputTelefone';
  const inputEmail = 'inputEmail';
  const inputRepetirEmail = 'inputRepetirEmail';
  const inputNomeEmpresa = 'inputNomeEmpresa';
  const inputCNPJ = 'inputCNPJ';  
  const inputSenha = 'inputSenha';
  const inputRepetirSenha = 'inputRepetirSenha';
  const inputPais = 'inputPais';
  const inputTermo = 'inputTermo';

  const inputId = 'inputId';
  const inputCSRF = 'inputCSRF';
  const inputSituacao = 'inputSituacao';

  const inputDescricao = 'inputDescricao';
  const inputDataEnvio = 'inputDataEnvio';
  const inputFotoPerfil = 'inputFotoPerfil';
  const inputUpload = 'inputUpload';
  const inputMensagem = 'inputMensagem';
  const onChange = 'onChange';

  const stringClass = 'class';
  const stringClassFormControl = 'form-control';
  const stringId = 'id';
  const stringPlaceholder = 'placeholder';
  const stringAction = 'action';
  const stringRequired = 'required';
  const stringValue = 'value';
  const stringOnblur = 'onblur';
  const stringValidacoesFormulario = 'validacoesFormulario(this);';

  const traducaoNome = 'Nome do Responsável';
  const traducaoPrimeiroNome = 'Primeiro Nome';
  const traducaoUltimoNome = 'Último Nome';
  const traducaoTelefone = 'Telefone';
  const traducaoEmail = 'Email';
  const traducaoRepetirEmail = 'Repita o Email';
  const traducaoNomeEmpresa = 'Nome Empresa';
  const traducaoCNPJ = 'CNPJ';
  const traducaoSenha = 'Senha';
  const traducaoRepetirSenha = 'Repetir Senha';
  const traducaoSelecioneOPais = 'Selecione o Pais';
  const traducaoTermo = 'Termo de Aceita&ccedil;&atilde;o';

  const traducaoSituacao = 'Situação';
  const traducaoSelecione = 'Selecione';

  const traducaoNomeCampanha = 'Nome da campanha';
  const traducaoDescricao = 'Desci&ccedil;&atilde;o';
  const traducaoDataEnvio = 'Data de Envio';
  const traducaoFotoPerfil = 'Foto de Perfil';
  const traducaoUpload = 'Imagem / Video / Audio';
  const traducaoMensagem = 'Mensagem';
  
  const traducaoBrasil = 'BRASIL';

  public function __construct($name = null) {

    parent::__construct($name);
    $this->setAttributes(array(
      'method' => 'post',
    ));

    $this->add(
      (new Hidden())
      ->setName(self::inputId)
      ->setAttributes([
      self::stringId => self::inputId,
    ])
    );

    $this->add(
      (new Csrf())
      ->setName('inputCSRF')
    );
  }
}