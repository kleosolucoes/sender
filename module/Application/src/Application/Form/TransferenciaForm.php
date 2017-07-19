<?php

namespace Application\Form;

use Zend\Form\Element\Number;
use Zend\Form\Element\Select;
use Zend\Form\Element\Text;
use Application\Model\Entity\Responsavel;

/**
 * Nome: TransferenciaForm.php
 * @author Leonardo Pereira Magalhães <falecomleonardopereira@gmail.com>
 * Descricao: Formulario de transferencia fr credito
 *              
 */
class TransferenciaForm extends KleoForm {

  public function __construct($name = null, Responsavel $responsavel) {
    parent::__construct($name);

    if($responsavel){
      $inputId = $this->get(self::inputId);
      $inputId->setValue($responsavel->getId());
    }
    
    $this->add(
      (new Number())
      ->setName(self::inputValor)
      ->setAttributes([
      self::stringClass => self::stringClassFormControl,
      self::stringId => self::inputValor,
      self::stringRequired => self::stringRequired,
      self::stringOnblur => self::stringValidacoesFormulario,
    ])
    );

    $this->add(
      (new Text())
      ->setName(self::inputPreco)
      ->setAttributes([
      self::stringClass => self::stringClassFormControl,
      self::stringId => self::inputPreco,
      self::stringRequired => self::stringRequired,
      self::stringOnblur => self::stringValidacoesFormulario,
    ])
    );

    $inputCredito = new Select();
    $inputCredito->setName(self::inputCredito);
    $inputCredito->setAttributes(array(
      self::stringClass => self::stringClassFormControl,
      self::stringId => self::inputCredito,
      self::stringRequired => self::stringRequired,
    ));
    $inputCredito->setEmptyOption(self::traducaoSelecione);
    $arrayCredito = [];
    $arrayCredito['S'] = 'Crédito';      
    $arrayCredito['N'] = 'Débito';      
    $inputCredito->setValueOptions($arrayCredito);
    $this->add($inputCredito);

  }
}