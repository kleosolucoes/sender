<?php
namespace Facebook\WebDriver;

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverKeys;
use Facebook\WebDriver\Conexao;

require_once('vendor/autoload.php');

$link = mysqli_connect('br130.hostgator.com.br', 'zapma087_novo', 'zP7KQbV[7G97', 'zapma087_zap');

if (!$link) {
  echo "Error: Unable to connect to MySQL." . PHP_EOL;
  echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
  echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
  exit;
}

echo "Success: A proper connection to MySQL was made! The my_db database is great." . PHP_EOL;
echo "Host information: " . mysqli_get_host_info($link) . PHP_EOL;

$sqlBot = "SELECT * FROM bot WHERE id = 1;";

mysqli_close($link);

$mensagens[0][0] = "Ola! Sou um bot em desenvolvimento tenho 3 opções:";
$mensagens[0][1] = "1 - Igreja";
$mensagens[0][2] = "2 - Equipe";
$mensagens[0][3] = "3 - Calistenia";
$mensagens[1] = 'Opção 1: Ceilandia';
$mensagens[2] = 'Opção 2: Blackbelt';
$mensagens[3] = 'Opção 3: Bandeira em X';

$host = 'http://localhost:4444/wd/hub';
$capabilities = DesiredCapabilities::firefox();
$capabilities->setCapability("webdriver.load.strategy", "unstable");
$driver = RemoteWebDriver::create($host, $capabilities, 60000, 120000);

$driver->get('http://web.whatsapp.com/');

echo "\n Esperando 5 segundos";
sleep(5);
echo "\n Esperando 5 segundos";
sleep(5);

$driver->manage()->timeouts()->implicitlyWait(10);

echo "\n Loop infinito de procura de novas mensagens";

while (true) {

  echo "\n Verificando se tem alguma mensagem nova";
  $mensagensNaoLidas = $driver->findElements(WebDriverBy::cssSelector("span.unread-count.icon-meta"));

  if (count($mensagensNaoLidas)) {

    echo "\n\n ##### Tenho mensagens nao lidas #####";
    sleep(2);
    echo "\n Procurando Contatos";
    $divListaInfinita = $driver->findElements(WebDriverBy::cssSelector("div.infinite-list-item.infinite-list-item-transition"));

    unset($listaDeContatos);
    if (count($divListaInfinita) > 0) {
      echo "\n\n Achei a lista de contatos";
      sleep(4);
      echo "\n Foreach da lista de contatos";

      foreach ($divListaInfinita as $divParaVerificar) {

        echo "\n Rodando foreach";
        $data = explode("\n", $divParaVerificar->getText());
        if (count($data) === 4) {
          echo "\n\n\n Contato com mensagem: " . $data[0];
          $listaDeContatos[] = $data[0];
          echo "\n Quantidade: " . $data[3];
          sleep(2);
        }// if se tem mensagem nova
      }// for dos contatos
    } else {// lista de contatos
      echo "\n\n Sem mensagens novas";
    }

    echo "\n\n\n Atendendo mensagens da ultima a primeira";
    for($indice = count($listaDeContatos) - 1; $indice >= 0; $indice--){
      echo "\n Procurando busca de contato";
      $inputFiltro = $driver->findElement(WebDriverBy::cssSelector("input.input-search"));
      $inputFiltro->sendKeys($listaDeContatos[$indice]);
      sleep(4);

      echo "\n Clicando no contato ou mensagem";
      $encontrado = false;
      try{
        $driver->findElement(WebDriverBy::cssSelector("div.chat-body"))->click();
        $encontrado = true;
      }catch(NoSuchElementException $exc){
        echo "\n\n Nao encontrou o contato";
      }

      if($encontrado){
        echo "\n Encontrado";
        sleep(4);

        echo "\n Procurando mensagens recebidas";
        $mensagensRecebidas = $driver->findElements(WebDriverBy::cssSelector("div.message.message-chat.message-in.message-chat"));
        sleep(2);

        $quantidadeDeMensagens = count($mensagensRecebidas);
        if ($quantidadeDeMensagens > 0) {
          echo "\n Achei as mensagens";
          echo "\n Ultima mensagem: ";
          $arrayMensagem = explode("\n", $mensagensRecebidas[($quantidadeDeMensagens - 1)]->getText());
          $ultimaMensagem = $arrayMensagem[(count($arrayMensagem) - 2)];
          echo "\n ##### " . $ultimaMensagem . " #####";
          echo "\n esperando 5 segundos";
          sleep(5);
          echo "\n Escrevendo";
          $elementoInputMensagem = $driver->findElement(WebDriverBy::xpath("//div[@contenteditable='true']"));
          $resposta = '';
          switch ($ultimaMensagem) {
            case 1:
              $resposta = $mensagens[$ultimaMensagem];
              break;
            case 2:
              $resposta = $mensagens[$ultimaMensagem];
              break;
            case 3:
              $resposta = $mensagens[$ultimaMensagem];
              break;
            default:
              $resposta = $mensagens[0][0];
              break;
          }

          if($ultimaMensagem == 1 ||
             $ultimaMensagem == 2 ||
             $ultimaMensagem == 3 ||
             $ultimaMensagem == "bot"){

            $elementoInputMensagem->sendKeys($resposta);
            sleep(2);
            echo "\n Escrito: " . $resposta;
            if($ultimaMensagem == "bot"){
              $elementoInputMensagem
                ->sendKeys(array(
                  WebDriverKeys::SHIFT,
                  WebDriverKeys::ENTER,

                ));
              sleep(0.2);
              $elementoInputMensagem
                ->sendKeys(array(
                  $mensagens[0][1],
                  WebDriverKeys::SHIFT,
                  WebDriverKeys::ENTER,
                ));

              sleep(0.2);
              $elementoInputMensagem
                ->sendKeys(array(
                  $mensagens[0][2],
                  WebDriverKeys::SHIFT,
                  WebDriverKeys::ENTER,
                ));

              sleep(0.2);
              $elementoInputMensagem
                ->sendKeys(array(
                  $mensagens[0][3],
                ));
            }
            echo "\n Botao de enviar";
            $driver->findElement(WebDriverBy::cssSelector("button.compose-btn-send"))->click();
            sleep(2);
            echo "\n Enviado";

          }
        }
      }else{
        echo "\n ????? Nao encontrei o contato ?????";
      }


    }//fim for do array

    $driver->navigate()->refresh();
    echo "\n\n\n\n Esperando 5 segundos antes de tentar achar as mensagens";
    sleep(5);
  }
}
