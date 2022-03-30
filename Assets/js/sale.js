
$(document).ready(function () {
    var idSale = null;
    jQuery.extend(jQuery.validator.messages, {
        required: "Este campo es obligatorio.",
        remote: "Por favor, rellena este campo.",
        email: "Por favor, escribe una dirección de correo válida",
        url: "Por favor, escribe una URL válida.",
        date: "Por favor, escribe una fecha válida.",
        dateISO: "Por favor, escribe una fecha (ISO) válida.",
        number: "Por favor, escribe un número entero válido.",
        digits: "Por favor, escribe sólo dígitos.",
        creditcard: "Por favor, escribe un número de tarjeta válido.",
        equalTo: "Por favor, escribe el mismo valor de nuevo.",
        accept: "Por favor, escribe un valor con una extensión aceptada.",
        maxlength: jQuery.validator.format("Por favor, no escribas más de {0} caracteres."),
        minlength: jQuery.validator.format("Por favor, no escribas menos de {0} caracteres."),
        rangelength: jQuery.validator.format("Por favor, escribe un valor entre {0} y {1} caracteres."),
        range: jQuery.validator.format("Por favor, escribe un valor entre {0} y {1}."),
        max: jQuery.validator.format("Por favor, escribe un valor menor o igual a {0}."),
        min: jQuery.validator.format("Por favor, escribe un valor mayor o igual a {0}.")
    });

    $("#frmSale").validate({
        ignore: ":hidden",
        rules: {
            id_product: {
                required: true,

            },
            quantity: {
                required: true,

            },
            message: {
                required: true,
                minlength: 10
            }
        },
        submitHandler: function (form) {
            var capcha = grecaptcha.getResponse();

            $("#msg_error").hide();
            $("#msg_success").hide();

            if(capcha.length < 8) {
                $("#msg_error").text("Por favor verifica el captcha").show();
                return false;
            }
            try {
                var action = !idSale ? "register" : "update";
                var message = !idSale ? "¡Registro creado!" : "¡Registro actualizado!";

                $.ajax({
                    url: "?Controller=Sales&action=" + action,
                    data: $(form).serialize(),
                    type: 'POST',
                    dataType: 'json',
                    async: true,
                })
                    .done(function ajaxDone(res){
                        console.log(res);
                        if(res.error !== undefined){
                            $("#msg_error").html(res.error).show();
                            return false;
                        }else {

                            swal(message, "success");
                        }
                        if(res.redirect !== undefined){
                            window.location = res.redirect;
                        }
                    })
                    .fail(function ajaxError(e){
                        console.log(e);
                    })
                    .always(function ajaxSiempre(){
                    })
                return false;
            } catch (error) {
                console.error(error);

            }

        }
    });


    $('body').on("click",".show-modal-sale",function () {
        idSale = $(this).attr('data-id');
        $("#saleModal").modal('show');
        if (!idProduct) {
            idProduct = null;
            $('#frmSale').trigger("reset");
            $("#btn-save-update").html("Guardar")
        }
    });


});

function alertDeleteSale(id) {

    swal({
        title: "¿Estás seguro?",
        text: "No podrás revertir esta acción",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                var url = "?Controller=Sales&action=delete"
                $.ajax({
                    type: "POST", // la variable type guarda el tipo de la peticion GET,POST,..
                    url: url, //url guarda la ruta hacia donde se hace la peticion
                    data: {"id": id}, // data recive un objeto con la informacion que se enviara al servidor
                    success: function (datos) { //success es una funcion que se utiliza si el servidor retorna informacion
                        $('#div-results').html(datos);
                        if ($('.modal-backdrop').is(':visible')) {
                            $('body').removeClass('modal-open');
                            $('.modal-backdrop').remove();
                        }

                    },
                })
                swal("'¡El registro fue eliminado.!", {
                    icon: "success",
                });
            } else {
                swal("Tu procducto esta a salvo!");
            }
        });
}
