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
        ARQUEO DE CAJA 
      </td>
      
      
        </tr>
    </table>
  
  <br>
  <table cellspacing="0" style="width: 100%;">
        <tr>

           
      <td  style="width: 20%;color:white;background-color:#c0392b;padding:5px;text-align:center "> 
        <strong style="font-size:14px;" ># ARQUEO</strong>
      </td>
      <td  style="width: 20%;padding:5px;text-align:center;border:solid 1px #bdc3c7;font-size:15px"> 
        <?php echo $id_arqueo;?>
      </td> 

       <td  style="width: 60%; "> 
        
      </td>     
      
    </tr>
    
    <tr>
            
      <td  style="width: 20%; color:white;background-color:#c0392b;padding:5px;text-align:center " > 
        <strong style="font-size:14px;">FECHA</strong>
      </td>
      <td  style="width: 20%;padding:5px;text-align:center;border:solid 1px #bdc3c7;font-size:15px " > 
        <?php echo $fecha_inicio;?>
      </td>
      <td  style="width: 60%; "> 
        
      </td>
    </tr>
    <tr>
            
      <td  style="width: 20%; color:white;background-color:#c0392b;padding:5px;text-align:center " > 
        <strong style="font-size:14px;">CAJERO</strong>
      </td>
      <td  style="width: 20%;padding:5px;text-align:center;border:solid 1px #bdc3c7;font-size:15px " > 
        <?php echo $usuario;?>
      </td>
      <td  style="width: 60%; "> 
        
      </td>
    </tr>



    </table>
  
  <br>
  <table cellspacing="0" style="width: 100%;" class="detalle">
        <tr>

            <td  style="width: 30%; "> 
        <strong style="font-size:18px;color:#2c3e50">Apertura de caja</strong>
      </td>
      
      <td  style="width: 20%; "> 
        <strong style="font-size:18px;color:#2c3e50"><?php echo number_format($apertura,2,'.',''); ?></strong>
      </td>
    </tr>   
 
    </table>  
  <br>
  

  <br>
  <table cellspacing="0" style="width: 100%;" class='items'>
        <tr>
      <th style="text-align:center;width:50%">BILLETES/MONEDAS</th>
      <th style="text-align:center;width:25%">CANTIDAD</th>
      <th style="text-align:left;width:25%">VALOR</th>
      
      
        </tr>
  <?php
    $query=mysqli_query($con,"select b.descripcion, ad.valor, ad.valor,b.monto   from arqueos a, arqueos_detalle ad, aperturas_cajeros ac, billetes b where a.id_apertura_cajero = ac.id_apertura_cajero and
a.id_arqueo= ad.id_arqueo and ad.id_billete = b.id_billete and a.id_arqueo=".$id_arqueo."  group by b.id_billete");   
   $items=1;
    $suma=0;
    while($row=mysqli_fetch_array($query)){
      $total=$row['valor']*$row['monto'];
      $total=number_format($total,2,'.','');
      
      ?>
    <tr>
      <td class="border-bottom text-center"><?php echo $row['descripcion'];?></td>
      <td class="border-bottom text-center"><?php echo $row['valor'];?></td> 
       <td class='border-bottom text-right'><?php echo $total;?></td>

    </tr> 
    
    <?php
    $items++;
    $suma+=$total;
     }

  ?>  
  <tr >
    <td colspan=2 class='text-right' style="font-size:24px;color: #c0392b">TOTAL  </td>
    <td class='text-right' style="font-size:24px;color:#c0392b"><?php echo number_format($suma,2);?> </td>
  </tr>
    </table>
  
 
  
</page> 
    