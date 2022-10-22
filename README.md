# annonces

coucou les loulous
test

test 2



<?php


 $listePhoto=[];

foreach($params['listeChemin'] as $photo) {

    $listePhoto[]= $photo->chemin;

  

//  print_r($listePhoto)   ;


} 

$listePhoto=implode('" , "',$listePhoto );


$listePhoto.='"';

$listePhoto= substr_replace($listePhoto, '"', 0, 0); 

print_r($listePhoto);

?>
