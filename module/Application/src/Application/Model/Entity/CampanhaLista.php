<?php

namespace Application\Model\Entity;

/**
 * Nome: CampanhaLista.php
 * @author Leonardo Pereira Magalhães <falecomleonardopereira@gmail.com>
 * Descricao: Entidade anotada base para o campanha_lista
 */
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity 
 * @ORM\Table(name="campanha_lista")
 */
class CampanhaLista extends KleoEntity {

    /**
     * @ORM\ManyToOne(targetEntity="Campanha", inversedBy="campanhaLista")
     * @ORM\JoinColumn(name="campanha_id", referencedColumnName="id")
     */
    private $campanha;

    /**
     * @ORM\ManyToOne(targetEntity="Lista", inversedBy="campanhaLista")
     * @ORM\JoinColumn(name="lista_id", referencedColumnName="id")
     */
    private $lista;

    /** @ORM\Column(type="integer") */
    protected $lista_id;

    /** @ORM\Column(type="integer") */
    protected $campanha_id;

    function getCampanha() {
        return $this->campanha;
    }

    function getLista() {
        return $this->lista;
    }

    function getLista_id() {
        return $this->lista_id;
    }

    function getCampanha_id() {
        return $this->campanha_id;
    }

    function setCampanha($campanha) {
        $this->campanha = $campanha;
    }

    function setLista($lista) {
        $this->lista = $lista;
    }

    function setSituacao_id($situacao_id) {
        $this->situacao_id = $situacao_id;
    }

    function setLista_id($lista_id) {
        $this->lista_id = $lista_id;
    }

}
