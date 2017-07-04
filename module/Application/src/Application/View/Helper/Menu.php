<?php
namespace Application\View\Helper;
use Zend\View\Helper\AbstractHelper;
use Application\Controller\KleoController;
/**
* Nome: Menu.php
 * @author Leonardo Pereira Magalhães <falecomleonardopereira@gmail.com>
 * Descricao: Classe helper view para mostrar o menu
 */
class Menu extends AbstractHelper {
  public function __construct() {

  }
  public function __invoke() {
    return $this->renderHtml();
  }
  public function renderHtml() {
    $html = '';

    $stringFoto = 'placeholder.png';

    // Start: Header 
    $html .= '<header class="navbar navbar-fixed-top">';

    $html .= '<div class="navbar-branding">';
    $html .= '<a class="navbar-brand" href="#" style="padding-top: 22px;">';
    $html .= '<img src="/img/logos/new_logo-circuito.png" title="' .
      $this->view->translate(KleoController::nomeAplicacao) . '" class="img-responsive" style="max-width:100%;">';
    $html .= '</a>';
    $html .= '<span id="toggle_sidemenu_l" class="ad ad-lines"></span>';
    $html .= '</div>';
    $html .= '<ul class="nav navbar-nav navbar-right">';
    $html .= '<li class="dropdown menu-merge">';
    $html .= '<a href="#" class="dropdown-toggle fw600 p15" data-toggle="dropdown">';      
    $html .= '<img src="/img/avatars/' . $stringFoto . '" alt="" class="mw30 br64">' .
      'GERACAO DE VALOR';
    $html .= '<span class="pl5">- FLAVIO AUGUSTO</span>';
    $html .= '<span class="caret caret-tp"></span>';
    $html .= '</a>'; 

    $html .= '<ul class="dropdown-menu list-group dropdown-persist w250" role="menu">';
    $html .= '<li class="dropdown-footer">';
    $html .= '<a href="" class="">';
    $html .= '<span class="fa fa-power-off pr5"></span>' . 'Sair' . '</a>';
    $html .= '</li>';
    $html .= '</ul>';
    $html .= '</li>';
    $html .= '</ul>';

    $html .= '</header>';

    // Start: Sidebar
    $html .= '<aside id="sidebar_left" class="nano nano-light affix">';

    // Start: Sidebar Left Content
    $html .= '<div class="sidebar-left-content nano-content">';

    // Start: Sidebar Header
    $html .= '<header class="sidebar-header">';

    // Sidebar Widget - Author 
    $html .= '<div class="sidebar-widget author-widget">';
    $html .= '<div class="media">';
    $html .= '<a class="media-left" href="#">';
    $html .= '<img src="/img/avatars/' . $stringFoto . '" class="img-responsive">';
    $html .= '</a>';
    $html .= '<div class="media-body">';
    $html .= '<div class="media-links">';
    $html .= '<a href="/preSaida">Sair</a>';
    $html .= '</div>';
    $html .= '<div class="media-author">FLAVIO AUGUSTO</div>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';

    $html .= '</header>';

    $html .= '<ul class="nav sidebar-menu">';

    $html .= '<li class="sidebar-label pt20">Principal</li>';
    $html .= '<li>';
    $html .= '<a href="/adm">';
    $html .= '<span class="fa fa-home"></span>';
    $html .= '<span class="sidebar-title">Principal</span>';
    $html .= '</a>';
    $html .= '</li>';

    /* Start: Sidebar Menu */
    $html .= '<ul class="nav sidebar-menu">';
    $html .= '<li class="sidebar-label pt20">Menu</li>';

    $html .= '<li class="sidebar-label pt20">Campanhas</li>';

    $html .= '<li>';
    $html .= '<a href="/admCampanhas">';
    $html .= '<span class="fa fa-home"></span>';
    $html .= '<span class="sidebar-title">Listagem</span>';
    $html .= '</a>';
    $html .= '</li>';   

    $html .= '<li>';
    $html .= '<a href="/admCampanha">';
    $html .= '<span class="fa fa-home"></span>';
    $html .= '<span class="sidebar-title">Cadastrar</span>';
    $html .= '</a>';
    $html .= '</li>';   

    $html .= '</ul>';
    // End: Sidebar Menu

    // Start: Sidebar Collapse Button
    $html .= '<div class="sidebar-toggle-mini">';
    $html .= '<a href="#">';
    $html .= '<span class="fa fa-sign-out"></span>';
    $html .= '</a>';
    $html .= '</div>';
    // End: Sidebar Collapse Button

    $html .= '</div>';
    // End: Sidebar Left Content

    $html .= '</aside>';

    return $html;
  }
}