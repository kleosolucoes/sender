<?php

namespace Application\Model\ORM;

use Doctrine\ORM\EntityManager;

/**
 * Nome: RepositorioORM.php
 * @author Leonardo Pereira Magalhães <falecomleonardopereira@gmail.com>
 * Descricao: Classe com acesso ao repositorio ORM
 */
class RepositorioORM {

  private $_doctrineORMEntityManager;
  private $_responsavelORM;
  private $_situacaoORM;
  private $_paisORM;
  private $_responsavelSituacaoORM;
  private $_campanhaORM;
  private $_campanhaSituacaoORM;

  /**
     * Contrutor
     */
  public function __construct(EntityManager $doctrineORMEntityManager = null) {
    if (!is_null($doctrineORMEntityManager)) {
      $this->_doctrineORMEntityManager = $doctrineORMEntityManager;
    }
  }

  /**
     * Metodo public para obter a instancia do ResponsavelORM
     * @return ResponsavelORM
     */
  public function getResponsavelORM() {
    if (is_null($this->_responsavelORM)) {
      $this->_responsavelORM = new ResponsavelORM($this->getDoctrineORMEntityManager(), 'Application\Model\Entity\Responsavel');
    }
    return $this->_responsavelORM;
  }

  /**
     * Metodo public para obter a instancia do KleoORM
     * @return KleoORM
     */
  public function getSituacaoORM() {
    if (is_null($this->_situacaoORM)) {
      $this->_situacaoORM = new KleoORM($this->getDoctrineORMEntityManager(), 'Application\Model\Entity\Situacao');
    }
    return $this->_situacaoORM;
  }

  /**
     * Metodo public para obter a instancia do KleoORM
     * @return KleoORM
     */
  public function getPaisORM() {
    if (is_null($this->_paisORM)) {
      $this->_paisORM = new KleoORM($this->getDoctrineORMEntityManager(), 'Application\Model\Entity\Pais');
    }
    return $this->_paisORM;
  }

  /**
     * Metodo public para obter a instancia do ResponsavelSituacaoORM
     * @return KleoORM
     */
  public function getResponsavelSituacaoORM() {
    if (is_null($this->_responsavelSituacaoORM)) {
      $this->_responsavelSituacaoORM = new KleoORM($this->getDoctrineORMEntityManager(), 'Application\Model\Entity\ResponsavelSituacao');
    }
    return $this->_responsavelSituacaoORM;
  }

  /**
     * Metodo public para obter a instancia do KleoORM
     * @return KleoORM
     */
  public function getCampanhaORM() {
    if (is_null($this->_campanhaORM)) {
      $this->_campanhaORM = new CampanhaORM($this->getDoctrineORMEntityManager(), 'Application\Model\Entity\Campanha');
    }
    return $this->_campanhaORM;
  }

  /**
     * Metodo public para obter a instancia do KleoORM
     * @return KleoORM
     */
  public function getCampanhaSituacaoORM() {
    if (is_null($this->_campanhaSituacaoORM)) {
      $this->_campanhaSituacaoORM = new KleoORM($this->getDoctrineORMEntityManager(), 'Application\Model\Entity\CampanhaSituacao');
    }
    return $this->_campanhaSituacaoORM;
  }

  /**
     * Metodo public para obter a instancia EntityManager com acesso ao banco de dados
     * @return EntityManager
     */
  public function getDoctrineORMEntityManager() {
    return $this->_doctrineORMEntityManager;
  }

  /**
     * Iniciar transação
     */
  public function iniciarTransacao() {
    try {
      $this->getDoctrineORMEntityManager()->beginTransaction();
    } catch (Exception $exc) {
      echo $exc->getMessage();
    }
  }

  /**
     * Fechar transação
     */
  public function fecharTransacao() {
    try {
      $this->getDoctrineORMEntityManager()->commit();
    } catch (Exception $exc) {
      echo $exc->getMessage();
    }
  }

  /**
     * Desfazer transação
     */
  public function desfazerTransacao() {
    try {
      $this->getDoctrineORMEntityManager()->rollback();
    } catch (Exception $exc) {
      echo $exc->getMessage();
    }
  }

}
