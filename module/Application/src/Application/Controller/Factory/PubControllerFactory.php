<?php

namespace Application\Controller\Factory;

use Application\Controller\PubController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Nome: PubControllerFactory.php
 * @author Leonardo Pereira Magalhães <falecomleonardopereira@gmail.com>
 * Descricao: Classe para inicializar o controle
 */
class PubControllerFactory extends KleoControllerFactory implements FactoryInterface {

  public function createService(ServiceLocatorInterface $serviceLocator) {
    $sm = $serviceLocator->getServiceLocator();
    $doctrineORMEntityManager = parent::createServiceORM($sm);

    // Serviço de Autenticação 
    try {
      $doctrineAuthenticationService = $sm->get('Zend\Authentication\AuthenticationService');
    } catch (ServiceNotCreatedException $e) {
      $doctrineAuthenticationService = null;
    } catch (ExtensionNotLoadedException $e) {
      $doctrineAuthenticationService = null;
    }

    return new PubController($doctrineORMEntityManager, $doctrineAuthenticationService);
  }

}
