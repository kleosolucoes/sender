<?php

namespace Application\Model\Entity;

/**
 * Nome: BotOpcao.php
 * @author Leonardo Pereira Magalhães <falecomleonardopereira@gmail.com>
 * Descricao: Entidade anotada base para o bot_opcao
 */
use Application\Form\KleoForm;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

/**
 * @ORM\Entity 
 * @ORM\Table(name="bot_opcao")
 */
class BotOpcao extends KleoEntity {

    /**
     * @ORM\ManyToOne(targetEntity="Bot", inversedBy="botOpcao")
     * @ORM\JoinColumn(name="bot_id", referencedColumnName="id")
     */
    private $bot;

    /** @ORM\Column(type="string") */
    protected $titulo;

    /** @ORM\Column(type="string") */
    protected $resposta;

    /** @ORM\Column(type="integer") */
    protected $bot_id;

    function getBot() {
        return $this->bot;
    }

    function getTitulo() {
        return $this->titulo;
    }

    function getResposta() {
        return $this->resposta;
    }

    function getBot_id() {
        return $this->bot_id;
    }

    function setBot($bot) {
        $this->bot = $bot;
    }

    function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    function setResposta($resposta) {
        $this->resposta = $resposta;
    }

    function setBot_id($bot_id) {
        $this->bot_id = $bot_id;
    }

}
