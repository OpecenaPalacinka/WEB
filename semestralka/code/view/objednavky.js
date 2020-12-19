
$(function() {
    $("td[colspan=8]").find("table").hide();

    $("table").click(function(event) {
        event.stopPropagation();
        var $target = $(event.target);

        if ($target.closest("td").attr("colspan") > 1 ) {
            $target.closest("tr").prev().find("td:first").html("<b>+</b>");
        } else {
            $target.slideDown;
            $target.closest("tr").next().find("table").slideToggle();

            if ($target.closest("tr").find("td:first").html() === "<b>+</b>") {
                $target.closest("tr").find("td:first").html("<b>-</b>");
            } else {
                $target.closest("tr").find("td:first").html("<b>+</b>");
            }
        }
    });
});

/* Schování řádky
$(document).ready(function () {
    $("td button[type='submit']").on("click", function() {
        DeleteRow(this);
    });

});

function DeleteRow(cellButton) {
    var row = $(cellButton).closest('tr')
        .children('td')
        .css({ backgroundColor: "black", color: "white" });
    var rowInner = $(cellButton).closest("tr").next().children("td");
    setTimeout(function () {
            $(row)
                .animate({ paddingTop: 0, paddingBottom: 0 }, 500)
                .wrapInner('<div />')
                .children()
                .slideUp(500, function() { $(this).closest('tr').remove(); });
        }, 350
    );
    setTimeout(function () {
            $(rowInner)
                .animate({ paddingTop: 0, paddingBottom: 0 }, 500)
                .wrapInner('<div />')
                .children()
                .slideUp(500, function() { $(this).closest('tr').remove(); });
        }, 350
    );
}

 */
/* Nefunkční ajax -> error 500
function buttonId(clicked_id){
    $.ajax({
        type: 'POST',
        url: 'http://localhost/semestralka/code/controller/objednavkyController.class.php',
        data: { "schvalit" : clicked_id },
        dataType: "text",
        error: function (){
            alert(clicked_id);
        }
    })
    console.log(clicked_id);
}*/
