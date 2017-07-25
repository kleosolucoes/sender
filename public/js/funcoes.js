

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

function validarExclusao(action, id) {
    var resposta = confirm('Confirma Exclusao?');
    if (resposta) {
        kleo(action, id);
    } else {
        return false;
    }
}

function mudarPaginaComLoader(url) {
    $(".splash").css("display", "block");
    location.href = url;
}

function submeterFormulario(form) {
    $(".splash").css("display", "block");
    form.submit();
}

function isEmail(email) {
    er = /^[a-zA-Z0-9][a-zA-Z0-9\._-]+@([a-zA-Z0-9\._-]+\.)[a-zA-Z-0-9]{2,3}$/;
    if (!er.exec(email)) {
        return false;
    } else {
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
    var match = ["image/jpeg", "image/png", "image/jpg", "video/mp4"];
    var tipoPreviewer = '';
    var maxFotoPerfil = 220 * 220 * 2;
    var maxUploadFoto = 450 * 600 * 2;
    var validacaoTamanho = 0;
    var tamanhoWidthFotoPerfil = 44;
    var tamanhoHeighFotoPerfil = 44;
    var tamanhoWidthUploadFoto = 450;
    var tamanhoHeighUploadFoto = 600;
    var tamanhoWidth = 0;
    var tamanhoHeight = 0;
    if (qualFoto == 1) {
        tipoPreviewer = 'fotoPerfil';
        validacaoTamanho = maxFotoPerfil;
        tamanhoWidth = tamanhoWidthFotoPerfil;
        tamanhoHeight = tamanhoHeighFotoPerfil;
        if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2]))) {
            input.value = null;
            alert('Tipo não compatível com foto de Perfil');
            return false;
        }
    }
    if (qualFoto == 2) {
        tipoPreviewer = 'upload';
        validacaoTamanho = maxUploadFoto;
        tamanhoWidth = tamanhoWidthUploadFoto;
        tamanhoHeight = tamanhoHeighUploadFoto;
    }

    if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2]) || (imagefile == match[3]))) {
        input.value = null;
        alert('Tipo invalido');
        return false;
    } else {

        if ((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2])) {
            if (input.files && input.files[0].size > validacaoTamanho) {
                alert("Arquivo muito grande"); // Do your thing to handle the error.
                input.value = null; // Clear the field.	
                return false;
            }
        }

        if ((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2])) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#image_upload_preview_' + tipoPreviewer).attr('src', e.target.result);
//                    $('#image_upload_preview_' + tipoPreviewer).attr('width', tamanhoWidth + 'px');
//                    $('#image_upload_preview_' + tipoPreviewer).attr('height', tamanhoHeight + 'px');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

    }
}

function mostrarEsconderUpload(tipo) {
    if (tipo === 1 || tipo === 2) {
        if (tipo === 1) {
            $('#labelinputUpload').text('Imagem -  .jpg até 450 x 600  , Peso máx: 200kb');
        }
        if (tipo === 2) {
            $('#labelinputUpload').text('Vídeo: .mp4 - Peso máx. até 1.5 Mb');
        }

        $('#divUpload').removeClass('hidden');
    } else {
        $('#divUpload').addClass('hidden');
    }
}