$(document).ready(function () {
    
    /*
     *          Gemaakt Door:
     *          Kevin Pijning
     */

    $("#mobileMenu").click(function () {
        $("nav").slideToggle();
    });


    if ($(window).width < 749) {
        $(".main").click(function () {
            $("nav").slideUp();
        });
    }

    $(window).resize(function () {
        if ($(this).width() > 749) {
            $("nav").show();
        }
    });

    /*
     *          Gemaakt Door:
     *          Dion Leurink
     */

//geeft respectievelijk 'inloggen' en 'wachtwoord vergeten' weer op dezelfde pagina (login.php)
    $("#toggleDropDown").click(function () {
        $("#dropdown").slideToggle("slow");
        $("#loginform").slideToffle("slow");

        var test = $("#toggleDropDown").text();
        
        if (test === "Wachtwoord vergeten") {
          $("#toggleDropDown").text("Terug");
          $("section > header").text("Nieuw Wachtwoord");
        } else {
            $("#toggleDropDown").text("Wachtwoord vergeten");
            $("section > header").text("Login");
        }
        
    });

});
