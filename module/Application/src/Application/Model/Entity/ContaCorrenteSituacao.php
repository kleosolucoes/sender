<?php

namespace Application\Model\Entity;

/**
 * Nome: ContaCorrenteSituacao.php
 * @author Leonardo Pereira Magalhães <falecomleonardopereira@gmail.com>
 * Descricao: Entidade anotada base para o conta_corrente_situacao
 */
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity 
 * @ORM\Table(name="conta_corrente_situacao")
 */
class ContaCorrenteSituacao extends KleoEntity {

    /**
     * @ORM\ManyToOne(targetEntity="ContaCorrente", inversedBy="contaCorrenteSituacao")
     * @ORM\JoinColumn(name="conta_corrente_id", referencedColumnName="id")
     */
    private $conta_corrente;

    /**
     * @ORM\ManyToOne(targetEntity="Situacao", inversedBy="contaCorrenteSituacao")
     * @ORM\JoinColumn(name="situacao_id", referencedColumnName="id")
     */
    private $situacao;

    /** @ORM\Column(type="integer") */
    protected $situacao_id;

    /** @ORM\Column(type="integer") */
    protected $conta_corrente_id;

    function getConta_corrente() {
        return $this->conta_corrente;
    }

    function getSituacao() {
        return $this->situacao;
    }

    function getSituacao_id() {
        return $this->situacao_id;
    }

    function getConta_corrente_id() {
        return $this->conta_corrente_id;
    }

    function setConta_corrente($conta_corrente) {
        $this->conta_corrente = $conta_corrente;
    }

    function setSituacao($situacao) {
        $this->situacao = $situacao;
    }

    function setSituacao_id($situacao_id) {
        $this->situacao_id = $situacao_id;
    }

    function setConta_corrente_id($conta_corrente_id) {
        $this->conta_corrente_id = $conta_corrente_id;
    }

}
