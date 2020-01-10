$(function () {
    		// body...
    		$("#suivant").click(function(){
    			var date=$(this).siblings("p").find("date").text();
                $(this).siblings("p").find("date").animate({
                    opacity: '0.2',
                },1000,function(){
                        $.get("/php/ajax/DateDebut.php?date="+date,function(dateFin){
                    if(date==dateFin){
                        $("#suivant").css('opacity','0');
                        $(this).prop( "disabled", true );
                        $("#precedent").css('opacity','1').prop( "disabled", false );;
                    }  
                    else{
                        location.href="/php/rooters/rooterAffichage.php?action=affichage&date="+dateFin;
                    }
                    

                    
                });
                });
    		
    		})
    	})

$(function () {
    		// body...
    		$("#precedent").click(function(){
    			var date=$(this).siblings("p").find("date").text();
                $(this).siblings("p").find("date").animate({
                    opacity: '0.5',

                },1000);
    			$.get("/php/ajax/DateFin.php?date="+date,function(dateDebut){
                    if(date==dateDebut){
                        $("#precedent").css('opacity','0');
                        $("#suivant").css('opacity','1');
                    }
                    else{
                        location.href="/php/rooters/rooterAffichage.php?action=affichage&date="+dateDebut;
                    }
    				

                });
    		})
    	})


$(".allOfLieu").on('click',function(){
    var lieu=$(this).parent().children('lieu').text();
    $.get("/php/controllers/controllerLieu.php",{pourlieu:lieu},
        function(data){
              location.href="/php/rooters/rooterAffichage.php?action=affichage&pourlieu="+lieu;
        });
    
})


$(".allOfDate").on('click',function(){
    var date=$(this).parent().children('date').text();
    location.href="/php/rooters/rooterAffichage.php?action=affichage&date="+date;
})


$(".titre-spectacl").on('click',function(){
    var titre=$(this).children('titre').text();
    location.href="/php/rooters/rooterAffichage.php?action=affichage&nom="+titre;
})



     
     




     