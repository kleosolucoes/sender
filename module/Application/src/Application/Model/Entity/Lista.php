<?php

namespace Application\Model\Entity;

/**
 * Nome: Lista.php
 * @author Leonardo Pereira Magalhães <falecomleonardopereira@gmail.com>
 * Descricao: Entidade anotada base para uma lista de contatos
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
 * @ORM\Table(name="lista")
 */
class Lista extends KleoEntity implements InputFilterAwareInterface {

  protected $inputFilter;
  protected $inputFilterCadastrarLista;

  /**
     * @ORM\ManyToOne(targetEntity="Responsavel", inversedBy="lista")
     * @ORM\JoinColumn(name="responsavel_id", referencedColumnName="id")
     */
  private $responsavel;


  public function __construct() {
  
  }

  /** @ORM\Column(type="string") */
  protected $nome;

  /** @ORM\Column(type="string") */
  protected $descricao;

  /** @ORM\Column(type="integer") */
  protected $responsavel_id;

  function setNome($nome) {
    $this->nome = $nome;
  }

  function getNome() {
    return $this->nome;
  }

  function setDescricao($descricao) {
    $this->descricao = $descricao;
  }

  function getDescricao() {
    return $this->descricao;
  }

  function setResponsavel($responsavel) {
    $this->responsavel = $responsavel;
  }

  function getResponsavel() {
    return $this->responsavel;
  }

  public function exchangeArray($data) {
    $this->nome = (!empty($data[KleoForm::inputNome]) ? strtoupper($data[KleoForm::inputNome]) : null);
    $this->descricao = (!empty($data[KleoForm::inputDescricao]) ? $data[KleoForm::inputDescricao] : null);
  }

  public function setInputFilter(InputFilterInterface $inputFilter) {
    throw new Exception("Nao utilizado");
  }

  public function getInputFilter() {

  }

  public function getInputFilterCadastrarLista() {
    if (!$this->inputFilterCadastrarLista) {

      $inputFilter = new InputFilter();
      $inputFilter->add(array(
        'name' => KleoForm::inputNome,
        'required' => true,
        'filter' => array(
        array('name' => 'StripTags'), // removel xml e html string
        array('name' => 'StringTrim'), // removel espaco do inicio e do final da string
        array('name' => 'StringToUpper'), // transforma em maiusculo
      ),
        'validators' => array(
        array(
        'name' => 'NotEmpty',
      ),
        array(
        'name' => 'StringLength',
        'options' => array(
        'encoding' => 'UTF-8',
        'min' => 10,
        'max' => 80,
      ),
      ),
      ),
      ));

      $inputFilter->add(array(
        'name' => KleoForm::inputDescricao,
        'required' => true,
        'filter' => array(
        array('name' => 'StripTags'), // removel xml e html string
        array('name' => 'StringTrim'), // removel espaco do inicio e do final da string
        array('name' => 'StringToUpper'), // transforma em maiusculo
      ),
        'validators' => array(
        array(
        'name' => 'NotEmpty',
      ),
        array(
        'name' => 'StringLength',
        'options' => array(
        'encoding' => 'UTF-8',
        'min' => 10,
        'max' => 80,
      ),
      ),
      ),
      ));

      $this->inputFilterCadastrarLista = $inputFilter;
    }
    return $this->inputFilterCadastrarLista;
  }

}
