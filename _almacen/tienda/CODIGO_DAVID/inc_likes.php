<?php
function creaLikes($id,$valoracion){ //recibe el id del producto y la valoracion
    $devuelve = '';

    // ternarios en los que se prepara la imagen que hay que mostrar y su texto alternativo (alt)
    $img_like = ($valoracion == 1 ? 'like_activo.png' : 'like_inactivo.png');
    $img_dislike = ($valoracion == 2 ? 'dislike_activo.png' : 'dislike_inactivo.png');
    $alt_img_like = ($valoracion == 1 ? 'Me gusta (seleccionado)' : 'Me gusta (no seleccionado)');
    $alt_img_dislike = ($valoracion == 2 ? 'No me gusta (seleccionado)' : 'No me gusta (no seleccionado)');

    // genera el html que ajax va a rellenar en el div con el $c_likes
    $devuelve.= "<div>";
        $devuelve.= "<img src='img/$img_like' alt='$alt_img_like' class='megusta' data-item-valoracion='1' data-producto-id='$id' width='30'>"; //aqui creo los atributos para pasarle a js el id del producto y la valoracion, dandole valores, 1 si es me gusta
        $devuelve.= "<img src='img/$img_dislike' alt='$alt_img_dislike' class='nomegusta' data-item-valoracion='2' data-producto-id='$id' width='30'>"; //aqui creo los atributos para pasarle a js el id del producto y la valoracion, dandole valores, 2 si es no me gusta
    $devuelve.= "</div>";

    return $devuelve; // devuelvo el resultado que he creado en el bloque anterior
}