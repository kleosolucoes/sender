<?php

namespace Application\Form;

use Zend\Form\Element\Password;
use Application\Model\Entity\Responsavel;
use Zend\Form\Element\Text;
use Zend\Form\Element\Number;
use Zend\Form\Element\Email;
use Zend\Form\Element\Select;
use Zend\Form\Element\Checkbox;

/**
 * Nome: ResponsavelSenhaAtualizacaoForm.php
 * @author Leonardo Pereira Magalhães <falecomleonardopereira@gmail.com>
 * Descricao: Formulario de atualizacao de senha do responsavel  
 *              
 */
class ResponsavelSenhaAtualizacaoForm extends CadastroResponsavelForm {

  public function __construct($name = null, Responsavel $responsavel = null) {
    parent::__construct($name);

    if($responsavel){
      $inputId = $this->get(self::inputId);
      $inputId->setValue($responsavel->getId());

      $inputNome = $this->get(self::inputNome);
      $inputNome->setValue($responsavel->getNome());

      $inputTelefone = $this->get(self::inputTelefone);
      $inputTelefone->setValue($responsavel->getTelefone());

      $inputEmail = $this->get(self::inputEmail);
      $inputEmail->setValue($responsavel->getEmail());
    }

    $this->add(
      (new Email())
      ->setName(self::inputRepetirEmail)
      ->setAttributes([
      self::stringClass => self::stringClassFormControl,
      self::stringId => self::inputRepetirEmail,
      self::stringRequired => self::stringRequired,
      self::stringOnblur => self::stringValidacoesFormulario,
    ])
    );

    $this->add(
      (new Text())
      ->setName(self::inputUltimoNome)
      ->setAttributes([
      self::stringClass => self::stringClassFormControl,
      self::stringId => self::inputUltimoNome,
      self::stringRequired => self::stringRequired,
      self::stringOnblur => self::stringValidacoesFormulario,

    ])
    );

    /* Dia da data de nascimento */
    $arrayPaises = array();   
    $arrayPaises[1] = self::traducaoBrasil;

    $inputSelectPaises = new Select();
    $inputSelectPaises->setName(self::inputPais);
    $inputSelectPaises->setAttributes(array(
      self::stringClass => self::stringClassFormControl,
      self::stringId => self::inputPais,
      self::stringRequired => self::stringRequired,
      self::stringOnblur => self::stringValidacoesFormulario,


    ));
    $inputSelectPaises->setValueOptions($arrayPaises);
    //$inputSelectPaises->setEmptyOption(self::traducaoSelecioneOPais);
    $this->add($inputSelectPaises);

    $this->add(
      (new Text())
      ->setName(self::inputNomeEmpresa)
      ->setAttributes([
      self::stringClass => self::stringClassFormControl,
      self::stringId => self::inputNomeEmpresa,
      self::stringRequired => self::stringRequired,
      self::stringOnblur => self::stringValidacoesFormulario,

    ])
    );

    $this->add(
      (new Number())
      ->setName(self::inputCNPJ)
      ->setAttributes([
      self::stringClass => self::stringClassFormControl,
      self::stringId => self::inputCNPJ,
      self::stringRequired => self::stringRequired,
      self::stringOnblur => self::stringValidacoesFormulario,

    ])
    ); 

    $this->add(
      (new Password())
      ->setName(self::inputSenha)
      ->setAttributes([
      self::stringClass => self::stringClassFormControl,
      self::stringId => self::inputSenha,
      self::stringRequired => self::stringRequired,
      self::stringOnblur => self::stringValidacoesFormulario,
    ])
    );

    $this->add(
      (new Password())
      ->setName(self::inputRepetirSenha)
      ->setAttributes([
      self::stringClass => self::stringClassFormControl,
      self::stringId => self::inputRepetirSenha,
      self::stringRequired => self::stringRequired,
      self::stringOnblur => self::stringValidacoesFormulario,
    ])
    );

    $this->add(
      (new Checkbox())
      ->setName(self::inputTermo)
      ->setAttributes([
      self::stringId => self::inputTermo,
    ])
      ->setCheckedValue(1)
      ->setUncheckedValue('no')
      ->setUseHiddenElement(true)
    );

  }
}