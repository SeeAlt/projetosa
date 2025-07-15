$(document).ready(function() {
    $("#formReserva").submit(function(e) {
        e.preventDefault();

        $.ajax({
            url: 'booking.php',
            type: 'POST',
            dataType: 'json',
            data: $(this).serialize(),
            success: function(response) {
                $("#reservaMessage").fadeIn();
                if(response.success) {
                    $("#reservaMessage").removeClass("error").addClass("success").text("Reserva realizada com sucesso!");
                    $("#formReserva")[0].reset();
                } else {
                    $("#reservaMessage").removeClass("success").addClass("error").text(response.message);
                }
            },
            error: function() {
                $("#reservaMessage").fadeIn().removeClass("success").addClass("error").text("Erro ao enviar reserva.");
            }
        });
    });
});
