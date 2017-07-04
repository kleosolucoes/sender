<?php

namespace Application\Model\Entity;

/**
 * Nome: Pais.php
 * @author Leonardo Pereira Magalhães <falecomleonardopereira@gmail.com>
 * Descricao: Entidade anotada base para o pais
 */
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity 
 * @ORM\Table(name="pais")
 */
class Pais extends KleoEntity {

    /** @ORM\Column(type="string") */
    protected $nome;

    function setNome($nome) {
        $this->nome = $nome;
    }

    function getNome() {
        return $this->nome;
    }

}
