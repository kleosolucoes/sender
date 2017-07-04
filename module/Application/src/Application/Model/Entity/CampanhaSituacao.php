<?php

namespace Application\Model\Entity;

/**
 * Nome: CampanhaSituacao.php
 * @author Leonardo Pereira Magalhães <falecomleonardopereira@gmail.com>
 * Descricao: Entidade anotada base para o campanha_situacao
 */
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity 
 * @ORM\Table(name="campanha_situacao")
 */
class CampanhaSituacao extends KleoEntity {

    /**
     * @ORM\ManyToOne(targetEntity="Campanha", inversedBy="campanhaSituacao")
     * @ORM\JoinColumn(name="campanha_id", referencedColumnName="id")
     */
    private $campanha;

    /**
     * @ORM\ManyToOne(targetEntity="Situacao", inversedBy="campanhaSituacao")
     * @ORM\JoinColumn(name="situacao_id", referencedColumnName="id")
     */
    private $situacao;

    /** @ORM\Column(type="integer") */
    protected $situacao_id;

    /** @ORM\Column(type="integer") */
    protected $campanha_id;

    function getCampanha() {
        return $this->campanha;
    }

    function getSituacao() {
        return $this->situacao;
    }

    function getSituacao_id() {
        return $this->situacao_id;
    }

    function getCampanha_id() {
        return $this->campanha_id;
    }

    function setCampanha($campanha) {
        $this->campanha = $campanha;
    }

    function setSituacao($situacao) {
        $this->situacao = $situacao;
    }

    function setSituacao_id($situacao_id) {
        $this->situacao_id = $situacao_id;
    }

    function setCampanha_id($campanha_id) {
        $this->campanha_id = $campanha_id;
    }

}
