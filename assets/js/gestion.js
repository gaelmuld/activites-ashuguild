$('.btnAct').hide();
//Variables
var startAct = 1;
var toggle = [".btnMod", ".btnAct"].join();
var editable = ".ed";


/*************************\
|**functions de bouttons**|
\*************************/

function editableFields() {
    $(editable).attr("contenteditable", "true");
    $(editable).css("background-color", "rgba(220,240,235,.6)");
}

function editedFields() {
    $(editable).attr("contenteditable", "false");
    $(editable).css("background-color", "inherit");
}

function changeImgActivity() {
    $('#imgActivity').bind("keyup", function () {
        $('#imgActivityResult').attr('src', $(this).val());
        $('#imgActivityResult').parent('a').attr('href', $(this).val());
    });
}

function createActivity() {
    var empty = ["#dateStart", "#dateEnd", "#idActivity", "#imgActivity"];
    empty = empty.join();
    changeImgActivity();
    $('#btnCreer').click(function () {
        $(toggle).toggle();
        $(empty).val("");
        $(empty).html("");
        editableFields();
        $(editable).children().html("À modifier");
        $('p.ed').html("À modifier");
        $('#imgActivityResult').attr('src', "http://via.placeholder.com/400x250?text=L\'image+à+mettre");
    });
}

function newActivity() {
    changeImgActivity();
    $(toggle).toggle();
    editableFields();
}

function modifActivity() {
    changeImgActivity();
    $('#btnModif').click(function () {
        startAct = 0;
        $(toggle).toggle();
        editableFields()
    });
}

function backChange() {

    $('#btnAnnule').click(function () {
        window.location.reload();
    });
}

function validateChange() {
    $('#btnValid').click(function () {
        var requested = ["#dateStart", "#dateEnd", "#titleActivity"];
        var check = 1;
        $.each(requested, function (index, value) {
            if (!(validation = Math.max($(value).val().length, $(value).html().length))) {
                $(value).css('outline', '2px solid red');
                $(".message-alert").html('Remplissez Les champs manquants');

            }
            check *= validation;
        });
        if (check) {
            editedFields();
            $(toggle).toggle();
            registreActivite(startAct);
        } else {
            $(".message-alert").fadeIn(130).delay(2200).fadeOut(600);
            $(".message-alert").addClass('error');

        }
    });
}

/***********************\
|**Appel des fonctions**|
\***********************/
if ($("#idActivity").html() == 'N/A') {
    newActivity();
}

createActivity();
modifActivity();
backChange();
validateChange();


/*********************\
|**fonction d'envoie**|
\*********************/

function registreActivite(newActivity) {

    var activite = {
        dateDebut: $('#dateStart').val(),
        dateFin: $('#dateEnd').val(),
        titre: $('#titleActivity').html(),
        imgDescription: $('#imgActivity').val(),
        description: $('#descriptionActivity').html(),
        regles: $('#ruleActivity').html(),
        duree: $('#timeActivity').html(),
        prerequis: $('#requestActivity').html(),
        type: "1",
        createur: $('#createurId').val()
    };

    var toSend = {
        idActivity: $('#idActivity').html(),
        activite: activite
    };
    if (newActivity) {
        $.post('./activityCreate', toSend)
            .done(function () {})
            .fail(function (e) {
                console.error('erreur : ' + e)
            });
    } else {
        $.post('../activityUpdate', toSend)
            .done(function () {})
            .fail(function (e) {
                console.error('erreur : ' + e)
            });
    }
}

function gestionInfo(id) {
    $(".tableInfo").addClass('d-none');
    $("#info-" + id).removeClass('d-none');
    console.log($("#info-" + id));
}
