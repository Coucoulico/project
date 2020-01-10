var c = document.getElementById("canvas");
var context = c.getContext("2d");
H=0.9*c.clientHeight;
W=0.9*c.clientWidth;
console.log("H= "+H+"W= "+W);

var couleur={"P":'red',"R":'orange',"O":'blue',"SJ":'green',"SA":'pink',"E":'yellow'};
var designation={"P":'tarif plein',"R":'tarif reduit',"O":'billet Offert',"SJ":'invitation speciale',"SA":'sur invitation',"E":'tarif enfant'};


init_legend=function(){
	$.each(designation,function(k,v){
		$("#legende").append("<li style=background-color:"+couleur[k]+"; width: 10px;border-radius: 5%;"+">"+"</li>"+v+"  .  ");
	})
}	
init_legend();		

init_graph=function(action="dates"){

	context.clearRect(0, 0, c.width, c.height);
	$.ajax({
		url: "/php/ajax/finance.php",
		type:"POST",
		data:{strategy: action},
		success: function(d){  
			max=Object.values(d).reduce((acc,elt)=>{
				tmp=Object.values(elt).reduce((a,e)=>a+e);
				if(acc>tmp) return acc;
				else return tmp;
			},1);
			nb_item=Object.keys(d).length;
			dx=W/(2*nb_item);
			x0=0.025*c.clientWidth;
			x=x0;
			y=H-0.1*c.clientHeight;
			xp=0;
			$(function(){
				context.fillStyle='black';
				context.font="8px";
				context.beginPath();
				context.moveTo(x0-5,10);
				context.lineTo(x0-5, H-0.1*c.clientHeight);
				context.stroke();
				context.fillText(max,1,8);
				
				$.each(d,function(e,elt){
					$.each(elt,function(k,v){

						context.fillStyle=couleur[k];
						dy=H*(v/max);
						y-=dy;

						context.fillRect(x,y,0.6*dx,dy);

					});
					var t = $("<span></span>").text(e);
					t.css('display','inline-block');
					t.css('margin','auto');
					$("#headers").prepend(t);

					x+=dx;
					xp+=dx;
					y=H-0.1*c.clientHeight;

				});
				$("#headers span").css("overflow",'hidden');
				$("#headers span").css("border-top",'0px');
				$("#headers span").css("font-size",12);
				$("#headers span").css("background-color" ,"#F5F5F5");
				$("#headers span").css('transform' ,"skewY(-30deg)");
			})
		},
		dataType:'JSON',
	});
}

init_titre_graph=function(){$(function(){
	var s="recettes et depense du Festival par "
	s+=$("select option:selected").text();
	$("#titre-graph").text(s);


});
}
init_titre_graph();
init_graph();

$("select").change(function(){
	$("#headers *").remove();
	strategy=$(this).find("option:selected").text();
	init_graph(strategy);
	init_titre_graph();
})




