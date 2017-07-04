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

    $html .= '<div id="header">';
    $html .= '<div class="color-line">';
    $html .= '</div>';
    $html .= '<div id="logo" class="light-version">';
    $html .= '<span>';
    $html .= KleoController::nomeAplicacao;
    $html .= '</span>';
    $html .= '</div>';
    $html .= '<nav role="navigation">';
    $html .= '<div class="header-link hide-menu"><i class="fa fa-bars"></i></div>';
    $html .= '<span class="text-primary">' . KleoController::nomeAplicacao . '</span>';
    $html .= '<div class="small-logo">';
    $html .= '</div>';
    $html .= '<div class="mobile-menu">';
    $html .= '<button type="button" class="navbar-toggle mobile-menu-toggle" data-toggle="collapse" data-target="#mobile-collapse">';
    $html .= '<i class="fa fa-chevron-down"></i>';
    $html .= '</button>';
    $html .= '<div class="collapse mobile-navbar" id="mobile-collapse">';
    $html .= '<ul class="nav navbar-nav">';
    $html .= '<li>';
    $html .= '<a class="" href="login.html">Login</a>';
    $html .= '</li>';
    $html .= '<li>';
    $html .= '<a class="" href="login.html">Logout</a>';
    $html .= '</li>';
    $html .= '<li>';
    $html .= '<a class="" href="profile.html">Profile</a>';
    $html .= '</li>';
    $html .= '</ul>';
    $html .= '</div>';
    $html .= '<div class="navbar-right">';
    $html .= '</div>';
    $html .= '<ul class="nav navbar-nav no-borders">';
    $html .= '<li class="dropdown">';
    $html .= '<a href="login.html">';
    $html .= '<i class="pe-7s-upload pe-rotate-90"></i>';
    $html .= '</a>';
    $html .= '</li>';
    $html .= '</ul>';
    $html .= '</div>';
    $html .= '</nav>';
    $html .= '</div>';

    $html .= '<aside id="menu">';
    $html .= '<div id="navigation">';
    $html .= '<div class="profile-picture">';
    $html .= '<a href="index.html">';
    $html .= '<!--<img src="images/profile.jpg" class="img-circle m-b" alt="logo">-->';
    $html .= 'KLEO';
    $html .= '</a>';

    $html .= '<div class="stats-label text-color">';
    $html .= '<span class="font-extra-bold font-uppercase">Kort e Léo</span>';

    $html .= '<div class="dropdown">';
    $html .= '<a class="dropdown-toggle" href="#" data-toggle="dropdown">';
    $html .= '<small class="text-muted">Founder of App <b class="caret"></b></small>';
    $html .= '</a>';
    $html .= '<ul class="dropdown-menu animated flipInX m-t-xs">';
    $html .= '<li><a href="contacts.html">Contacts</a></li>';
    $html .= '<li><a href="profile.html">Profile</a></li>';
    $html .= '<li><a href="analytics.html">Analytics</a></li>';
    $html .= '<li class="divider"></li>';
    $html .= '<li><a href="login.html">Logout</a></li>';
    $html .= '</ul>';
    $html .= '</div>';
    $html .= '<div id="sparkline1" class="small-chart m-t-sm"></div>';
    $html .= '<div>';
    $html .= '<h4 class="font-extra-bold m-b-xs">';
    $html .= '$260 104,200';
    $html .= '</h4>';
    $html .= '<small class="text-muted">Your income from the last year in sales product X.</small>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '<ul class="nav" id="side-menu">';
    $html .= '<li>';
    $html .= '<a href="#"><span class="nav-label">Cadastro</span><span class="fa arrow"></span> </a>';
    $html .= '<ul class="nav nav-second-level">';
    $html .= '<li><a href="/cadastroResponsaveis">Responsaveis</a></li>';
    $html .= '<li><a href="/cadastroShoppings">Shoppings</a></li>';
    $html .= '<li><a href="/cadastroLojas">Lojas</a></li>';
    $html .= '<li><a href="/cadastroAnuncios">Anuncios</a></li>';
    $html .= '<li><a href="/cadastroCategorias">Categorias</a></li>';
    $html .= '</ul>';
    $html .= '</li>';
    $html .= '</ul>';
    $html .= '</div>';
    $html .= '</aside>';
    return $html;
  }
}