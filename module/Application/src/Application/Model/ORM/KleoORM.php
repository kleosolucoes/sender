<?php

namespace Application\Model\ORM;

use Application\Model\Entity\CircuitoEntity;
use Application\Model\Entity\EventoCelula;
use Doctrine\ORM\EntityManager;
use Exception;

/**
 * Nome: KleoORM.php
 * @author Leonardo Pereira Magalhães <falecomleonardopereira@gmail.com>
 * Descricao: Classe com acesso doctrine
 */
class KleoORM {

  private $_entityManager;
  private $_entity;

  /**
     * Construtor Sobrecarregado
     * @param EntityManager $entityManager
     * @param type $entity
     */
  public function __construct(EntityManager $entityManager = null, $entity = null) {
    if (!is_null($entityManager)) {
      $this->_entityManager = $entityManager;
    }
    if (!is_null($entity)) {
      $this->_entity = $entity;
    }
  }

  /**
     * Localizar entidade por id
     * @param integer $id
     * @return KleoEntity
     * @throws Exception
     */
  public function encontrarPorId($id) {
    $idInteiro = (int) $id;

    $entidade = $this->getEntityManager()->find($this->getEntity(), $idInteiro);
    if (!$entidade) {
      throw new Exception("Não foi encontrado a entidade de id = {$idInteiro}");
    }
    return $entidade;
  }

  /**
     * Atualiza a entidade no banco de dados
     * @param KleoEntity $entidade
     */
  public function persistir($entidade) {
    try {
      $entidade->setDataEHoraDeCriacao();
      $this->getEntityManager()->persist($entidade);
      $this->getEntityManager()->flush($entidade);
    } catch (Exception $exc) {
      echo $exc->getMessage();
    }
  }

  /**
  * Encontrar todas as entidades
  * @return KleoEntity
  */
  public function encontrarTodos() {
    return $this->getEntityManager()->getRepository($this->getEntity())->findAll();
  }

  public function getEntityManager() {
    return $this->_entityManager;
  }

  public function getEntity() {
    return $this->_entity;
  }

}
