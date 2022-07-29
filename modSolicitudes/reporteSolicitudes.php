<?php
session_start();
$correo = $_SESSION['correo'];
$nombreC = $_SESSION['nombreC'];
$idTipoUsuario = $_SESSION['idTipoUsuario'];
$idUsuario = $_SESSION['idUsuario'];
?>

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
    $this->Image('../styles/12.png',5,40,200); //imagen(archivo, png/jpg || x,y,tamaño)
    $this->Image('../styles/12.png',55,275,100); //imagen(archivo, png/jpg || x,y,tamaño)
    $this->setXY(100,280);
    $this->cell(10, 2,'Firma', 4, 3, 'c', 0);


    // Movernos a la derecha
    $this->SetFont('Arial','B',20);
    $this->Cell(60);
    // Título
    $this->setXY(70,60);
    $this->Cell(70,10,'Reporte de solicitudes',0,0,'C');
    // Salto de línea
    $this->Ln(20);

    $this->SetFont('Times','',10);
    $this->setX(23);
    $this->cell(40, 10, utf8_decode('Nombre del solicitante'), 1, 0, 'c', 0);
    $this->cell(28, 10, utf8_decode('Laboratorio'), 1, 0, 'c', 0);
    $this->cell(17, 10, utf8_decode('Grupo'), 1, 0, 'c', 0);
    $this->cell(25, 10, utf8_decode('Fecha'), 1, 0, 'c', 0);
    $this->cell(28, 10, utf8_decode('Horario'), 1, 0, 'c', 0);
    $this->cell(28, 10, utf8_decode('Estado'), 1, 1, 'c', 0);

  
   
}


// Pie de página
function Footer()
{
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Número de página
    $this->Cell(0,10,utf8_decode('Pagina ').$this->PageNo().'/{nb}',0,0,'C');
}
}


$mysqli = new mysqli("localhost","root","","sigelab");

$consulta= "SELECT * FROM vwreporteSolicitud ORDER BY nombreLaboratorio";
$resultado = $mysqli->query($consulta);


$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);





while($row = $resultado->fetch_assoc()){

    $pdf->SetFont('Times','',10);
    $pdf->setX(23);
    $pdf->cell(40, 10, $row['maestro'], 1, 0, 'c', 0);
    $pdf->cell(28, 10, $row['nombreLaboratorio'], 1, 0, 'c', 0);
    $pdf->cell(17, 10, $row['nombreGrupo'], 1, 0, 'c', 0);
    $pdf->cell(25, 10, $row['fecha'], 1, 0, 'c', 0);
    $pdf->cell(28, 10, $row['horario'], 1, 0, 'c', 0);
    $pdf->cell(28, 10, $row['estado'], 1, 1, 'c', 0);   

    //$pdf->cell(80, 10,utf8_decode($row['numInvEscolar']), 1, 0, 'c', 0);

}




$pdf->Output();
