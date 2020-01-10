<?php ob_start(); ?>
<div class="container-global">
  <div class="titre-global">
    <p >Statistique et finance</p>    
  </div>
  <select id="by-strategy">
  	<option value="dates" selected="selected">dates</option>
  	<option value="compagines">compagnies</option>
  	<option value="lieux">lieux</option>
  </select>
  <div id="container-canvas">
  	<ul id="legende">
  		
  	</ul>
  <canvas id="canvas">
    
  </canvas>	
  <div id="headers">
  	
  </div>
  
  <div id="titre-graph">
  	</span>
  </div>
  </div>
  
</div>
<?php $content = ob_get_clean(); ?>
<?php require('templateVueFinance.php');?>