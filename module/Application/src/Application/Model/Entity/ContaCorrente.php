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
  protected $inputFilterCadastrarContaCorrente;

  /**
     * @ORM\ManyToOne(targetEntity="Responsavel", inversedBy="contaCorrente")
     * @ORM\JoinColumn(name="responsavel_id", referencedColumnName="id")
     */
  private $responsavel;

  /**
     * @ORM\OneToMany(targetEntity="ContaCorrenteSituacao", mappedBy="contaCorrente") 
     */
  protected $contaCorrenteSituacao;

  public function __construct() {
    $this->contaCorrenteSituacao = new ArrayCollection();
  }

  /** @ORM\Column(type="integer") */
  protected $valor;

  /** @ORM\Column(type="integer") */
  protected $responsavel_id;

  /**
     * Retorna a situacao ativo
     * @return ContaCorrenteSituacao
     */
  public function getContaCorrenteSituacaoAtivo() {
    $contaCorrenteSituacao = null;
    foreach ($this->getContaCorrenteSituacao() as $contaCorrenteSitucao) {
      if ($contaCorrenteSitucao->verificarSeEstaAtivo()) {
        $contaCorrenteSituacao = $contaCorrenteSitucao;
        break;
      }
    }
    return $contaCorrenteSituacao;
  }

  function setContaCorrenteSituacao($contaCorrenteSitucao) {
    $this->contaCorrenteSitucao = $contaCorrenteSitucao;
  }

  function getContaCorrenteSituacao() {
    return $this->contaCorrenteSitucao;
  }

  function setResponsavel($responsavel) {
    $this->responsavel = $responsavel;
  }

  function getResponsavel() {
    return $this->responsavel;
  }

  public function exchangeArray($data) {
    $this->valor = (!empty($data[KleoForm::inputValor]) ? strtoupper($data[KleoForm::inputValor]) : null);
  }

  public function setInputFilter(InputFilterInterface $inputFilter) {
    throw new Exception("Nao utilizado");
  }

  public function getInputFilter() {

  }

  public function getInputFilterCadastrarContaCorrente() {
    if (!$this->inputFilterCadastrarContaCorrente) {

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
        'max' => 1000000000,
      ),
      ),
      ),
      ));

      $this->inputFilterCadastrarContaCorrente = $inputFilter;
    }
    return $this->inputFilterCadastrarContaCorrente;
  }

}
