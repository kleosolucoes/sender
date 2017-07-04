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
  const inputDDD = 'inputDDD';
  const inputTelefone = 'inputTelefone';
  const inputEmail = 'inputEmail';
  const inputRepetirEmail = 'inputRepetirEmail';
  const inputCPF = 'inputCPF';
  const inputDia = 'inputDia';
  const inputMes = 'inputMes';
  const inputAno = 'inputAno';
  const inputUploadCPF = 'inputUploadCPF';

  const inputNomeFantasia = 'inputNomeFantasia';
  const inputRazaoSocial = 'inputRazaoSocial';
  const inputUploadContratoSocial = 'inputUploadContratoSocial';
  const inputCNPJ = 'inputCNPJ';
  const inputDDDEmpresa = 'inputDDDEmpresa';
  const inputTelefoneEmpresa = 'inputTelefoneEmpresa';
  const inputEmailEmpresa = 'inputEmailEmpresa';
  const inputNumeroLojas = 'inputNumeroLojas';
  const inputSenha = 'inputSenha';
  const inputRepetirSenha = 'inputRepetirSenha';

  const inputEstadoId = 'inputEstadoId';
  const inputShoppingId = 'inputShoppingId';
  const inputCategoriaId = 'inputCategoriaId';
  const inputSubCategoriaId = 'inputSubCategoriaId';

  const inputId = 'inputId';
  const inputCSRF = 'inputCSRF';
  const inputSituacao = 'inputSituacao';

  const inputTitulo = 'inputTitulo';
  const inputDescricao = 'inputDescricao';
  const inputPreco = 'inputPreco';
  const inputFoto1 = 'inputFoto1';
  const inputFoto2 = 'inputFoto2';
  const inputFoto3 = 'inputFoto3';
  const inputFoto4 = 'inputFoto4';
  const inputFoto5 = 'inputFoto5';
  const inputDiaValidade = 'inputDiaValidade';
  const inputMesValidade = 'inputMesValidade';

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
  const traducaoDDD = 'DDD';
  const traducaoTelefone = 'Telefone';
  const traducaoEmail = 'Email';
  const traducaoRepetirEmail = 'Repita o Email';
  const traducaoDia = 'Dia';
  const traducaoMes = 'Mês';
  const traducaoAno = 'Ano';
  const traducaoCPF = 'CPF';
  const traducaoUploadCPF = 'Suba um arquivo com o CPF';

  const traducaoNomeFantasia = 'Nome Fantasia';
  const traducaoRazaoSocial = 'Razão Social';
  const traducaoCNPJ = 'CNPJ';
  const traducaoDDDEmpresa = 'DDD';
  const traducaoTelefoneEmpresa = 'Telefone Empresa';
  const traducaoEmailEmpresa = 'Email Empresa';
  const traducaoNumeroLojas = 'Número de Lojas';
  const traducaoUploadContratoSocial = 'Suba um arquivo com o contrato social';
  const traducaoSenha = 'Senha';
  const traducaoRepetirSenha = 'Repetir Senha';

  const traducaoSituacao = 'Situação';
  const traducaoEstado = 'Estado';
  const traducaoShopping = 'Shopping';
  const traducaoCategoria = 'Categoria';
  const traducaoSubCategoria = 'Sub Categoria';
  const traducaoSelecione = 'Selecione';

  const traducaoTitulo = 'T&iacute;tulo';
  const traducaoDescricao = 'Desci&ccedil;&atilde;o';
  const traducaoPreco = 'Pre&ccedil;o';
  const traducaoFotoPrincipal = 'Foto Principal';
  const traducaoMesValidade = 'Validade do anúncio - Mês';
  const traducaoDiaValidade = 'Dia';

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