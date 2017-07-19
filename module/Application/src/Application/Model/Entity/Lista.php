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

  /**
     * @ORM\OneToMany(targetEntity="Contato", mappedBy="lista") 
     */
  protected $contato;

  /**
     * @ORM\OneToMany(targetEntity="CampanhaLista", mappedBy="campanha") 
     */
  protected $campanhaLista;

  public function __construct() {
    $this->contato = new ArrayCollection();
    $this->campanhaLista = new ArrayCollection();
  }

  /** @ORM\Column(type="string") */
  protected $nome;

  /** @ORM\Column(type="string") */
  protected $descricao;

  /** @ORM\Column(type="string") */
  protected $upload;

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

  function setUpload($upload) {
    $this->upload = $upload;
  }

  function getUpload() {
    return $this->upload;
  }

  function setResponsavel($responsavel) {
    $this->responsavel = $responsavel;
  }

  function getResponsavel() {
    return $this->responsavel;
  }  

  function setContato($contato) {
    $this->contato = $contato;
  }

  function getContato() {
    return $this->contato;
  }
  
  function getContatoAtivos() {
    $contatosAtivos = null;
    $contatos = $this->getContato();
    if($contatos){
      foreach($contatos as $contato){
        if($contato->verificarSeEstaAtivo()){
          $contatosAtivos[] = $contato;  
        }        
      }
    }
    return $contatosAtivos;
  }

  function setCampanhaLista($campanhaLista) {
    $this->campanhaLista = $campanhaLista;
  }

  function getCampanhaLista() {
    return $this->campanhaLista;
  }

  function getContatoComZap() {
    $contatosComZap = array();
    foreach($this->getContato() as $contato){
      if($contato->temWhatsapp()){
        $contatosComZap[] = $contato;
      }
    } 
    return $contatosComZap;
  }

  public function exchangeArray($data) {
    $this->nome = (!empty($data[KleoForm::inputNome]) ? strtoupper($data[KleoForm::inputNome]) : null);
    $this->descricao = (!empty($data[KleoForm::inputDescricao]) ? strtoupper($data[KleoForm::inputDescricao]) : null);
    $this->upload = (!empty($data[KleoForm::inputUpload]) ? $data[KleoForm::inputUpload] : null);
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
        'min' => 1,
        'max' => 80,
      ),
      ),
      ),
      ));

      $inputFilter->add(array(
        'name' => KleoForm::inputUpload,
        'required' => true,
        'filter' => array(
        array('name' => 'StripTags'), // removel xml e html string
        array('name' => 'StringTrim'), // removel espaco do inicio e do final da string
      ),
        'validators' => array(
        array(
        'name' => 'NotEmpty',
      ),
      ),               
      ));

      $this->inputFilterCadastrarLista = $inputFilter;
    }
    return $this->inputFilterCadastrarLista;
  }

}
