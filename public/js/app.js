$(document).ready(function(){
    $("#addGallerie").click(function (){
        $(".gallerieForm").removeClass("hidden");
    });
    $("#submitGallerie").click(function () {
       $("#submitGallerie").addClass("hidden");
    });
});