<?php
session_start();
$correo = $_SESSION['correo'];
$nombreC = $_SESSION['nombreC'];
$idTipoUsuario = $_SESSION['idTipoUsuario'];
$idUsuario = $_SESSION['idUsuario'];
?>

<?php if ($idTipoUsuario == 1) { ?>

<?php
require('../modLaboratorios/fpdf/fpdf.php');

class PDF extends FPDF
{
// Cabecera de página
function Header()
{
    // Arial bold 15
    $this->SetFont('Arial','B',8);
    $this->setXY(150,20);
    $this->cell(10, 2,'Universidad Teconologica de Manzanillo', 4, 3, 'c', 0);
    $this->setXY(156,23);
    $this->cell(10, 2,utf8_decode(' Camino hacías las humedades S/N, '), 4, 3, 'c', 0);
    $this->setXY(155,26);
    $this->cell(10, 2,utf8_decode(' Salagua, Manzanillo, Colima, México'), 4, 3, 'c', 0);
    $this->setXY(177,29);
    $this->cell(10, 2,' utem@utem.edu.mx  ', 4, 3, 'c', 0);
    $this->setXY(181,32);
    $this->cell(10, 2,utf8_decode(' 01 (314) 33 14450 '), 4, 3, 'c', 0);
    $this->Image('../styles/logoUTEM1.png',1,13,80); //imagen(archivo, png/jpg || x,y,tamaño)



    // Movernos a la derecha
    $this->SetFont('Arial','B',20);
    $this->Cell(60);
    // Título
    $this->setXY(70,60);
    $this->Cell(70,10,'Reporte de solicitudes',0,0,'C');
    // Salto de línea
    $this->Ln(20);

    $this->SetFont('Times','',10);
    $this->setX(10);
    $this->cell(60, 10, utf8_decode('Nombre del solicitante'), 1, 0, 'c', 0);
    $this->cell(42, 10, utf8_decode('Laboratorio'), 1, 0, 'c', 0);
    $this->cell(17, 10, utf8_decode('Grupo'), 1, 0, 'c', 0);
    $this->cell(25, 10, utf8_decode('Fecha'), 1, 0, 'c', 0);
    $this->cell(28, 10, utf8_decode('Horario'), 1, 0, 'c', 0);
    $this->cell(20, 10, utf8_decode('Estado'), 1, 1, 'c', 0);

  
   
}


// Pie de página
function Footer()
{
    // Posición: a 2,0 cm del final
    $this->SetY(-20);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Número de página
    $this->Cell(0,20,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');
    if($this->isFinished==true){
    $this->Image('../styles/12.png',55,265,100); //imagen(archivo, png/jpg || x,y,tamaño)
    $this->setXY(100,270);
    $this->cell(10, 2,'Firma', 4, 3, 'C', 0);
    $this->Cell(10,5,utf8_decode($_SESSION['nombreC']) ,0,0,'C');
    }
}
}


$mysqli = new mysqli("localhost","root","","sigelab");

$consulta= "SELECT * FROM vwreporteSolicitud ORDER BY nombreLaboratorio";
$resultado = $mysqli->query($consulta);


$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->isFinished = false;
$pdf->SetAutoPageBreak(true, 40);
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);





while($row = $resultado->fetch_assoc()){

    $pdf->SetFont('Times','',10);
    $pdf->setX(10);
    $pdf->cell(60, 10, $row['maestro'], 1, 0, 'c', 0);
    $pdf->cell(42, 10, $row['nombreLaboratorio'], 1, 0, 'c', 0);
    $pdf->cell(17, 10, $row['nombreGrupo'], 1, 0, 'c', 0);
    $pdf->cell(25, 10, $row['fecha'], 1, 0, 'c', 0);
    $pdf->cell(28, 10, $row['horario'], 1, 0, 'c', 0);
    if ($row['estado'] == 2) {
        $pdf->cell(20, 10, utf8_decode('Pendiente'), 1, 1, 'c', 0);
    } else if ($row['estado'] == 1) {
        $pdf->cell(20, 10, utf8_decode('Aceptada'), 1, 1, 'c', 0);
    } else {
        $pdf->cell(20, 10, utf8_decode('Rechazada'), 1, 1, 'c', 0);
    }

    //$pdf->cell(80, 10,utf8_decode($row['numInvEscolar']), 1, 0, 'c', 0);

}
$pdf->isFinished = true;



$pdf->Output();

?><?php } else { ?>
    <?php header("Location: ../index.php"); ?>
  <?php } ?>