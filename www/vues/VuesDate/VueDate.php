
<?php 
require($_SERVER['DOCUMENT_ROOT']."/vues/VuesSpectacle/VueSpectacle.php");
?>
<?php ob_start(); ?>

<?php $date=$date->jsonSerialize();?>
<div class="container-global">
  <div id="date" class="titre-global">
    <svg 
    xmlns:dc="http://purl.org/dc/elements/1.1/"
    xmlns:cc="http://creativecommons.org/ns#"
    xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
    xmlns:svg="http://www.w3.org/2000/svg"
    xmlns="http://www.w3.org/2000/svg"
    xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd"
    xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape"
    width="22"
    height="22"
    viewBox="0 0 5.8208332 5.8208335"
    version="1.1"
    id="precedent"
    inkscape:version="0.92.2 (5c3e80d, 2017-08-06)"
    sodipodi:docname="go-previous.svg">
    <defs
    id="defs2" />
    <sodipodi:namedview
    id="base"
    pagecolor="#ffffff"
    bordercolor="#666666"
    borderopacity="1.0"
    inkscape:pageopacity="0.0"
    inkscape:pageshadow="2"
    inkscape:zoom="11.313708"
    inkscape:cx="7.8305055"
    inkscape:cy="11.593276"
    inkscape:document-units="mm"
    inkscape:current-layer="layer1"
    showgrid="true"
    units="px"
    inkscape:window-width="1360"
    inkscape:window-height="718"
    inkscape:window-x="0"
    inkscape:window-y="24"
    inkscape:window-maximized="1">
    <inkscape:grid
    type="xygrid"
    id="grid10" />
  </sodipodi:namedview>
  <metadata
  id="metadata5">
  <rdf:RDF>
  <cc:Work
  rdf:about="">
  <dc:format>image/svg+xml</dc:format>
  <dc:type
  rdf:resource="http://purl.org/dc/dcmitype/StillImage" />
  <dc:title></dc:title>
</cc:Work>
</rdf:RDF>
</metadata>
<g
inkscape:label="Capa 1"
inkscape:groupmode="layer"
id="layer1"
transform="translate(0,-291.17915)">
<path
style="fill:none;stroke:#6e7684;stroke-width:1;stroke-linecap:butt;stroke-linejoin:round;stroke-opacity:1;stroke-miterlimit:4;stroke-dasharray:none"
d="m 2.9104167,292.23748 -2.11666671,1.85209 2.11666661,2.11666"
id="path12"
inkscape:connector-curvature="0"
sodipodi:nodetypes="ccc" />
<path
sodipodi:nodetypes="ccc"
inkscape:connector-curvature="0"
id="path822"
d="M 5.2916667,292.23748 3.175,294.08957 l 2.1166666,2.11666"
style="fill:none;stroke:#6e7684;stroke-width:1;stroke-linecap:butt;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:0.52147239" />
</g>
</svg>
<p><date><?=$date['jour']?></date></p> 
<svg
xmlns:dc="http://purl.org/dc/elements/1.1/"
xmlns:cc="http://creativecommons.org/ns#"
xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
xmlns:svg="http://www.w3.org/2000/svg"
xmlns="http://www.w3.org/2000/svg"
xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd"
xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape"
width="22"
height="22"
viewBox="0 0 5.8208332 5.8208335"
version="1.1"
id="suivant"
inkscape:version="0.92.2 (5c3e80d, 2017-08-06)"
sodipodi:docname="go-next.svg">
<defs
id="defs2" />
<sodipodi:namedview
id="base"
pagecolor="#ffffff"
bordercolor="#666666"
borderopacity="1.0"
inkscape:pageopacity="0.0"
inkscape:pageshadow="2"
inkscape:zoom="8"
inkscape:cx="17.486803"
inkscape:cy="2.7831783"
inkscape:document-units="mm"
inkscape:current-layer="layer1"
showgrid="true"
units="px"
inkscape:window-width="1360"
inkscape:window-height="718"
inkscape:window-x="0"
inkscape:window-y="24"
inkscape:window-maximized="1">
<inkscape:grid
type="xygrid"
id="grid10" />
</sodipodi:namedview>
<metadata
id="metadata5">
<rdf:RDF>
<cc:Work
rdf:about="">
<dc:format>image/svg+xml</dc:format>
<dc:type
rdf:resource="http://purl.org/dc/dcmitype/StillImage" />
<dc:title></dc:title>
</cc:Work>
</rdf:RDF>
</metadata>
<g
inkscape:label="Capa 1"
inkscape:groupmode="layer"
id="layer1"
transform="translate(0,-291.17915)">
<g
id="g856"
transform="matrix(-1,0,0,1,5.9389926,0)">
<path
sodipodi:nodetypes="ccc"
inkscape:connector-curvature="0"
id="path12"
d="m 2.9104167,292.23748 -2.11666671,1.85209 2.11666661,2.11666"
style="fill:none;stroke:#6e7684;stroke-width:1;stroke-linecap:butt;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1" />
<path
style="fill:none;stroke:#6e7684;stroke-width:1;stroke-linecap:butt;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:0.52147241"
d="M 5.2916667,292.23748 3.175,294.08957 l 2.1166666,2.11666"
id="path822"
inkscape:connector-curvature="0"
sodipodi:nodetypes="ccc" />
</g>
</g>
</svg>
</div>



<?php foreach ($spectacles as $lieu=>$spectaclofLieu) {?>
  <div class="container-section">
    <p class="titre-section">à <lieu><?=$lieu?></lieu>
      <span class="allOfLieu">voir tout les spectacle de ce lieu.</span>
    </p>
    <div class="section-content">
        <?php foreach ($spectaclofLieu as $spectacl) {
          afficherSpectacle($spectacl,$panier);}?>
   </div>
 </div>
 
<?php } ?>

</div>
</div>
<?php $content = ob_get_clean(); ?>
<?php require('templateVueDate.php');