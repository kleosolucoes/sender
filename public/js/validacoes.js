

function validacoesFormulario(campo){
  var temErro = false;
  var mensagemDeErro = '';
  switch(campo.id){
    case 'inputNome':
      if(campo.value.length < 3 || campo.value.length > 50){
        temErro = true;
        mensagemDeErro = 'Nome precisa ter 3 a 50 caracteres';
      }
      break;
    case 'inputPrimeiroNome':
      if(campo.value.length < 3 || campo.value.length > 50){
        temErro = true;
        mensagemDeErro = 'Primeiro Nome precisa ter 3 a 50 caracteres';
      }
      break;
    case 'inputUltimoNome':
      if(campo.value.length < 3 || campo.value.length > 50){
        temErro = true;
        mensagemDeErro = 'Ultimo Nome precisa ter 3 a 50 caracteres';
      }
      break;
    case 'inputTelefone':
      if(campo.value.length < 10 || campo.value.length > 11){
        temErro = true;
        mensagemDeErro = 'Telefone precisa ter 10 ou 11 caracteres';
      }
      break;
    case 'inputEmail':
      if(!isEmail(campo.value)){
        temErro = true;
        mensagemDeErro = 'Preencha o email corretamente';
      }
      break;
    case 'inputRepetirEmail':
      if(campo.value.length === 0 || campo.value != document.getElementById(inputEmail).value){
        temErro = true;
        mensagemDeErro = 'Repita o email corretamente';
      }
      break;
    case 'inputNomeEmpresa':
      if(campo.value.length < 3 || campo.value.length > 50){
        temErro = true;
        mensagemDeErro = 'Nome da Empresa precisa ter 3 a 50 caracteres';
      }
      break;
    case 'inputCNPJ':
      if(campo.value.length != 14){
        temErro = true;
        mensagemDeErro = 'Preencha o CNPJ corretamente';
      }
      break;
    case 'inputSenha':
      if(campo.value.length === 0){
        temErro = true;
        mensagemDeErro = 'Preencha a senha';
      }
      break;
    case 'inputRepetirSenha':
      if(campo.value.length === 0 || campo.value != document.getElementById(inputSenha).value){
        temErro = true;
        mensagemDeErro = 'Repita a senha';
      }
      break;
    default: break;
  }

  if(temErro){
    escreveMensagemDeErro(campo.id, mensagemDeErro);
  }else{
    limpaAMensagemDeErro(campo.id);
  }

}

function escreveMensagemDeErro(id, mensagem){
  var html = '<p class="text-danger"><small>' +
      mensagem +
      '</small></p>';
  var idDiv = 'mensagemErro' + id;
  document.getElementById(idDiv).innerHTML = html;
}

function limpaAMensagemDeErro(id){
  var html = '';
  var idDiv = 'mensagemErro' + id;
  document.getElementById(idDiv).innerHTML = html;
}