<?php

namespace Application\Form;

use Zend\Form\Element\Text;
use Zend\Form\Element\Password;

/**
 * Nome: LoginForm.php
 * @author Leonardo Pereira Magalhães <falecomleonardopereira@gmail.com>
 * Descricao: Formulario de login
 *              
 */
class LoginForm extends KleoForm {

  public function __construct($name = null) {
    parent::__construct($name);

    $this->add(
      (new Text())
      ->setName(self::inputEmail)
      ->setAttributes([
      self::stringClass => self::stringClassFormControl,
      self::stringId => self::inputEmail,
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

  }
}