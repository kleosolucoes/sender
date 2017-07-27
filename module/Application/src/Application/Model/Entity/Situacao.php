<?php

namespace Application\Model\Entity;

/**
 * Nome: Situacao.php
 * @author Leonardo Pereira Magalhães <falecomleonardopereira@gmail.com>
 * Descricao: Entidade anotada base para o situacao
 */
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity 
 * @ORM\Table(name="situacao")
 */
class Situacao extends KleoEntity {

    const primeiroContato = 1;
    const ativo = 2;
    const recusado = 3;
    const agendada = 4;
    const emExecucao = 5;
    const enviada = 6;

    /**
     * @ORM\OneToMany(targetEntity="ResponsavelSituacao", mappedBy="responsavelSituacao") 
     */
    protected $responsavelSituacao;

    /**
     * @ORM\OneToMany(targetEntity="CampanhaSituacao", mappedBy="campanhaSituacao") 
     */
    protected $campanhaSituacao;

    public function __construct() {
        $this->responsavelSituacao = new ArrayCollection();
        $this->campanhaSituacao = new ArrayCollection();
    }

    /** @ORM\Column(type="string") */
    protected $nome;

    function setNome($nome) {
        $this->nome = $nome;
    }

    function getNome() {
        return $this->nome;
    }

    function getResponsavelSituacao() {
        return $this->responsavelSituacao;
    }

    function setResponsavelSituacao($responsavelSituacao) {
        $this->responsavelSituacao = $responsavelSituacao;
    }

    function getCampanhaSituacao() {
        return $this->campanhaSituacao;
    }

    function setCampanhaSituacao($campanhaSituacao) {
        $this->campanhaSituacao = $campanhaSituacao;
    }

}
