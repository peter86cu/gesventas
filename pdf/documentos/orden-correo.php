<?php
	/*-------------------------
	Autor: Obed Alvarado
	Web: obedalvarado.pw
	Mail: info@obedalvarado.pw
	---------------------------*/
	 ob_start();
	
	/* Connect To Database*/
	include("../../config/db.php");
	include("../../config/conexion.php");
	include("../../config/conexionEnvioMail.php");
	
	
	require_once(dirname(__FILE__).'/../html2pdf.class.php');
		
	//Variables por GET
	$orden=intval($_POST['idOrden']);
	

	//Fin de variables por GET
	/*$sql=mysqli_query($con, "select LAST_INSERT_ID(id) as last from ordenes order by id desc limit 0,1 ");
	$rw=mysqli_fetch_array($sql);
	$numero=$rw['last']+1;*/	
	/*$perfil=mysqli_query($con,"select * from perfil limit 0,1");//Obtengo los datos de la emprea
	$rw_perfil=mysqli_fetch_array($perfil);*/

	$perfil=mysqli_query($con,"select * from perfil limit 0,1");//Obtengo los datos de la emprea
	$rw_perfil=mysqli_fetch_array($perfil);


	$sql_datos=mysqli_query($con,"SELECT  oc.id_orden_compra, fp.descripcion pago,pl.descripcion envio,u.nombres from ordenes_de_compras oc, ordenes_de_compras_detalle od , formas_pagos fp, plazos pl , ordenes_compras_modificaciones om, usuarios u
          where oc.id_orden_compra=od.id_orden_compra and oc.id_forma_pago=fp.id_forma_pago and pl.id_plazo = oc.id_plazo and om.id_orden_compra=oc.id_orden_compra and u.id_usuario=om.id_usuario_autorizo and oc.id_orden_compra=".$orden." limit 0,1");//Obtengo los datos del proveedor

	$sql_cliente= mysqli_query($con,"select p.* from proveedores p, ordenes_de_compras oc where oc.id_proveedor=p.id_proveedor and oc.id_orden_compra=".$orden." limit 0,1");

	$rw_cliente=mysqli_fetch_array($sql_cliente);
			$condiciones="";
			$envio="";
			$orden="";
			$aprobado="";
    while($row=mysqli_fetch_array($sql_datos)){
    	
			$condiciones=$row['pago'];
			$envio=$row['envio'];
			$orden=$row['id_orden_compra'];
			$aprobado=$row['nombres'];
			
    }    
     include(dirname('__FILE__').'/res/orden_html.php');
    $content = ob_get_clean();
    $directorio="C:/xampp/htdocs/gesventas/vistas/recursos/dist/ordenesEnviadas/";
    try
    {
        
    	$id=uniqid() ;
        // init HTML2PDF
        $html2pdf = new HTML2PDF('P', 'LETTER', 'es', true, 'UTF-8', array(0, 0, 0, 0));
        // display the full page
        $html2pdf->pdf->SetDisplayMode('fullpage');
        // convert
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
       
        $html2pdf->Output($directorio.'orden'.$orden.'.pdf', 'F'); //guarda a ruta

        $fichero='orden'.$orden.'.pdf';

        if( mysqli_query($conexion,"INSERT INTO `mail_sent`(`datemail`, `id_usuario`,  `estado`, `accion`, `id_mail`) VALUES ('".time()."','".$_SESSION['id']."',0,6,'".$id."')")){

       if( mysqli_query($conexion,"INSERT INTO fichero_adjuntos( `id_usuario`, `nombre`, `tipo`, `size`, `direccion`, `estado`,id_mail) VALUES ('".$_SESSION['id']."','".$fichero."','pdf',0,'".$directorio."',5,'".$id."')")){

       if(isset($_SESSION['adjunto_mail'])){
       	unset($_SESSION['adjunto_mail']);
       }else{
       	$_SESSION['accion_mail']='enviar_adjunto';
       	$_SESSION['id_new_mail']=$id;
       	$_SESSION['archivo']='mostrar';
       }
       echo json_encode(true);
       }else{
       	echo json_encode(false);
       }

    }

    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
