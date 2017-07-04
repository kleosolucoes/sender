

function kleo(action, id) {  
  $(".splash").css("display", "block");
  $.post(
    '/admKleo',
    {
      action: action,
      id: id                  
    },
    function (data) {
      if (data.response) {
        location.href = data.url;                
      }
    }, 'json');    
}

function mudarPaginaComLoader(url){
  $(".splash").css("display", "block");
  location.href = url;
}

function submeterFormulario(form){
  $(".splash").css("display", "block");
  form.submit();
}

function isEmail(email){
  er = /^[a-zA-Z0-9][a-zA-Z0-9\._-]+@([a-zA-Z0-9\._-]+\.)[a-zA-Z-0-9]{2,3}$/; 
	if( !er.exec(email) ){
    return false;
  }else{
    return true;
  }
}

$(window).bind("load", function () {
  // Remove splash screen after load
  $('.splash').css('display', 'none')
});

function carregarFoto(input, qualFoto) {
  var file = input.files[0];
  var imagefile = file.type;
  var match= ["image/jpeg","image/png","image/jpg"];
  if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2]))){
    alert('tipo errado');
    return false;
  }else{
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        $('#image_upload_preview'+qualFoto).attr('src', e.target.result);
        $('#image_upload_preview'+qualFoto).attr('width', '100px');
        $('#image_upload_preview'+qualFoto).attr('height', '100px');
      }
      reader.readAsDataURL(input.files[0]);
    }
  }
}