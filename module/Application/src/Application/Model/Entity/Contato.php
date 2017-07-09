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
class Contato extends KleoEntity implements InputFilterAwareInterface {

  protected $inputFilter;
  protected $inputFilterCadastrarCampanha;

  /**
     * @ORM\ManyToOne(targetEntity="Responsavel", inversedBy="campanha")
     * @ORM\JoinColumn(name="responsavel_id", referencedColumnName="id")
     */
  private $responsavel;


  public function __construct() {
  
  }

  /** @ORM\Column(type="string") */
  protected $nome;

  /** @ORM\Column(type="string") */
  protected $descricao;

  /** @ORM\Column(type="string") */
  protected $foto;

  /** @ORM\Column(type="integer") */
  protected $responsavel_id;

  /**
     * Retorna a situacao ativo
     * @return CampanhaSituacao
     */
  public function getCampanhaSituacaoAtivo() {
    $campanhaSituacao = null;
    foreach ($this->getCampanhaSituacao() as $as) {
      if ($as->verificarSeEstaAtivo()) {
        $campanhaSituacao = $as;
        break;
      }
    }
    return $campanhaSituacao;
  }

  function setTitulo($titulo) {
    $this->titulo = $titulo;
  }

  function getTitulo() {
    return $this->titulo;
  }

  function setDescricao($descricao) {
    $this->descricao = $descricao;
  }

  function getDescricao() {
    return $this->descricao;
  }

  function setFoto($foto) {
    $this->foto = $foto;
  }

  function getFoto() {
    return $this->foto;
  }

  function setCampanhaSituacao($campanhaSituacao) {
    $this->campanhaSituacao = $campanhaSituacao;
  }

  function getCampanhaSituacao() {
    return $this->campanhaSituacao;
  }

  function setResponsavel($responsavel) {
    $this->responsavel = $responsavel;
  }

  function getResponsavel() {
    return $this->responsavel;
  }

  public function exchangeArray($data) {
    $this->titulo = (!empty($data[KleoForm::inputTitulo]) ? strtoupper($data[KleoForm::inputTitulo]) : null);
    $this->descricao = (!empty($data[KleoForm::inputDescricao]) ? $data[KleoForm::inputDescricao] : null);
    $this->foto = (!empty($data[KleoForm::inputFoto]) ? $data[KleoForm::inputFoto] : null);
  }

  public function setInputFilter(InputFilterInterface $inputFilter) {
    throw new Exception("Nao utilizado");
  }

  public function getInputFilter() {

  }

  public function getInputFilterCadastrarCampanha() {
    if (!$this->inputFilterCadastrarCampanha) {

      $inputFilter = new InputFilter();
      $inputFilter->add(array(
        'name' => KleoForm::inputTitulo,
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
        'max' => 60,
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
        'max' => 100,
      ),
      ),
      ),
      ));

      $this->inputFilterCadastrarCampanha = $inputFilter;
    }
    return $this->inputFilterCadastrarCampanha;
  }

}
