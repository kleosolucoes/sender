<?php

namespace Application\Form;

use Zend\Form\Element\Text;
use Zend\Form\Element\Number;
use Zend\Form\Element\Email;

/**
 * Nome: CadastroResponsavelForm.php
 * @author Leonardo Pereira Magalhães <falecomleonardopereira@gmail.com>
 * Descricao: Formulario de cadastro de responsaveis  
 *              
 */
class CadastroResponsavelForm extends KleoForm {

  public function __construct($name = null) {
    parent::__construct($name);

    $this->add(
      (new Text())
      ->setName(self::inputNome)
      ->setAttributes([
      self::stringClass => self::stringClassFormControl,
      self::stringId => self::inputNome,
      self::stringRequired => self::stringRequired,
      self::stringOnblur => self::stringValidacoesFormulario,
    ])
    );


    $this->add(
      (new Number())
      ->setName(self::inputTelefone)
      ->setAttributes([
      self::stringClass => self::stringClassFormControl,
      self::stringId => self::inputTelefone,
      self::stringRequired => self::stringRequired,
      self::stringOnblur => self::stringValidacoesFormulario,

    ])
    );

    $this->add(
      (new Email())
      ->setName(self::inputEmail)
      ->setAttributes([
      self::stringClass => self::stringClassFormControl,
      self::stringId => self::inputEmail,
      self::stringRequired => self::stringRequired,
      self::stringOnblur => self::stringValidacoesFormulario,

    ])
    );

    $this->add(
      (new Text())
      ->setName(self::inputRepetirEmail)
      ->setAttributes([
      self::stringClass => self::stringClassFormControl,
      self::stringId => self::inputRepetirEmail,
      self::stringRequired => self::stringRequired,
      self::stringOnblur => self::stringValidacoesFormulario,

    ])
    );

  }
}