<?php

namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Form\Element\Select;
use Zend\Form\Element\Text;
use Zend\Form\Element\Number;
use Zend\Form\Element\Email;
use Zend\Form\Element\Tel;
use Zend\Form\Element\File;

/**
 * Nome: Splash.php
 * @author Leonardo Pereira Magalhães <falecomleonardopereira@gmail.com>
 * Descricao: Classe helper view para montar uma tela de splash ou loader
 */
class Splash extends AbstractHelper {

  public function __construct() {

  }

  public function __invoke() {   
    return $this->renderHtml();
  }

  public function renderHtml() {
    $html = '';
    $html .= '<!-- Simple splash screen-->';
    $html .= '<div class="splash">';
    $html .= '<div class="color-line"></div>';
    $html .= '<div class="splash-title">';
    $html .= '<h1>www.tonoshop.com.br</h1>';
    $html .= '<div class="spinner">'; 
    $html .= '<div class="rect1"></div>'; 
    $html .= '<div class="rect2"></div>'; 
    $html .= '<div class="rect3"></div>'; 
    $html .= '<div class="rect4"></div>'; 
    $html .= '<div class="rect5"></div>'; 
    $html .= '</div>'; 
    $html .= '</div>';
    $html .= '</div>';
    return $html;
  }

  function getLabel() {
    return $this->label;
  }

  function setLabel($label) {
    $this->label = $label;
  }

  function getInput() {
    return $this->input;
  }

  function setInput($input) {
    $this->input = $input;
  }

  function getTamanhoGrid() {
    return $this->tamanhoGrid;
  }

  function setTamanhoGrid($tamanhoGrid) {
    $this->tamanhoGrid = $tamanhoGrid;
  }

}
