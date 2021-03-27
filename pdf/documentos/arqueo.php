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
	
	
	require_once(dirname(__FILE__).'/../html2pdf.class.php');
		
	//Variables por GET
	$id_apertura=intval($_GET['idApertura']);
	$id_arqueo=intval($_GET['idArqueo']);
	$id_tipo_arqueo= intval($_GET['id_tipo_arqueo']);

	$perfil=mysqli_query($con,"select * from perfil limit 0,1");//Obtengo los datos de la emprea
	$rw_perfil=mysqli_fetch_array($perfil);


	
	$sql_inicio=mysqli_query($con,"select sum(ad.valor*b.monto) saldo_apertura_inicial,ac.fecha_inicio, u.usuario from arqueos ar , arqueos_detalle ad , billetes b, aperturas_cajeros ac, usuarios u where ac.id_apertura_cajero=ar.id_apertura_cajero and ar.id_arqueo=ad.id_arqueo and ad.id_billete=b.id_billete and ar.id_estado_arqueo=1 and u.id_usuario=ac.id_usuario and ac.id_apertura_cajero=".$id_apertura." ");

	$sql_ventas= mysqli_query($con,"select sum(v.monto_total) monto_total from ventas v, ventas_cobros vc where v.id_venta= vc.id_venta and v.estado=2 and vc.id_forma_cobro= 1 and v.id_apertura_cajero='".$id_apertura."'");
		$saldo_inicial=0;
		$saldo_ventas=0;
		$apertura=0;
		$fecha_inicio="";
		$usuario="";
	 while($row=mysqli_fetch_array($sql_ventas)){    	
			$saldo_ventas=$row['monto_total'];		
			
    }  
    while($row=mysqli_fetch_array($sql_inicio)){    	
			$saldo_inicial=$row['saldo_apertura_inicial'];
			$fecha_inicio=$row['fecha_inicio'];	
			$usuario=$row['usuario'];		
			
    }  
    if($id_tipo_arqueo!=1){
    	$apertura = $saldo_inicial + $saldo_ventas;
    }else{
    	$apertura = $saldo_inicial ;
    }
    
     include(dirname('__FILE__').'/res/arqueo_html.php');
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
