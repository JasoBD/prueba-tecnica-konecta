

$(document).ready(function() {
    $('#tabla').DataTable();
} );
$(document).ready(function () {

    var idProduct = null;
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

    $("#frmProduct").validate({
        ignore: ":hidden",
        rules: {
            name: {
                required: true,
                minlength: 3
            },
            reference: {
                required: true,

            },
            price: {
                required: true
            },
            stock: {

                required: true
            },
            category: {
                minlength: 3,
                required: true
            },
            weight: {

                required: true
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
                var action = !idProduct ? "register" : "update";
                var message = !idProduct ? "¡Registro creado!" : "¡Registro actualizado!";

                $.ajax({
                    url: "?Controller=Products&action=" + action,
                    data: $(form).serialize(),
                    type: 'POST',
                    success: function (data) {

                         $('#div-results').html(data);

                        if ($('.modal-backdrop').is(':visible')) {
                            $('body').removeClass('modal-open');
                            $('.modal-backdrop').remove();
                            $("#productModal").modal('hide');
                        };
                        //Success Message == 'Title', 'Message body', Last one leave as it is
                        swal(message, "success");
                        dataTables();

                    },
                    error: function (data) {

                        //Error Message == 'Title', 'Message body', Last one leave as it is
                        swal("Oops...", "Something went wrong :(", "error");
                    }
                });
            } catch (error) {
                console.error(error);

            }

        }
    });

    // Funcion de traer los datos segun el id
    function dataTables() {
        $("#tabla").dataTable().fnDestroy();
        $('#tabla').DataTable();
    }

    dataTables();

    $('body').on("click",".show-modal-product",function () {
        idProduct = $(this).attr('data-id');
        $("#productModal").modal('show');
        if (!idProduct) {
            idProduct = null;
            $('#frmProduct').trigger("reset");
            $("#btn-save-update").html("Guardar")
        } else {
            $("#btn-save-update").html("Actualizar")
            getProduct(idProduct)
        }
    });


});
// Funcion de traer los datos segun el id
function getProduct(id) {
    var url = "?Controller=Products&action=getProdut";
    $.post(url, {"id": id}, function (response) {
        const {id, name, reference, price, weight, category, stock} = JSON.parse(response);
        $('#productModalLabel').html('Actualizar productos');
        $('#id').val(id);
        $('#name').val(name);
        $('#reference').val(reference);
        $('#price').val(price);
        $('#weight').val(weight);
        $('#category').val(category);
        $('#stock').val(stock);
    });
}
// Funcion de abrir el modal de crear o actualizar
function showModalProduct(id) {
    idProduct = id;
    $("#productModal").modal('show');
    if (!idProduct) {
        idProduct = null;
        $('#frmProduct').trigger("reset");
        $("#btn-save-update").html("Guardar")
    } else {
        $("#btn-save-update").html("Actualizar")
        getProduct(idProduct)
    }
}

// Funcion de eliminar un registro
function alertDeleteProduct(id) {

    swal({
        title: "¿Estás seguro?",
        text: "No podrás revertir esta acción",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                var url = "?Controller=Products&action=delete"
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

$(document).ready(function () {
    $('body').on("click",".show-modal-sale",function () {
        $("#saleModal").modal('show');
    });
});
