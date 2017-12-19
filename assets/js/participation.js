$('#participe').click(function () {
    var send = {
        participant: 1,
        id_activite: $('#idActivity').html()

    }
    $.post('../inscription', send)
        .done(function (data) {
            $(".message-alert").html('Vous êtes inscrit');
            $(".message-alert").fadeIn(120).delay(1800).fadeOut(800);
            $(".message-alert").addClass('success');
        })
        .fail(function (e) {
            console.error('erreur : ' + e)
        });
});

$('#dontParticipe').click(function () {
    var send = {
        participant: 0,
        id_activite: $('#idActivity').html()

    }
    $.post('../inscription', send)
        .done(function (data) {
            $(".message-alert").html('Vous n\'êtes pas inscrit');
            $(".message-alert").fadeIn(0).delay(1800).fadeOut(200);
            $(".message-alert").addClass('success');
        })
        .fail(function (e) {
            console.error('erreur : ' + e)
        });

});
