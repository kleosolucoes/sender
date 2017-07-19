<?php

namespace Application\Model\Entity;

/**
 * Nome: ContaCorrente.php
 * @author Leonardo Pereira Magalhães <falecomleonardopereira@gmail.com>
 * Descricao: Entidade anotada base para o conta corrente
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
 * @ORM\Table(name="conta_corrente")
 */
class ContaCorrente extends KleoEntity implements InputFilterAwareInterface {

  protected $inputFilter;
  protected $inputFilterTransferencia;
  /**
     * @ORM\ManyToOne(targetEntity="Responsavel", inversedBy="contaCorrente")
     * @ORM\JoinColumn(name="responsavel_id", referencedColumnName="id")
     */
  private $responsavel;

  /** @ORM\Column(type="integer") */
  protected $valor;

  /** @ORM\Column(type="float") */
  protected $preco;

  /** @ORM\Column(type="string") */
  protected $credito;

  /** @ORM\Column(type="integer") */
  protected $responsavel_id;

  function setValor($valor) {
    $this->valor = $valor;
  }

  function getValor() {
    return $this->valor;
  }

  function setPreco($preco) {
    $this->preco = $preco;
  }

  function getPreco() {
    return $this->preco;
  }

  function setCredito($credito) {
    $this->credito = $credito;
  }

  function getCredito() {
    return $this->credito;
  }

  function setResponsavel($responsavel) {
    $this->responsavel = $responsavel;
  }

  function getResponsavel() {
    return $this->responsavel;
  }

  public function exchangeArray($data) {
    $this->valor = (!empty($data[KleoForm::inputValor]) ? $data[KleoForm::inputValor] : null);
    $this->preco = (!empty($data[KleoForm::inputPreco]) ? $data[KleoForm::inputPreco] : null);
    $this->credito = (!empty($data[KleoForm::inputCredito]) ? $data[KleoForm::inputCredito] : null);
  }


  public function getInputFilterTransferencia() {
    if (!$this->inputFilterTransferencia) {
      $inputFilter = new InputFilter();
      $inputFilter->add(array(
        'name' => KleoForm::inputValor,
        'required' => true,
        'filter' => array(
        array('name' => 'StripTags'), // removel xml e html string
        array('name' => 'StringTrim'), // removel espaco do inicio e do final da string
        array('name' => 'Int'), // transforma string para inteiro
      ),
        'validators' => array(
        array(
        'name' => 'NotEmpty',
      ),
        array(
        'name' => 'StringLength',
        'options' => array(
        'encoding' => 'UTF-8',
        'min' => 1,
        'max' => 1000000,
      ),
      ),
      ),
      ));

      $inputFilter->add(array(
        'name' => KleoForm::inputPreco,
        'required' => true,
        'filter' => array(
        array('name' => 'StripTags'), // removel xml e html string
        array('name' => 'StringTrim'), // removel espaco do inicio e do final da string  
        array('name' => 'Float'),  
      ),
        'validators' => array(
        array(
        'name' => 'NotEmpty',
      ),
      ),
      )); 

      $inputFilter->add(array(
        'name' => KleoForm::inputCredito,
        'required' => true,
        'validators' => array(
        array(
        'name' => 'NotEmpty',
      ),
      ),
      ));     


      $this->inputFilterTransferencia = $inputFilter;
    }
    return $this->inputFilterTransferencia;
  }

  public function setInputFilter(InputFilterInterface $inputFilter) {
    throw new Exception("Nao utilizado");
  }

  public function getInputFilter() {

  }

}
