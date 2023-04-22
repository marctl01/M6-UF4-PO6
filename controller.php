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
        $v1 = $_POST['v1'];
        $v2 = $_POST['v2'];
        $v3 = $_POST['v3'];

        // $query = $db->prepare("UPDATE tencuestas SET textoanuncio= :ta WHERE codencuesta= :id");
        $query = $db->prepare("UPDATE tencuestas SET textoencuesta= :tenc, opcion1= :o1, opcion2= :o2, opcion3= :o3, votosop1= :v1, votosop2= :v2, votosop3= :v3  WHERE codencuesta = :id;");
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
