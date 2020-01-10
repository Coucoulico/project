$(function(){
  $('html , body').animate({scrollTop:100}, 'slow');
})
//suppression et ajout au panier
$(function(){
  $(".reservation").click(function(){
   var spectacle=spectacleOf($(this).closest('.spectacl-container'));
   var action;
   $(this).animate({
    opacity:'-=0.9'
  },1000,function(){
    var t=$(this).text().trim();
    var c=$(this);
    if(t=="retirer de mon panier"){
      var action = "delete";
      c.text("ajouter à mon panier");
    }
    else{
      var action = "add";

      $.ajax({
        url: "/php/ajax/panier.php",
        type:"GET",
        data:data,

        success: function(msg){  
          console.log(msg);
          if(msg['spectacles']==12){
          } 
          else {
            c.text("retirer de mon panier");
            
          }
        },
        dataType:'JSON',
      });
      
    }
    $(this).animate({
      opacity:'+=1',
    },1000);
    var data={action:action,spectacle:spectacle};
    updatepanier(data);

  })
 })
});


//suppression à partir du panier
$(function(){
  $(".reservation-container .reservation").click(function(){
    $(this).closest(".reservation-container").hide(2000,function(){
      $(this).remove();
      if($(".reservation-container").length==0) {
        location.href="/index.php";

      } 
    });
  }
  )
  
})

//suppression à partir des conflits
$(function(){
  $(".container-conflit .reservation").click(function(){

    var c=$(this).closest(".container-conflit");
    var spectacle=spectacleOf($(this).closest(".spectacl-container"));
    c.hide(2000,function(){
      $(this).remove();
    }); 
    $(".container-conflit").find(".spectacl-container").each(function(){
      if(are_equals(spectacle,spectacleOf($(this)))){
        $(this).closest('.container-conflit').hide(2000,function(){
          $(this).remove();
        }); 
      }
    });
    $(".reservation-container").find(".spectacl-container").each(function(){
     console.log(spectacleOf($(this)));
     if(are_equals(spectacle,spectacleOf($(this)))){
      $(this).closest('.reservation-container').hide(2000,function(){
        $(this).remove();
      }); 
    }

  });
    

  })
}
)

//ignorer un conflit
$(function(){
  var s;
  $(".ignore-conflit").click(function(){
    var t=[];
    var c=$(this).closest('.container-conflit').find(".spectacl-container").each(function(){
      t.push(spectacleOf($(this)));
    });
    ignore_conflit(t);
    $(this).hide(2000,function(){
      $.ajax({
        url: "/php/ajax/panier.php",
        type:"GET",
        success: function(msg){  
          console.log(msg);
          if(msg['conflits']==0) {
            $('#container-conflits').hide(2000);
            $("#container-res").css("-webkit-filter","blur(0px)");
            $("#container-res").find("*").prop( "disabled", false );
            $("#facturation").css("box-shadow","2px 2px 2px 2px green");

          }
        },
        dataType:'JSON',
      });
    });

  })
})

// les select du nombre de billets par spectacle
$(function(){
  $("select").change(function(){
   var spec=spectacleOf($(this).closest('.reservation-container').children('.spectacl-container'));
   var action='update';
   var x=$(this).closest('.info-categories').find('option:selected').map(function(){
    return $(this).val();
  });
   var tarifs={plein:x[0],reduit:x[1],enfant:x[2]};
   data={action:action,spectacle:spec,tarifs:JSON.stringify(tarifs)};
   updatepanier(data,function(){
    location.href="/php/rooters/rooterAffichage.php?action=panier";
  });
 });
  
});


$(function(){
  $("#facturation").click(function(){
    $.ajax({
      url: "/php/ajax/panier.php",
      type:"GET",
      success: function(msg){  
        console.log(msg);
        if(msg['conflits']>0) {
          showConflits();
          $('html , body').animate({scrollTop:50}, 'slow');
        }
        else location.href="/php/rooters/rooterAffichage.php?action=facturation";

      },
      dataType:'JSON',
    });


  })
})

//ignorer tous les conflits
$(function(){
  $("#ignore-all").click(function(){
    $.ajax({
      url: "/php/ajax/panier.php",
      type:"POST",
      data:{action:'ignore-all'},

      success: function(msg){  
        console.log(msg);
        $('#container-conflits').hide(2000);
        $("#container-res").css("-webkit-filter","blur(0px)");
        $("#facturation").css("box-shadow","2px 2px 2px 2px green");
      },
      dataType:'JSON',
    });

  })
})

$(function(){
  $.ajax({
    url: "/php/ajax/panier.php",
    type:"GET",
    success: function(msg){  
      console.log(msg);
      if(msg['conflits']==0) {
        $("#facturation").css("box-shadow","2px 2px 2px 2px green");
      }

    },
    dataType:'JSON',
  });

})


function showConflits(){
  $("#container-res").css("-webkit-filter","blur(10px)");
  $("#container-conflits").show(1000);
  $("#container-res").click(function(){
    $('#container-conflits').hide(2000);
    $("#container-res").css("-webkit-filter","blur(0px)");

  })

}



function updatepanier(data,callback){
 $.ajax({
  url: "/php/ajax/panier.php",
  type:"POST",
  data:data,

  success: function(msg){  
    console.log(msg);
    if(msg['spectacles']>0) $("#nb-spectacle").text(msg['spectacles']);
    else $("#nb-spectacle").text("");
    callback();
  },
  dataType:'JSON',
});
}

function ignore_conflit(c){
  $.ajax({
    url: "/php/ajax/panier.php",
    type:"POST",
    data:{action:'ignore',data:c},

    success: function(msg){  
      console.log(msg);
    },
    dataType:'JSON',
  });
}
function spectacleOf(container){
  var date=container.find('date').text().trim();
  var heure=container.find('heure').text().trim();
  var titre=container.find('titre').text().trim();
  var salle=container.find('salle').text().trim();
  var lieu=container.find('lieu').text().trim();
  var compagnie=container.find('compagnie').text().trim();
  var spectacle={titre:titre,date:date.concat(' ',heure),
  salle:{nom:salle,village:lieu},compagnie:compagnie};
  return spectacle;

}

function are_equals(s1,s2){
  if(s1['date']!=s2['date']) return false;
  if(s1['compagnie']!=s2['compagnie']) return false;
  return  true;
  
}

