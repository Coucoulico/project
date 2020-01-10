$(function(){
	$("#titre-spectacl span").click(function(){
		$(".shown").animate({
			opacity:'-=0.8'   
		});

	});

});


$(function(){
	$(".oflieu").click(function(){
		var x=$('.info-spectacl');
		var y=$(this);
		y.animate({
			opacity:'-=1'
		},2000,function(){
			x.hide();
			exchange(x.find('lieu'),y.find('lieu'));
			exchange(x.find('date'),y.find('date'));
			exchange(x.find('heure'),y.find('heure'));
			exchange(x.find('compagnie'),y.find('compagnie'));
			exchange(x.find('salle'),y.find('salle'));
			$(".oflieu").animate({
				opacity:'+=1'
			},1000);
			x.show(1500);
			
		})
		
		

	});
})

function exchange(x,y){
	var t1=x.text();
	var t2=y.text();
	x.text(t2);
	y.text(t1);
}


$(function(){
	$("#panier").click(function(){
		$.ajax({
			url: "/php/ajax/panier.php",
			type:"GET",
			success: function(msg){  
				console.log(msg);
				if(msg['spectacles']>0) location.href="/php/rooters/rooterAffichage.php?action=panier";
			},
			dataType:'JSON',
		});
		
	})
})

$(function(){
	$('.more-info').hover(function(){
		$('.description').show(2000);
	})
})

$(function(){
	$('#more').mouseleave(function(){
		$('.description').hide(1000);
	})
	
})
$(function(){
	$('.description').mouseenter(function(){
		$(this).show(50);
	})
})



$(function(){
	$.ajax({
		url: "/php/ajax/panier.php",
		type:"GET",
		success: function(msg){  
			console.log(msg);
			if(msg['spectacles']>0) $("#nb-spectacle").text(msg['spectacles']);
			else $("#nb-spectacle").text("");
		},
		dataType:'JSON',
	});
})


$(function(){
	$('.programmes').click(function(){
		console.log("coucocu");
		$.ajax({
			url: "/php/ajax/dateDebut.php",
		type:"GET",
		success: function(msg){  
			console.log(msg);
			location.href="/php/rooters/rooterAffichage.php?action=affichage&date="+msg;
		},
		})
	})
})

$(function(){
	$("#accueil").click(function(){
		location.href="/";
	})
})

