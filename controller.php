<?php
require("conexionpdo.php");

$f = $_POST['function'];
$response = array();


switch ($f) {
    case 'create':
        array_push($response, "Create");
        
        $tenc = $_POST['textoencuesta'];
        $o1 = $_POST['opcion1'];
        $o2 = $_POST['opcion2'];
        $o3 = $_POST['opcion3'];
        
        $query = $db->prepare("INSERT INTO tencuestas (textoencuesta, opcion1, opcion2, opcion3) VALUES ( :te, :o1, :o2, :o3)");
        $query->execute(['te'=>$tenc, 'o1'=>$o1, 'o2'=>$o2, 'o3'=>$o3]); 

        echo json_encode($response);
        break;

    case 'read':
        $stmt = $db->prepare("SELECT * FROM tencuestas ORDER BY codencuesta ASC");
        $stmt->execute();
        $anuncios = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $response["data"] = $anuncios;

        echo json_encode($response);
        break;

    case 'read_id':
        $id =$_POST['id'];
        $query = $db->prepare("SELECT * FROM tencuestas WHERE codencuesta = :id");
        $query->execute(['id'=> $id]);
        $anuncios = $query->fetchAll(PDO::FETCH_ASSOC);


        
        
        $v1n = $anuncios[0]['votosopc1'];
        $v2n = $anuncios[0]['votosopc2'];
        $v3n = $anuncios[0]['votosopc3'];

        $total = $v1n + $v2n + $v3n;

        if($total > 0){
        $v1 = ($v1n / $total) * 100;
        $v2 = ($v2n / $total) * 100;
        $v3 = ($v3n / $total) * 100;
        }else{
        $v1 = 0;
        $v2 = 0;
        $v3 = 0;
        }


        $anuncios[0]['votosopc1g'] = round($v1);
        $anuncios[0]['votosopc2g'] = round($v2);
        $anuncios[0]['votosopc3g'] = round($v3);



        $response["data"] = $anuncios;




        echo json_encode($response);
        break;

    case 'delete':
        array_push($response, "Delete");
        $id =$_POST['id'];
        $query = $db->prepare("DELETE FROM tencuestas WHERE codencuesta = :id");
        $query->execute(['id'=> $id]); 

        echo json_encode($response);
        break;
        
    case 'update':
        array_push($response, "Update");

        $id = $_POST['id'];
        $tenc = $_POST['textoencuesta'];
        $o1 = $_POST['o1'];
        $o2 = $_POST['o2'];
        $o3 = $_POST['o3'];
        $v1 = $_POST['votosopc1'];
        $v2 = $_POST['votosopc2'];
        $v3 = $_POST['votosopc3'];

        // $query = $db->prepare("UPDATE tencuestas SET textoanuncio= :ta WHERE codencuesta= :id");
        $query = $db->prepare("UPDATE tencuestas SET textoencuesta= :tenc, opcion1= :o1, opcion2= :o2, opcion3= :o3, votosopc1= :v1, votosopc2= :v2, votosopc3= :v3  WHERE codencuesta = :id;");
        $query->execute(['id'=> $id, 'tenc'=> $tenc, 'o1'=>$o1, 'o2'=>$o2, 'o3'=>$o3, 'v1'=>$v1, 'v2'=>$v2, 'v3'=>$v3 ]); 
        echo json_encode($response);
        
        break;

    case 'update_vote':
        array_push($response, "Update vote");

        $id = $_POST['id'];
        $opcion = $_POST['opcion'];

        // $query = $db->prepare("UPDATE tencuestas SET textoanuncio= :ta WHERE codencuesta= :id");
        $query = $db->prepare("UPDATE tencuestas SET $opcion = $opcion + 1 WHERE codencuesta = :id;");
        $query->execute(['id'=> $id ]); 
        
        
        echo json_encode($response);
        break;
    
    default:
        array_push($response, "msnj", "Error");
        echo json_encode($response);
        break;
}
