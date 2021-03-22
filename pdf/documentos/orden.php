<?php
	/*-------------------------
	Autor: Obed Alvarado
	Web: obedalvarado.pw
	Mail: info@obedalvarado.pw
	---------------------------*/
	 ob_start();
	session_start();
	/* Connect To Database*/
	include("../../config/db.php");
	include("../../config/conexion.php");
	
	
	require_once(dirname(__FILE__).'/../html2pdf.class.php');
		
	//Variables por GET
	$orden=intval($_GET['idOrden']);
	

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

    try
    {
        // init HTML2PDF
        $html2pdf = new HTML2PDF('P', 'LETTER', 'es', true, 'UTF-8', array(0, 0, 0, 0));
        // display the full page
        $html2pdf->pdf->SetDisplayMode('fullpage');
        // convert
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        // send the PDF
        $html2pdf->Output('orden.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
