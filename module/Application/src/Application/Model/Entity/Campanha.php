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
 * @ORM\Table(name="campanha")
 */
class Campanha extends KleoEntity implements InputFilterAwareInterface {

  protected $inputFilter;
  protected $inputFilterCadastrarCampanha;

  /**
     * @ORM\ManyToOne(targetEntity="Responsavel", inversedBy="campanha")
     * @ORM\JoinColumn(name="responsavel_id", referencedColumnName="id")
     */
  private $responsavel;

  /**
     * @ORM\OneToMany(targetEntity="CampanhaSituacao", mappedBy="campanha") 
     */
  protected $campanhaSituacao;
  
  /**
     * @ORM\OneToMany(targetEntity="CampanhaLista", mappedBy="campanha") 
     */
  protected $campanhaLista;

  public function __construct() {
    $this->campanhaSituacao = new ArrayCollection();
    $this->campanhaLista = new ArrayCollection();
  }

  /** @ORM\Column(type="string") */
  protected $nome;

  /** @ORM\Column(type="datetime", name="data_envio") */
  protected $data_envio;

  /** @ORM\Column(type="string") */
  protected $foto_perfil;

  /** @ORM\Column(type="string") */
  protected $upload;

  /** @ORM\Column(type="string") */
  protected $mensagem;

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
  
  /**
     * Retorna a lista ativo
     * @return CampanhaLista
     */
  public function getCampanhaListaAtivo() {
    $campanhaListaAtivo = null;
    foreach ($this->getCampanhaLista() as $campanhaLista) {
      if ($campanhaLista->verificarSeEstaAtivo()) {
        $campanhaListaAtivo = $campanhaLista;
        break;
      }
    }
    return $campanhaListaAtivo;
  }

  function setNome($nome) {
    $this->nome = $nome;
  }

  function getNome() {
    return $this->nome;
  }

  function setData_envio($data_envio) {
    $this->data_envio = $data_envio;
  }

  function getData_envio() {
    return $this->data_envio;
  }

  function setFoto_perfil($foto_perfil) {
    $this->foto_perfil = $foto_perfil;
  }

  function getFoto_perfil() {
    return $this->foto_perfil;
  }

  function setUpload($upload) {
    $this->upload = $upload;
  }

  function getUpload() {
    return $this->upload;
  }

  function setMensagem($mensagem) {
    $this->mensagem = $mensagem;
  }

  function getMensagem() {
    return $this->mensagem;
  }

  function setCampanhaSituacao($campanhaSituacao) {
    $this->campanhaSituacao = $campanhaSituacao;
  }

  function getCampanhaSituacao() {
    return $this->campanhaSituacao;
  }

  function setCampanhaLista($campanhaLista) {
    $this->campanhaLista = $campanhaLista;
  }

  function getCampanhaLista() {
    return $this->campanhaLista;
  }

  function setResponsavel($responsavel) {
    $this->responsavel = $responsavel;
  }

  function getResponsavel() {
    return $this->responsavel;
  }

  public function exchangeArray($data) {
    $this->nome = (!empty($data[KleoForm::inputNome]) ? strtoupper($data[KleoForm::inputNome]) : null);
    if(!empty($data[KleoForm::inputDataEnvio])){
      $this->data_envio = DateTime::createFromFormat('d/m/Y', $data[KleoForm::inputDataEnvio]);  
    }    
    $this->foto_perfil = (!empty($data[KleoForm::inputFotoPerfil]) ? $data[KleoForm::inputFotoPerfil] : null);
    $this->upload = (!empty($data[KleoForm::inputUpload]) ? $data[KleoForm::inputUpload] : null);
    $this->mensagem = (!empty($data[KleoForm::inputMensagem]) ? $data[KleoForm::inputMensagem] : null);
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
        'max' => 60,
      ),
      ),
      ),
      ));

      $inputFilter->add(array(
        'name' => KleoForm::inputDataEnvio,
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
      
      $this->inputFilterCadastrarCampanha = $inputFilter;
    }
    return $this->inputFilterCadastrarCampanha;
  }

}
