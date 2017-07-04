<?php
namespace Application\View\Helper;
use Zend\View\Helper\AbstractHelper;
/**
 * Nome: FuncaoOnClick.php
 * @author Leonardo Pereira Magalhães <falecomleonardopereira@gmail.com>
 * Descricao: Classe helper view para montar a função onClick no elemento
 */
class FuncaoOnClickSubmeterFormulario extends AbstractHelper {
  
  public function __construct() {

  }
  public function __invoke() {
   return $this->renderHtml();
  }
  public function renderHtml() {
    $html = '';
    $html .= $this->view->funcaoOnClick('submeterFormulario(this.form)');
    return $html;
  } 
}