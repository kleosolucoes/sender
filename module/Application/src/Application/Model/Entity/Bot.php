<?php

namespace Application\Model\Entity;

/**
 * Nome: CampanhaLista.php
 * @author Leonardo Pereira Magalhães <falecomleonardopereira@gmail.com>
 * Descricao: Entidade anotada base para o campanha_lista
 */
use Application\Form\KleoForm;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

/**
 * @ORM\Entity 
 * @ORM\Table(name="bot")
 */
class Bot extends KleoEntity implements InputFilterAwareInterface {

    protected $inputFilter;
    protected $inputFilterCadastrarBot;

    /**
     * @ORM\OneToMany(targetEntity="BotOpcao", mappedBy="bot") 
     */
    protected $botOpcao;

    public function __construct() {
        $this->botOpcao = new ArrayCollection();
    }

    /**
     * @ORM\ManyToOne(targetEntity="Responsavel", inversedBy="bot")
     * @ORM\JoinColumn(name="responsavel_id", referencedColumnName="id")
     */
    private $responsavel;

    /** @ORM\Column(type="string") */
    protected $mensagem;

    /** @ORM\Column(type="integer") */
    protected $responsavel_id;

    function getResponsavel() {
        return $this->responsavel;
    }

    function getResponsavel_id() {
        return $this->responsavel_id;
    }

    function setResponsavel($responsavel) {
        $this->responsavel = $responsavel;
    }

    function setResponsavel_id($responsavel_id) {
        $this->responsavel_id = $responsavel_id;
    }

    function getMensagem() {
        return $this->mensagem;
    }

    function setMensagem($mensagem) {
        $this->mensagem = $mensagem;
    }

    function getBotOpcao() {
        return $this->botOpcao;
    }

    function setBotOpcao($botOpcao) {
        $this->botOpcao = $botOpcao;
    }

    public function exchangeArray($data) {
        $this->mensagem = (!empty($data[KleoForm::inputMensagem]) ? $data[KleoForm::inputMensagem] : null);
    }

    public function setInputFilter(InputFilterInterface $inputFilter) {
        throw new Exception("Nao utilizado");
    }

    public function getInputFilter() {
        
    }

    public function getInputFilterCadastrarBot() {
        if (!$this->inputFilterCadastrarBot) {

            $inputFilter = new InputFilter();

            $inputFilter->add(array(
                'name' => KleoForm::inputMensagem,
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
                            'min' => 1,
                            'max' => 200,
                        ),
                    ),
                ),
            ));

            for ($indice = 1; $indice <= 3; $indice++) {
                $inputFilter->add(array(
                    'name' => KleoForm::inputTitulo . $indice,
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
                                'min' => 1,
                                'max' => 30,
                            ),
                        ),
                    ),
                ));
                $inputFilter->add(array(
                    'name' => KleoForm::inputResposta . $indice,
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
                                'min' => 1,
                                'max' => 100,
                            ),
                        ),
                    ),
                ));
            }

            $this->inputFilterCadastrarBot = $inputFilter;
        }
        return $this->inputFilterCadastrarBot;
    }

}
