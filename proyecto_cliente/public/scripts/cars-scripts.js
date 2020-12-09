$(document).ready(function () {
    /*
        Filters
    */
    $(".filter-btn").on("click", function (e) {
        e.preventDefault();
        if ($(this).hasClass("collapsed")) {
            $(this).find("i").removeClass("fa-chevron-right");
            $(this).find("i").addClass("fa-chevron-down");
        } else {
            $(this).find("i").addClass("fa-chevron-right");
            $(this).find("i").removeClass("fa-chevron-down");
        }
    });

   

    /*
    Switch save icons
*/
    $(".save-btn").click(function () {
        let id = $(this).attr("id");
        $("#" + id + " i").toggleClass("far fa-heart");
        $("#" + id + " i").toggleClass("fas fa-heart");

        // var idUser = $("#"+id).attr("user-cookie");

    
       

    });



});

