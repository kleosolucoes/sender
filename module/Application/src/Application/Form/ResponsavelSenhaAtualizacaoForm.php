<?php

namespace Application\Form;

use Zend\Form\Element\Password;
use Application\Model\Entity\Responsavel;

/**
 * Nome: ResponsavelSenhaAtualizacaoForm.php
 * @author Leonardo Pereira Magalhães <falecomleonardopereira@gmail.com>
 * Descricao: Formulario de atualizacao de senha do responsavel  
 *              
 */
class ResponsavelSenhaAtualizacaoForm extends KleoForm {

  public function __construct($name = null, Responsavel $responsavel = null) {
    parent::__construct($name);

    if($responsavel){
      $inputId = $this->get(self::inputId);
      $inputId->setValue($responsavel->getId());
    }
    
    $this->add(
      (new Password())
      ->setName(self::inputSenha)
      ->setAttributes([
      self::stringClass => self::stringClassFormControl,
      self::stringId => self::inputSenha,
      self::stringRequired => self::stringRequired,
    ])
    );

    $this->add(
      (new Password())
      ->setName(self::inputRepetirSenha)
      ->setAttributes([
      self::stringClass => self::stringClassFormControl,
      self::stringId => self::inputRepetirSenha,
      self::stringRequired => self::stringRequired,
    ])
    );

  }
}