$('document').ready(function(){
  setTimeout(removeLoader, 3000);

});
function removeLoader(){
    $( ".loader" ).fadeOut(500, function() {
      // fadeOut complete. Remove the loading div
      $( ".loader" ).remove(); //makes page more lightweight 
  })};  



function showform(){
   $('#grievance').css("display","block");
}

