<?php

namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Form\Element\Select;
use Zend\Form\Element\Text;
use Zend\Form\Element\Textarea;
use Zend\Form\Element\Number;
use Zend\Form\Element\Email;
use Zend\Form\Element\File;
use Zend\Form\Element\Password;
use Zend\Form\Element\Checkbox;
use Zend\Form\Element\Date;

/**
 * Nome: InputFormulario.php
 * @author Leonardo Pereira Magalhães <falecomleonardopereira@gmail.com>
 * Descricao: Classe helper view para input dos formulários
 */
class InputFormulario extends AbstractHelper {

  private $label;
  private $tamanhoGrid;
  private $input;

  public function __construct() {

  }

  public function __invoke($label, $input, $tamanhoGrid = null) {
    $this->setLabel($label);
    $this->setTamanhoGrid($tamanhoGrid);
    $this->setInput($input);
    return $this->renderHtml();
  }

  public function renderHtml() {
    $html = '';
    $tamanhoGrid = 12;
    if ($this->getTamanhoGrid()) {
      $tamanhoGrid = $this->getTamanhoGrid();
    }
    $html .= '<div class="form-group col-lg-' . $tamanhoGrid . ' col-md-' . $tamanhoGrid . '">';
    $html .= '<label id="label'.$this->getInput()->getName().'" for="'.$this->getInput()->getName().'">' . $this->getLabel() . '</label>';
    if ($this->getInput() instanceOf Text
        || $this->getInput() instanceOf Tel
        || $this->getInput() instanceOf Number
        || $this->getInput() instanceOf Email) {
      $html .= $this->view->formInput($this->getInput());
    }
    if ($this->getInput() instanceOf Select) {
      $html .= $this->view->formSelect($this->getInput());
    }   
    if ($this->getInput() instanceOf Textarea) {
      $html .= $this->view->formTextarea($this->getInput());
    }
    if ($this->getInput() instanceOf Password) {
      $html .= $this->view->formPassword($this->getInput());
    }
    if ($this->getInput() instanceOf Checkbox) {
      $html .= $this->view->formCheckbox($this->getInput());
    }
    if ($this->getInput() instanceOf Date) {
      $html .= $this->view->formDate($this->getInput());
    }
    $idDivMEnsagemDeErro = 'mensagemErro'.$this->getInput()->getName(); 
    $html .= '<div id="'.$idDivMEnsagemDeErro.'"></div>';
    $html .=  $this->view->formElementErrors()
      ->setMessageOpenFormat('<div><p class="text-danger"><small>')
      ->setMessageSeparatorString('</small></p><p class="text-danger"><small>')
      ->setMessageCloseString('</small></p></div>')
      ->render($this->getInput());
    $html .= '</div>';

    if ($this->getInput() instanceOf File) {
      $html .= '<div class="col-lg-' . $tamanhoGrid . ' col-md-' . $tamanhoGrid . '">';
      $html .= '<div class="section">';
      $html .= '<label class="field file">';
      $html .= $this->view->formFile($this->getInput());
      $html .= '<span class="button btn-success">Escolher Arquivo</span>';
      $html .= '<input type="text" class="gui-input" id="text_'.$this->getInput()->getName().'">';
      $html .= '</label>';
      $html .= '</div>';
      $html .= '</div>';
    }
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
