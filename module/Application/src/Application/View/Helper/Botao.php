<?php
namespace Application\View\Helper;
use Zend\View\Helper\AbstractHelper;
/**
 * Nome: Botao.php
 * @author Leonardo Pereira Magalhães <falecomleonardopereira@gmail.com>
 * Descricao: Classe helper view para mostrar um botao
 */
class Botao extends AbstractHelper {
    private $label;
    private $extra;
    private $tipoBotao;
    public function __construct() {
        
    }
    public function __invoke($label, $extra = '', $tipoBotao = 1) {
        $this->setLabel($label);
        $this->setExtra($extra);
        $this->setTipoBotao($tipoBotao);
        return $this->renderHtml();
    }
    public function renderHtml() {
        $html = '';
        $classCor = 'info';
        if($this->getTipoBotao() === 2){
            $classCor = 'default';
        }
        $html .= '<button style="margin-left:10px; padding: 10px;" type="button" ' . $this->getExtra() . ' class="btn btn-' . $classCor . ' pull-right ml10">';
        $html .= $this->view->translate($this->getLabel());
        $html .= '</button>';
        return $html;
    }
    function getLabel() {
        return $this->label;
    }
    function getExtra() {
        return $this->extra;
    }
    function setLabel($label) {
        $this->label = $label;
        return $this;
    }
    function setExtra($extra) {
        $this->extra = $extra;
        return $this;
    }
    function getTipoBotao() {
        return $this->tipoBotao;
    }
    function setTipoBotao($tipoBotao) {
        $this->tipoBotao = $tipoBotao;
        return $this;
    }
}