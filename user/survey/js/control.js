/*Without jQuery Cookie*/
$(document).ready(function(){
	$("#majorfield").css("display","none");
	$("#blockexit").css("display","none");
	$("#block1").css("display","none");
	$("#block2").css("display","none");
            
    $(".question0").click(function(){
    	if ($('input[name=age]:checked').val() == "underage" ) {
        	$("#blockage").slideUp("fast"); //Slide Down Effect   
        	$("#blockexit").slideDown("fast");	//Slide Up Effect
        } else {
            $("#blockage").slideUp("fast"); //Slide Down Effect  
            $("#block1").slideDown("fast");	//Slide Up Effect
            $("#block2").slideDown("fast");	//Slide Up Effect
        }
     });
     
     
    $(".question7").click(function(){
    	if ($('input[name=student]:checked').val() == "Yes" ) {
        	$("#majorfield").slideDown("fast"); //Slide Down Effect   
        } else {
            $("#majorfield").slideUp("fast");	//Slide Up Effect
        }
     });            
});
