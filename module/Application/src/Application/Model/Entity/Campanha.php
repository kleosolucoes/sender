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
     * @ORM\OneToMany(targetEntity="CampanhaCategoria", mappedBy="campanha") 
     */
    protected $campanhaCategoria;

    /**
     * @ORM\OneToMany(targetEntity="CampanhaLoja", mappedBy="campanha") 
     */
    protected $campanhaLoja;

    /**
     * @ORM\OneToMany(targetEntity="CampanhaSituacao", mappedBy="campanha") 
     */
    protected $campanhaSituacao;

    public function __construct() {
        $this->campanhaCategoria = new ArrayCollection();
        $this->campanhaLoja = new ArrayCollection();
        $this->campanhaSituacao = new ArrayCollection();
    }

    /** @ORM\Column(type="string") */
    protected $titulo;

    /** @ORM\Column(type="string") */
    protected $descricao;

    /** @ORM\Column(type="decimal") */
    protected $preco;

    /** @ORM\Column(type="string") */
    protected $foto1;

    /** @ORM\Column(type="string") */
    protected $foto2;

    /** @ORM\Column(type="string") */
    protected $foto3;

    /** @ORM\Column(type="string") */
    protected $foto4;

    /** @ORM\Column(type="string") */
    protected $foto5;

    /** @ORM\Column(type="datetime", name="validade") */
    protected $validade;

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

    function setPreco($preco) {
        $this->preco = $preco;
    }

    function getPreco() {
        return $this->preco;
    }

    function setFoto1($foto) {
        $this->foto1 = $foto;
    }

    function getFoto1() {
        return $this->foto1;
    }

    function setFoto2($foto) {
        $this->foto2 = $foto;
    }

    function getFoto2() {
        return $this->foto2;
    }

    function setFoto3($foto) {
        $this->foto3 = $foto;
    }

    function getFoto3() {
        return $this->foto3;
    }

    function setFoto4($foto) {
        $this->foto4 = $foto;
    }

    function getFoto4() {
        return $this->foto4;
    }

    function setFoto5($foto) {
        $this->foto5 = $foto;
    }

    function getFoto5() {
        return $this->foto5;
    }

    function setValidade($validade) {
        echo 'data' . $validade;
        $date = DateTime::createFromFormat('Y-m-d', $validade);
        $this->validade = $date;
    }

    function getValidade() {
        return $this->validade;
    }

    function setCampanhaSituacao($campanhaSituacao) {
        $this->campanhaSituacao = $campanhaSituacao;
    }

    function getCampanhaSituacao() {
        return $this->campanhaSituacao;
    }

    function setCampanhaCategoria($campanhaCategoria) {
        $this->campanhaCategoria = $campanhaCategoria;
    }

    function getCampanhaCategoria() {
        return $this->campanhaCategoria;
    }

    function setCampanhaLoja($campanhaLoja) {
        $this->campanhaLoja = $campanhaLoja;
    }

    function getCampanhaLoja() {
        return $this->campanhaLoja;
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
        $this->preco = (!empty($data[KleoForm::inputPreco]) ? $data[KleoForm::inputPreco] : null);
        $this->foto1 = (!empty($data[KleoForm::inputFoto1]) ? $data[KleoForm::inputFoto1] : null);
        $this->foto2 = (!empty($data[KleoForm::inputFoto2]) ? $data[KleoForm::inputFoto2] : null);
        $this->foto3 = (!empty($data[KleoForm::inputFoto3]) ? $data[KleoForm::inputFoto3] : null);
        $this->foto4 = (!empty($data[KleoForm::inputFoto4]) ? $data[KleoForm::inputFoto4] : null);
        $this->foto5 = (!empty($data[KleoForm::inputFoto5]) ? $data[KleoForm::inputFoto5] : null);
        $this->setValidade((!empty($data[KleoForm::inputMesValidade] && !empty($data[KleoForm::inputDiaValidade])) ?
                        date('Y') . '-' . $data[KleoForm::inputMesValidade] . '-' . $data[KleoForm::inputMesValidade] : null));
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

            $preco = new Input(KleoForm::inputPreco);
            //       $filter = new \Zend\I18n\Filter\NumberFormat("de_DE");
            //       $preco->getValidatorChain()
            //         ->attach(new NumberFormat("pt_BR", NumberFormatter::TYPE_DOUBLE));
            $inputFilter->add($preco);

            $this->inputFilterCadastrarCampanha = $inputFilter;
        }
        return $this->inputFilterCadastrarCampanha;
    }

}
