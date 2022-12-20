<?php

require_once('CreateDB.php');

$db_productos = new CreateDB(
    "ladistribuidora",
    "productos",
    "localhost",
    "root",
    "",
    "CREATE TABLE IF NOT EXISTS productos
    (id INT(10)NOT NULL AUTO_INCREMENT PRIMARY KEY,
    producto VARCHAR(100) NOT NULL,
    presentacion VARCHAR(100) NOT NULL,
    precio INT(6) NOT NULL,
    marca VARCHAR(100) NOT NULL,
    img VARCHAR(500) NOT NULL);"
  );

$producto = $_POST['producto'];
$presentacion = $_POST['presentacion'];
$marca = $_POST['marca'];
$precio = $_POST['precio'];

// Tratamiento imagen
if( isset($_FILES['img'])){
    $img_name = $_FILES['img']['name'];
    $img_size = $_FILES['img']['size'];
    $tmp_name = $_FILES['img']['tmp_name'];
    $error = $_FILES['img']['error'];

    if($error === 0){
        if($img_size > 150000){
            $em = "La imagen es demasiado pesada";
            header("Location: ../index.php?error=$em");
        } else {
            $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
            $img_ex_lc = strtolower($img_ex);
            $allowed_ex = array("jpg","jpeg","png","jfif");
            if( in_array($img_ex_lc, $allowed_ex) ){
                $new_img_name = uniqid("IMG-",true).'.'.$img_ex_lc;
                $img_upload_path = "../uploads/".$new_img_name;
                move_uploaded_file($tmp_name, $img_upload_path);

            } else {
                $em = "No se pueden cargar imagenes con esta extensión";
                header("Location: ../index.php?error=$em");        
            }
        }
    } else { 
        $em = "Ocurrió un error inesperado con la imagen";
        header("Location: ../index.php?error=$em");
    }
} else {
    echo "NONO";
}

$db_productos->insertProduct($producto, $presentacion, $marca, $precio, $new_img_name);

?>