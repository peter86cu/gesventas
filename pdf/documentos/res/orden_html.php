<style type="text/css">
<!--
table { vertical-align: top; }
tr    { vertical-align: top; }
td    { vertical-align: top; }

.text-center{
	text-align:center
}
.text-right{
	text-align:right
}
table th, td{
	font-size:13px
}
.detalle td{
	border:solid 1px #bdc3c7;
	padding:5px;
}
.items{
	border:solid 1px #bdc3c7;
	 
}
.items td, th{
	padding:10px;
}
.items th{
	background-color: #c0392b;
	color:white;
	
}
.border-bottom{
	border-bottom: solic 1px #bdc3c7;
}
table.page_footer {width: 100%; border: none; background-color: white; padding: 2mm;border-collapse:collapse; border: none;}
}
-->
</style>
<page backtop="15mm" backbottom="15mm" backleft="15mm" backright="15mm" style="font-size: 12pt; font-family: arial" >
        <page_footer>
        <table class="page_footer">
            <tr>

                <td style="width: 50%; text-align: left">
                    P&aacute;gina [[page_cu]]/[[page_nb]]
                </td>
                <td style="width: 50%; text-align: right">
                    &copy; <?php echo "mipagina.com "; echo  $anio=date('Y'); ?>
                </td>
            </tr>
        </table>
    </page_footer>
    <table cellspacing="0" style="width: 100%;">
        <tr>

            <td  style="width: 33%; color: #444444;">
               
                
            </td>
			<td style="width: 34%;">
			<strong>E-mail : </strong> <?php echo $rw_perfil['email'];?><br>
			<strong>Teléfono : </strong> <?php echo $rw_perfil['telefono'];?><br>
			<strong>Sitio web : </strong> <?php echo $rw_perfil['web'];?><br>
			</td>
			<td style="width: 33%;">
				<strong><?php echo $rw_perfil['nombre_comercial'];?> </strong> <br>
				<strong>Dirección : </strong> <?php echo $rw_perfil['direccion'];?><br>
		
			</td>
			
        </tr>
    </table>
    <br>
	<hr style="display: block;height: 1px;border: 1.5px solid #c0392b;    margin: 0.5em 0;    padding: 0;">
	<table cellspacing="0" style="width: 100%;">
        <tr>

            <td  style="width: 10%; ">               
            </td>
			<td style="width: 80%;text-align:center;font-size:22px;color:#c0392b;padding:10px; border-radius: 5px; ">
				ORDEN DE COMPRA 
			</td>
			
			
        </tr>
    </table>
	
	<br>
	<table cellspacing="0" style="width: 100%;">
        <tr>

            <td  style="width: 60%; "> 
				
			</td>
			<td  style="width: 20%;color:white;background-color:#c0392b;padding:5px;text-align:center "> 
				<strong style="font-size:14px;" >ORDEN #</strong>
			</td>
			<td  style="width: 20%; color:white;background-color:#c0392b;padding:5px;text-align:center " > 
				<strong style="font-size:14px;">FECHA</strong>
			</td>
		</tr>
		
		<tr>

            <td  style="width: 60%; "> 
				
			</td>
			<td  style="width: 20%;padding:5px;text-align:center;border:solid 1px #bdc3c7;font-size:15px"> 
				<?php echo $orden;?>
			</td>
			<td  style="width: 20%;padding:5px;text-align:center;border:solid 1px #bdc3c7;font-size:15px " > 
				<?php echo date("d/m/Y");?>
			</td>
		</tr>

    </table>
	
	<br>
	<table cellspacing="0" style="width: 100%;" class="detalle">
        <tr>

            <td  style="width: 50%; "> 
				<strong style="font-size:18px;color:#2c3e50">Proveedor</strong>
			</td>
			
			<td  style="width: 50%; "> 
				<strong style="font-size:18px;color:#2c3e50">Enviar a</strong>
			</td>
		</tr>
		
		<tr>

            <td  style="width: 50%; "> 
			
				<strong>Nombre: </strong> <?php echo $rw_cliente['razon_social'];?><br>
				<strong>Dirección: </strong> <?php echo $rw_cliente['direccion'];?><br>
				<strong>E-mail: </strong> <?php echo $rw_cliente['email'];?><br>
				<strong>Teléfono: </strong> <?php echo $rw_cliente['telefono'];?>
            </td>

			<td  style="width: 50%; "> 
			
				<strong>Empresa: </strong> <?php echo $rw_perfil['nombre_comercial'];?><br>
				<strong>Dirección: </strong> <?php echo $rw_perfil['direccion'];?><br>
				<strong>E-mail: </strong> <?php echo $rw_perfil['email'];?><br>
				<strong>Teléfono: </strong> <?php echo $rw_perfil['telefono'];?>
            </td>
			
			
			
        </tr>
    </table>
	
	<br>
	
	<table cellspacing="0" style="width: 100%;" class="detalle">
        <tr>

            <td  style="width: 50%; "> 
				<strong style="font-size:16px;color:#2c3e50">Condiciones de pago</strong>
			</td>
			<td  style="width: 50%; "> 
				<strong style="font-size:16px;color:#2c3e50">Método de envío</strong>

            </td>
		</tr>
		<tr>

            <td  style="width: 50%; "> 
				<?php echo $condiciones;?>
            </td>
			<td  style="width: 50%; "> 
				<?php echo $envio;?>
            </td>
		</tr>
    </table>
	<br>
	<table cellspacing="0" style="width: 100%;" class='items'>
        <tr>
			<th style="text-align:center;width:10%">Cantidad</th>
			<th style="text-align:center;width:10%">Código</th>
			<th style="text-align:left;width:40%">Descripción</th>
			
			<th style="text-align:right;width:20%">Ultimo Precio</th>
			<th style="text-align:right;width:20%">Total</th>
        </tr>
	<?php
		$query=mysqli_query($con,"select p.codigo,p.nombre, oc.cantidad, oc.importe from ordenes_de_compras_detalle oc , productos p  where oc.id_producto=p.id_producto and oc.id_orden_compra=".$orden."");
		$items=1;
		$suma=0;
		while($row=mysqli_fetch_array($query)){
			$total=$row['cantidad']*$row['importe'];
			$total=number_format($total,2,'.','');
			?>
		<tr>
			<td class="border-bottom text-center"><?php echo $row['cantidad'];?></td>
			<td class="border-bottom text-center"><?php echo $row['codigo'];?></td>
			<td class="border-bottom"><?php echo $row['nombre'];?></td>
			
			<td class="border-bottom text-right"><?php echo $row['importe'];?></td>
			<td class='border-bottom text-right'><?php echo $total;?></td>

		</tr>	
		
		<?php
		$items++;
		$suma+=$total;
		 }

	?>	
	<tr >
		<td colspan=4 class='text-right' style="font-size:24px;color: #c0392b">TOTAL  </td>
		<td class='text-right' style="font-size:24px;color:#c0392b"><?php echo number_format($suma,2);?> </td>
	</tr>
    </table>
	
	<br>
	<p>
		Autorizado por : <?php echo $aprobado;?> <br>
	</p>
	
	<br><br>
	
	<p class='text-center'>Si tiene alguna consulta relacionada con esta orden de compra, por favor contáctenos : <br><?php echo $rw_perfil['nombre_comercial'];?>, <?php echo $rw_perfil['telefono'];?>, <?php echo $rw_perfil['email'];?> </p>
	
	
</page>	
    