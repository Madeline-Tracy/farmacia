<?php
session_start();
$ruta="../../";
$folder="";


require $ruta."recursos/fpdf/fpdf.php";

include_once($ruta."class/persona.php");
$persona=new persona;
include_once($ruta."class/producto.php");
$producto=new producto;

include_once($ruta."class/ventadetalle.php");
$ventadetalle=new ventadetalle;

include_once($ruta."class/venta.php");
$venta=new venta;

//include_once($ruta."class/vproducto.php");
//$vproducto=new vproducto;

//require_once($ruta.'recursos/tcpdf/tcpdf.php');



extract($_GET);

$id=$_SESSION["idventa"];

$dVenta=$venta->mostrar($id);
$dVenta=array_shift($dVenta);


class PDF extends FPDF
{
   //Cabecera de página
   function Header()
   {
        $linea=0;//definimos si el reporte tendra margenes
        $saltoLinea=4;//definimos cuantos pixeles saltara hacia abajo

        $this->Image('../../imagenes/logo.png',8,8,20);
        $this->SetFont('Arial','I',10);
        $this->Cell(25,1);
        $this->Cell(20,0,'CHOCOLATES'.$id,0,0,'C');
        $this->SetFont('Arial','B',10);
        $this->Cell(45,0);
         
        $this->Ln(5);
        $this->Cell(25,1);
        $this->Cell(20,1,'Para compartir!!!',0,0,'C');
          
           
  $this->Ln(15);

   }
    function Footer()
    {
        $this->SetY(-5);
        $this->SetFont('Arial','I',6);
        $this->SetTextColor(128);
        $this->Cell(15,0,'Fecha - Hora : ',0,0,'C');
        $this->Cell(30,0,date('Y-m-d')." - ".date("H:i:s"),0,0,'C');
    }
}   
$altura = 100;

 foreach($ventadetalle->mostrarTodo("idventa=".$id) as $m)
  { 
        $altura=$altura+4;
  }

  $pdf = new PDF('P', 'mm', array(80, $altura));
  $pdf->SetMargins(5,10 , 5,5); 
  $pdf->AddPage();


    $linea=0;//definimos si el reporte tendra margenes
    $saltoLinea=4;//definimos cuantos pixeles saltara hacia abajo

              $pdf->Cell(23,1);
              $pdf->SetFont('Arial', 'B', 12);
              $pdf->Cell(30, $saltoLinea, 'RECIBO', $linea);
              $pdf->Ln(5);


 $pdf->Ln(5);

        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 5);
        $pdf->Cell(5, $saltoLinea, 'N.', $linea);
        //$pdf->Cell(25, $saltoLinea, 'PRODUCTO ', $linea);
        $pdf->Cell(30, $saltoLinea, 'ITEM', $linea);
        $pdf->Cell(10, $saltoLinea, 'PRECIO',0,0,'R', $linea);
         $pdf->Cell(10, $saltoLinea, 'CANTIDAD',0,0,'c', $linea);
          $pdf->Cell(10, $saltoLinea, 'TOTAL',0,0,'R', $linea);
        $pdf->Ln(1);
        $pdf->SetFont('Arial','',5);
        $pdf->Cell(7, $saltoLinea, '__________________________________________________________________', $linea);
        $pdf->Ln(0);//4

        $pdf->SetFont('Arial', '', 5);
        $i=1;

  foreach($ventadetalle->mostrarTodo("idventa=".$id) as $m)
  { 
     $pro=$producto->mostrar($m['idproducto']);
      $pro=array_shift($pro);

                $pdf->Ln($saltoLinea);
                $pdf->Cell(5, $saltoLinea, $i,     $linea);
                 $pdf->Cell(30, $saltoLinea, $pro['nombre'],     $linea);
                 $pdf->Cell(10, $saltoLinea, $m['precio'],0,0,'R',     $linea);
                  $pdf->Cell(10, $saltoLinea, $m['cantidad'],0,0,'R',     $linea);
                   $pdf->Cell(10, $saltoLinea, $m['precio']*$m['cantidad'],0,0,'R',     $linea);
                $i++;
            
        }
 $pdf->Ln(5);

            
              $pdf->SetFont('Arial','',5);
              $pdf->Cell(7, $saltoLinea, '__________________________________________________________________', $linea);
              $pdf->Ln(3);
               $pdf->SetFont('Arial', 'B', 6);
              $pdf->Cell(30, $saltoLinea, 'TOTAL (Bs)', $linea);
              $pdf->SetFont('Arial', '', 6);
              $pdf->Cell(35, $saltoLinea, $dVenta['costototal'],0,0,'R', $linea);
              $pdf->Ln(3);
              $pdf->SetFont('Arial', 'B', 6);
              $pdf->Cell(30, $saltoLinea, 'IMPORTE(Bs)', $linea);
              $pdf->SetFont('Arial', '', 6);
              $pdf->Cell(35, $saltoLinea, $dVenta['importe'],0,0,'R', $linea);
              $pdf->Ln(3);
              $pdf->SetFont('Arial', 'B', 6);
              $pdf->Cell(30, $saltoLinea, 'CAMBIO(Bs)', $linea);
              $pdf->SetFont('Arial', '', 6);
              $pdf->Cell(35, $saltoLinea, $dVenta['saldo'],0,0,'R', $linea);

$pdf->Output();


?>
