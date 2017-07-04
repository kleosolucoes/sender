<?php

namespace Application\Model\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Nome: KleoEntity.php
 * @author Leonardo Pereira Magalhães <falecomleonardopereira@gmail.com>
 * Descricao: Entidade anotada base
 */

class KleoEntity {

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;
    /** @ORM\Column(type="datetime", name="data_criacao") */
    protected $data_criacao;
    /** @ORM\Column(type="string") */
    protected $hora_criacao;
    /** @ORM\Column(type="datetime", name="data_inativacao") */
    protected $data_inativacao;
    /** @ORM\Column(type="string") */
    protected $hora_inativacao;
    /**
     * Seta data e hora de criação
     */
    function setDataEHoraDeCriacao() {
        $timeNow = new DateTime();
        $this->setData_criacao($timeNow);
        $this->setHora_criacao($timeNow->format('H:s:i'));
    }
    /**
     * Verificar se a data de inativação está nula
     * @return boolean
     */
    public function verificarSeEstaAtivo() {
        $resposta = false;
        if (is_null($this->getData_inativacao())) {
            $resposta = true;
        }
        return $resposta;
    }
  
   /**
     * Seta data e hora de inativação
     */
    function setDataEHoraDeInativacao() {
        $timeNow = new DateTime();
        $this->setData_inativacao($timeNow);
        $this->setHora_inativacao($timeNow->format('H:s:i'));
    }
  
   /**
     * Gera um token com data e hora atual em md5
     * @return String
     */
    function gerarToken() {
        $timeNow = new DateTime();
        $data = $timeNow->format('Ymd');
        $hora = $timeNow->format('His');
        $token = md5($dataEnvio . $hora);
        return $token;
    }
  
    function getId() {
        return $this->id;
    }
    function getData_criacao() {
        return $this->data_criacao;
    }
    function getData_criacaoFormatada() {
        return $this->data_criacao->format('d/m/Y');
    }
    function getHora_criacao() {
        return $this->hora_criacao;
    }
    function getData_inativacao() {
        return $this->data_inativacao;
    }
    function getHora_inativacao() {
        return $this->hora_inativacao;
    }
    function setId($id) {
        $this->id = $id;
    }
    function setData_criacao($data_criacao) {
        $this->data_criacao = $data_criacao;
    }
    function setHora_criacao($hora_criacao) {
        $this->hora_criacao = $hora_criacao;
    }
    function setData_inativacao($data_inativacao) {
        $this->data_inativacao = $data_inativacao;
    }
    function setHora_inativacao($hora_inativacao) {
        $this->hora_inativacao = $hora_inativacao;
    }
}
