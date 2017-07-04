<?php
namespace Application\View\Helper;
use Zend\View\Helper\AbstractHelper;
/**
 * Nome: CabecalhoPagina.php
 * @author Leonardo Pereira Magalhães <falecomleonardopereira@gmail.com>
 * Descricao: Classe helper view para mostrar o cabeçalho da página
 */
class CabecalhoPagina extends AbstractHelper {

  private $label;
  private $extra;

  public function __construct() {

  }
  public function __invoke($label, $extra = null) {
    $this->setLabel($label);
    if($extra){
      $this->setExtra($extra);
    }
    return $this->renderHtml();
  }
  
  public function renderHtml() {
    $html = '';
    $html .= '<div class="small-header transition animated fadeIn">';
    $html .= '<div class="hpanel">';
    $html .= '<div class="panel-body">';  
    $html .= '<div id="hbreadcrumb" class="pull-right">';  
    $html .= $this->getExtra();
    $html .= '</div>';  
    $html .= '<h2 class="font-light m-b-xs">';
    $html .= $this->getLabel();
    $html .= '</h2>';
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
    return $this;
  }  
  function getExtra() {
    return $this->extra;
  }
  function setExtra($extra) {
    $this->extra = $extra;
    return $this;
  }
}