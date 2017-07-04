<?php

namespace Application\Form;

use Zend\Form\Element\Select;
use Application\Model\Entity\Situacao;

/**
 * Nome: ResponsavelSituacaoForm.php
 * @author Leonardo Pereira Magalhães <falecomleonardopereira@gmail.com>
 * Descricao: Formulario para mudar a situação  
 *              
 */
class ResponsavelSituacaoForm extends KleoForm {

  public function __construct($name = null, $idResponsavel, $todasSituacoes, $idSituacao) {
    parent::__construct($name);

    $inputId = $this->get(self::inputId);
    $inputId->setValue($idResponsavel);

    $arraySituacoes = [];
    echo '###'.$idSituacao;
    foreach($todasSituacoes as $situacao){
      $adicionar = false;
      if($situacao->getId() === $idSituacao){
        $adicionar = true;
      }
      if($situacao->getId() === ($idSituacao + 1)){
        $adicionar = true;
      }
      if($situacao->getId() === Situacao::recusado && $idSituacao === Situacao::primeiroContato){
        $adicionar = true;
      }
      if($adicionar){
        $arraySituacoes[$situacao->getId()] = $situacao->getNome();  
      }
    }
    $inputSelectSituacoes = new Select();
    $inputSelectSituacoes->setName(self::inputSituacao);
    $inputSelectSituacoes->setAttributes(array(
      self::stringClass => self::stringClassFormControl,
      self::stringId => self::inputSituacao,
      self::stringValue => $idSituacao,
    ));
    $inputSelectSituacoes->setValueOptions($arraySituacoes);
    $this->add($inputSelectSituacoes);
  }
}