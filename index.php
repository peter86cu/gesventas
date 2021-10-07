<?php

  require_once  "controladores/CtrlBilletes.php";
  require_once  "controladores/CtrlCategoria.php";
  require_once  "controladores/CtrlClientes.php";
  require_once  "controladores/CtrlReportes.php";
  require_once  "controladores/CtrlMail.php";
  require_once  "controladores/CtrlProveedores.php";
  require_once  "controladores/CtrlVentas.php";
  require_once  "controladores/CtrlApertura.php";
  require_once  "controladores/CtrlGeneral.php";
  require_once  "controladores/CtrlFacturaCompras.php";
  require_once  "controladores/CtrlPrincipal.php";
  require_once  "controladores/CtrlUsuario.php";
  require_once  "controladores/CtrlProductos.php";
  require_once  "controladores/CtrlRoles.php";
  require_once  "controladores/CtrlOrdenesCompras.php";

  require_once  "modelo/MdlBilletes.php";
  require_once  "modelo/MdlCategoria.php";
  require_once  "modelo/MdlClientes.php";
  require_once  "modelo/MdlReportes.php";
  require_once  "modelo/MdlMail.php";
  require_once  "modelo/MdlProveedores.php";
  require_once  "modelo/MdlVentas.php";
  require_once  "modelo/MdlApertura.php";
  require_once  "modelo/MdlFacturasCompras.php";
  require_once  "modelo/MdlUsuario.php";
  require_once  "modelo/MdlProductos.php";
  require_once  "modelo/MdlRoles.php";
  require_once  "modelo/MdlOrdenesCompras.php";
  require_once  "modelo/MdlGeneral.php";

 require_once  "config/lib.php";
 //require_once  "mail/downloadMail.php";
//require_once  "mail/copiarMail22.php";
 //include "vistas/modulos/modal-stock.php";




    $Obj_Principal = new Principal();
    $Obj_Principal -> CtrlPrincipal();
