<?php

namespace Application\Model\Entity;

/**
 * Nome: Responsavel.php
 * @author Leonardo Pereira Magalhães <falecomleonardopereira@gmail.com>
 * Descricao: Entidade anotada base para o responsavel
 */

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Application\Form\KleoForm;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\Input;
use Zend\Validator;

/**
 * @ORM\Entity 
 * @ORM\Table(name="responsavel")
 */
class Responsavel extends KleoEntity implements InputFilterAwareInterface{


  protected $inputFilter;
  protected $inputFilterCadastrarResponsavel;
  protected $inputFilterAtualizarResponsavel;
  protected $inputFilterCadastrarSenhaResponsavel;
  /**
     * @ORM\OneToMany(targetEntity="ResponsavelSituacao", mappedBy="responsavel") 
     */
  protected $responsavelSituacao;
  
  /**
     * @ORM\OneToMany(targetEntity="Campanha", mappedBy="responsavel") 
     */
  protected $campanha;
  
  /**
     * @ORM\OneToMany(targetEntity="Lista", mappedBy="responsavel") 
     */
  protected $lista;

  public function __construct() {
    $this->responsavelSituacao = new ArrayCollection();
    $this->campanha = new ArrayCollection();
    $this->lista = new ArrayCollection();
  }

  /** @ORM\Column(type="string") */
  protected $nome;

  /** @ORM\Column(type="integer") */
  protected $telefone;

  /** @ORM\Column(type="string") */
  protected $email;

  /** @ORM\Column(type="string") */
  protected $nome_empresa;

  /** @ORM\Column(type="integer") */
  protected $cnpj;

  /** @ORM\Column(type="string") */
  protected $token;

  /** @ORM\Column(type="string") */
  protected $senha;

  /**
     * Retorna o responsavel situacao ativo
     * @return ResponsavelSituacao
     */
  public function getResponsavelSituacaoAtivo() {
    $responsavelSituacao = null;
    foreach ($this->getResponsavelSituacao() as $rs) {
      if ($rs->verificarSeEstaAtivo()) {
        $responsavelSituacao = $rs;
        break;
      }
    }
    return $responsavelSituacao;
  }


  function setNome($nome) {
    $this->nome = $nome;
  }

  function getNome() {
    return $this->nome;
  }

  function setTelefone($telefone) {
    $this->telefone = $telefone;
  }

  function getTelefone() {
    return $this->telefone;
  }

  function setEmail($email) {
    $this->email = $email;
  }

  function getEmail() {
    return $this->email;
  }

  function setNomeEmpresa($nomeEmpresa) {
    $this->nome_empresa = $nomeEmpresa;
  }

  function getNomeEmpresa() {
    return $this->nome_empresa;
  }
  
  function setCnpj($cnpj) {
    $this->cnpj = $cnpj;
  }

  function getCnpj() {
    return $this->cnpj;
  }

  function getResponsavelSituacao() {
    return $this->responsavelSituacao;
  }
  function setResponsavelSituacao($responsavelSituacao) {
    $this->responsavelSituacao = $responsavelSituacao;
  }

  function getToken() {
    return $this->token;
  }
  function setToken($token) {
    $this->token = $token;
  }
  
  function getCampanha() {
    return $this->campanha;
  }
  function setCampanha($campanha) {
    $this->campanha = $campanha;
  }
  
  function getLista() {
    return $this->lista;
  }
  function setLista($lista) {
    $this->lista = $lista;
  }
  
  function getSenha() {
    return $this->senha;
  }
  function setSenha($senha) {
    $this->senha = md5($senha);
  }

  public function exchangeArray($data) {
    $this->nome = (!empty($data[KleoForm::inputNome]) ? strtoupper($data[KleoForm::inputNome]) : null);
    $this->telefone = (!empty($data[KleoForm::inputTelefone]) ? $data[KleoForm::inputTelefone] : null);
    $this->email = (!empty($data[KleoForm::inputEmail]) ? strtolower($data[KleoForm::inputEmail]) : null);
    $this->nome_empresa = (!empty($data[KleoForm::inputNomeEmpresa]) ? strtoupper($data[KleoForm::inputNomeEmpresa]) : null);
    $this->cnpj = (!empty($data[KleoForm::inputCNPJ]) ? $data[KleoForm::inputCNPJ] : null);
    $this->senha = (!empty($data[KleoForm::inputSenha]) ? $data[KleoForm::inputSenha] : null);
  }

  public function getInputFilterCadastrarResponsavel($validarRepetirEmail = true) {
    if (!$this->inputFilterCadastrarResponsavel) {
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
        'min' => 3,
        'max' => 50,
      ),
      ),
      ),
      ));
      
      $inputFilter->add(array(
        'name' => KleoForm::inputTelefone,
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
        'min' => 10, 
        'max' => 11, 
      ),
      ),
      ),
      ));

      $email = new Input(KleoForm::inputEmail);
      $email->getValidatorChain()
        ->attach(new Validator\EmailAddress());
      $inputFilter->add($email);

      if($validarRepetirEmail){
      $inputFilter->add(array(
        'name' => KleoForm::inputRepetirEmail,
        'required' => true,
        'validators' => array(
        array(
        'name' => 'NotEmpty',        
      ),
        array(
        'name'    => 'Identical',        
        'options' => array(
        'token' => KleoForm::inputEmail,
        'messages' => array(
        \Zend\Validator\Identical::NOT_SAME => 'Emails são diferentes',
        \Zend\Validator\Identical::MISSING_TOKEN => 'Repita o Email'      
      ),
      ),
      ),
      ),
      ));
    }
      $this->inputFilterCadastrarResponsavel = $inputFilter;
    }
    return $this->inputFilterCadastrarResponsavel;
  }

  public function getInputFilterAtualizarResponsavel($validarRepetirEmail = true) {
    if (!$this->inputFilterAtualizarResponsavel) {
      $inputFilter = self::getInputFilterCadastrarResponsavel($validarRepetirEmail);

      $inputFilter->add(array(
        'name' => KleoForm::inputCPF,
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
        'min' => 11,
        'max' => 11,
      ),
      ),
      ),
      ));

      $inputFilter->add(array(
        'name' => KleoForm::inputUploadCPF,
        'required' => true,
        'validators' => array(
        array(
        'name' => 'NotEmpty',
      ),
      ),
      ));

      $inputFilter->add(array(
        'name' => KleoForm::inputDia,
        'required' => true,
        'validators' => array(
        array(
        'name' => 'NotEmpty',
      ),
      ),
      ));
      $inputFilter->add(array(
        'name' => KleoForm::inputMes,
        'required' => true,
        'validators' => array(
        array(
        'name' => 'NotEmpty',
      ),
      ),
      ));

      $inputFilter->add(array(
        'name' => KleoForm::inputAno,
        'required' => true,
        'validators' => array(
        array(
        'name' => 'NotEmpty',
      ),
      ),
      ));

      $inputFilter->add(array(
        'name' => KleoForm::inputUploadContratoSocial,
        'required' => true,
        'validators' => array(
        array(
        'name' => 'NotEmpty',
      ),
      ),
      ));

      $email = new Input(KleoForm::inputEmailEmpresa);
      $email->getValidatorChain()
        ->attach(new Validator\EmailAddress());
      $inputFilter->add($email);

      $inputFilter->add(array(
        'name' => KleoForm::inputRazaoSocial,
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
        'min' => 3,
        'max' => 30,
      ),
      ),
      ),
      ));

      $inputFilter->add(array(
        'name' => KleoForm::inputDDDEmpresa,
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
        'min' => 2,
        'max' => 2,
      ),
      ),
      ),
      ));
      $inputFilter->add(array(
        'name' => KleoForm::inputTelefoneEmpresa,
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
        'min' => 8, 
        'max' => 9, 
      ),
      ),
      ),
      ));

      $inputFilter->add(array(
        'name' => KleoForm::inputNumeroLojas,
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
      ),
      ),
      ),
      ));


      $this->inputFilterAtualizarResponsavel = $inputFilter;
    }
    return $this->inputFilterAtualizarResponsavel;
  }
  
  public function getInputFilterCadastrarSenhaResponsavel() {
    if (!$this->inputFilterCadastrarSenhaResponsavel) {
      $inputFilter = new InputFilter();
      
     $inputFilter->add(array(
        'name' => KleoForm::inputSenha,
        'required' => true,
        'filter' => array(
        array('name' => 'StripTags'), // removel xml e html string
        array('name' => 'StringTrim'), // removel espaco do inicio e do final da string
      ),
        'validators' => array(
        array(
        'name' => 'NotEmpty',
      ),
        array(
        'name' => 'StringLength',
        'options' => array(
        'encoding' => 'UTF-8',
        'min' => 4,
        'max' => 8, 
      ),
      ),
      ),
      ));

      $inputFilter->add(array(
        'name' => KleoForm::inputRepetirSenha,
        'required' => true,
        'validators' => array(
        array(
        'name' => 'NotEmpty',        
      ),
        array(
        'name'    => 'Identical',        
        'options' => array(
        'token' => KleoForm::inputSenha,
        'messages' => array(
        \Zend\Validator\Identical::NOT_SAME => 'Senha são diferentes',
        \Zend\Validator\Identical::MISSING_TOKEN => 'Repita a Senha'      
      ),
      ),
      ),
      ),
      ));
      
      $this->inputFilterCadastrarSenhaResponsavel = $inputFilter;
    }
    return $this->inputFilterCadastrarSenhaResponsavel;
  }

  public function setInputFilter(InputFilterInterface $inputFilter) {
    throw new Exception("Nao utilizado");
  }

  public function getInputFilter() {

  }

}
