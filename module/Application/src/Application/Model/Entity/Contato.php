<?php

namespace Application\Model\Entity;

/**
 * Nome: Campanha.php
 * @author Leonardo Pereira Magalhães <falecomleonardopereira@gmail.com>
 * Descricao: Entidade anotada base para o campanha
 */
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Application\Form\KleoForm;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\Input;
use Zend\Validator;
use DateTime;

/**
 * @ORM\Entity 
 * @ORM\Table(name="contato")
 */
class Contato extends KleoEntity {

  /**
     * @ORM\ManyToOne(targetEntity="Lista", inversedBy="contato")
     * @ORM\JoinColumn(name="lista_id", referencedColumnName="id")
     */
  private $lista;


  public function __construct() {
  
  }

  /** @ORM\Column(type="integer") */
  protected $numero;
  
  /** @ORM\Column(type="string") */
  protected $whatsapp;

  /** @ORM\Column(type="integer") */
  protected $lista_id;

  function temWhatsapp() {
    $resposta = false;
    if($this->getWhatsapp() == 'S'){
      $resposta = true;
    }
    return $resposta;
  }
  
  function setNumero($numero) {
    $this->numero = $numero;
  }

  function getNumero() {
    return $this->numero;
  }
  
  function setWhatsapp($whatsapp) {
    $this->whatsapp = $whatsapp;
  }

  function getWhatsapp() {
    return $this->whatsapp;
  }

  function setLista($lista) {
    $this->lista = $lista;
  }

  function geLista() {
    return $this->lista;
  }

}
