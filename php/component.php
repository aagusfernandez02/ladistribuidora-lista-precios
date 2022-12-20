<?php
function component($srcImg, $producto, $presentacion, $precio){
    if( isset($_SESSION['admin']) AND $_SESSION['admin']==true ){
        $element = '
        <tr>
            <th scope="row" class="col-img">
                <img class="img-producto" src="'.$srcImg.'" alt="'.$producto.'">
            </th>
            <td>'.$producto.'</td>
            <td>'.$presentacion.'</td>
            <td>$'.$precio.'</td>
            <td class="col-control-icon"><a href="#"><i class="fa-solid fa-pen-to-square control-icon icon-edit"></i></a></i></td>
            <td class="col-control-icon"><a href="#"><i class="fa-solid fa-trash-can control-icon icon-delete"></i></a></i></td>
        </tr>
        ';
    } else {
        $element = '
        <tr>
            <th scope="row" class="col-img">
                <img class="img-producto" src="'.$srcImg.'" alt="'.$producto.'">
            </th>
            <td>'.$producto.'</td>
            <td>'.$presentacion.'</td>
            <td>$'.$precio.'</td>
        </tr>
        ';       
    }
    echo $element;
}

?>