<?php

namespace Application\Model\Entity;

/**
 * Nome: ResponsavelSituacao.php
 * @author Leonardo Pereira Magalhães <falecomleonardopereira@gmail.com>
 * Descricao: Entidade anotada base para o responsavel_situacao
 */

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity 
 * @ORM\Table(name="responsavel_situacao")
 */
class ResponsavelSituacao extends KleoEntity {

    /**
     * @ORM\ManyToOne(targetEntity="Responsavel", inversedBy="responsavelSituacao")
     * @ORM\JoinColumn(name="responsavel_id", referencedColumnName="id")
     */
    private $responsavel;
    /**
     * @ORM\ManyToOne(targetEntity="Situacao", inversedBy="responsavelSituacao")
     * @ORM\JoinColumn(name="situacao_id", referencedColumnName="id")
     */
    private $situacao;
    /** @ORM\Column(type="integer") */
    protected $situacao_id;
    /** @ORM\Column(type="integer") */
    protected $responsavel_id;
      
    function getResponsavel() {
        return $this->responsavel;
    }
    function getSituacao() {
        return $this->situacao;
    }
    function getSituacao_id() {
        return $this->situacao_id;
    }
    function getResponsavel_id() {
        return $this->responsavel_id;
    }
    function setResponsavel($responsavel) {
        $this->responsavel = $responsavel;
    }
    function setSituacao($situacao) {
        $this->situacao = $situacao;
    }
    function setSituacao_id($situacao_id) {
        $this->situacao_id = $situacao_id;
    }
    function setResponsavel_id($responsavel_id) {
        $this->responsavel_id = $responsavel_id;
    }

}
