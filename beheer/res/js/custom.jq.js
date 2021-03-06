$(document).ready(function(){
/*
 *              in al haar professionaliteit gemaakt door:
 *                          Kevin Pijning
 */

    /*
    Hier worden suggesties opgezocht voor bestaande klanten.
    Wanneer een beheerder 1 van de klant informatie velden invult wordt er automatisch gezocht naar matches in de database.
    De resultaten worden aan de zijkant van de pagina weergegeven.
     */
    $(".customerData input").keyup(function(){
        $(".half.results").html('<img src="/beheer/res/img/ajax-loader.gif" alt="loading..."/>');
        var val = $(this).val();
        var id = $(this).attr("id");

        //haal suggesties op via ajax
        $.post( "/beheer/res/js/ajax.php", { func:"dynSearch", attr:id, val:val }, function( data ) {
            $(".half.results").html('');

            console.log(1);
            // genereer lijst met suggesties
            for(var key in data){
                var html = "<ul class=\"user\" id=\"user-"+data[key]['id']+"\"><li>"+data[key]['name'] + " " + data[key]['surname'] + "" +
                    "<ul><li>"+ data[key]['email'] +"</li>" +
                    "<li>"+ data[key]['address'] +"</li>" +
                    "<li>"+ data[key]['zipcode'] +"</li>" +
                    "<li>"+ data[key]['city'] +"</li>" +
                    "<li>"+ data[key]['telephone'] +"</li></ul></li></ul>";
                $(".half.results").append(html);
            }
        }, "json");
        $(".half.results").html('');

    });

    /*
    Als er op een suggestie wordt geklikt worden de klant infotmatie velden weggehaald, en komt er een box te staan met de info van de gekozen klant.
    Als de gebruiker weer op de box met informatie klikt zal de box teruggaan naar de rechter kant van de pagina, en komen de klant infotmatie velden weer tevoorschijn.
     */
    $("form").on('click', '.user',function(){

        var user_id = $(this).attr('id');
        user_id = user_id.split('-');

        $(".half.results ul").hide();

        $(".half.results ul#user-" + user_id[1]).show();
        $(".half.results ul#user-" + user_id[1] + " ul").show();



        $(".half.form").slideToggle(function(){
            if($("input#user_id").val() == 0){
                $("input#user_id").val(user_id[1]);
            }else{
                $("input#user_id").val(0);
            }
        });
    });


    Dropzone.options.myAwesomeDropzone = { // The camelized version of the ID of the form element

        // The configuration we've talked about above
        acceptedFiles: ".jpeg,.jpg,.png,.gif,.JPEG,.JPG,.PNG,.GIF",
        maxFiles: 100,

        // The setting up of the dropzone
        init: function() {
            var myDropzone = this;

            // Listen to the sendingmultiple event. In this case, it's the sendingmultiple event instead
            // of the sending event because uploadMultiple is set to true.
            this.on("sendingmultiple", function() {
                // Gets triggered when the form is actually being sent.
                // Hide the success button or the complete form.
            });

        }

    }

    /*
    Hier wordt geteld hoeveel foto's de klant geselecteerd heeft, en als ze over het limiet heen gaan krijgen ze eenmalig een melding.
     */
    var Photocount = parseInt($("#currentSelectedPhotos").text());
    var Photomax = parseInt($("#maxSelectedPhotos").text());
    var modal = false;

    $(".selector").click(function(){
        $(this).parent().parent("figure").toggleClass("selected");
        if($(this).is(":checked")){
            Photocount++;
        }else{
            Photocount--;
        }
        $("#currentSelectedPhotos").text(Photocount);

        if(Photocount > Photomax && modal == false && Photomax != 0){
            modal = true;
            alert("U heeft meer foto's geselecteerd dan afgesproken, Dit is natuurlijk geen probleem! Wij nemen contact met u op over verdere afhandeling.");
        }
    });
    
/*
 *              in al haar professionaliteit gemaakt door:
 *                          Dion Leurink
 */

//laat een nummercount (zodat de admin de menubar volgorde kan instellen) zien als deze aangevinkt is
    $("#in_nav-checkbox").click(function(){
        if($(this).is(":checked")){
            $("#in_nav-number").show();
        }else{
            $("#in_nav-number").hide();
        }
    });

//geeft respectievelijk 'inloggen' en 'wachtwoord vergeten' weer op dezelfde pagina (login.php)
    $("#toggleDropDown").click(function () {

        $("#dropdown").slideToggle("slow");
        $("#loginform").slideToggle("slow");

        var test = $("#toggleDropDown").text();

        if (test === "Wachtwoord vergeten") {
            $("#toggleDropDown").text("Terug");
            $("section > header").text("Nieuw Wachtwoord");
        } else {
            $("#toggleDropDown").text("Wachtwoord vergeten");
            $("section > header").text("Login");
        }

    });

    //maakt van een stukje text een 'zoekmachine vriendelijke link' oftewel: slug.
    function getSlug(Text)
    {
        return Text
                .toLowerCase()
                .replace(/ /g, '-')
                .replace(/[^\w-]+/g, '');
    }

//zorgt ervoor dat als je de titel wijzigt er automatisch ook een slug word gemaakt in de desbetrefende input.
    function updateValue() {
        var title = document.getElementById("title").value;
        document.getElementById("slug").value = getSlug(title);
    }

});


