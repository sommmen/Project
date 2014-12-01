$(document).ready(function(){

    $(".customerData input").keyup(function(){
        $(".half.results").html('<img src="/beheer/res/img/ajax-loader.gif" alt="loading..."/>');
        var val = $(this).val();
        var id = $(this).attr("id");

        $.post( "/beheer/res/js/ajax.php", { func:"dynSearch", attr:id, val:val }, function( data ) {
            $(".half.results").html('');

            console.log(1);

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

    $("form").on('click', '.user',function(){
        //alert($(this).attr("id"));

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

    $("#in_nav-checkbox").click(function(){
        if($(this).is(":checked")){
            $("#in_nav-number").show();
        }else{
            $("#in_nav-number").hide();
        }
    });

    var Photocount = 0;

    $(".selector").click(function(){
        $(this).parent().parent("figure").toggleClass("selected");
        if($(this).is(":checked")){
            Photocount++;
        }else{
            Photocount--;
        }

        alert(Photocount);
    });

});

function getSlug(Text)
{
    return Text
        .toLowerCase()
        .replace(/ /g, '-')
        .replace(/[^\w-]+/g, '')
        ;
}

function updateValue() {
    var title = document.getElementById("title").value;
    document.getElementById("slug").value = getSlug(title);
}
