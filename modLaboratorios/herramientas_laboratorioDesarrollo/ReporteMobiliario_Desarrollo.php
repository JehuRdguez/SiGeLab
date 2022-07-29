<?php
session_start();
$correo = $_SESSION['correo'];
$nombreC = $_SESSION['nombreC'];
$idTipoUsuario = $_SESSION['idTipoUsuario'];
$idUsuario = $_SESSION['idUsuario'];
?>

<?php
require('../fpdf/fpdf.php');

class PDF extends FPDF
{
// Cabecera de página
function Header()
{
    // Arial bold 15
    $this->SetFont('Arial','B',8);
    $this->setXY(140,20);
    $this->cell(10, 2,'Universidad Teconologica de Manzanillo', 4, 3, '', 0);
    $this->setXY(146,23);
    $this->cell(10, 2,utf8_decode(' Camino hacías las humedades S/N, '), 4, 3, '', 0);
    $this->setXY(145,26);
    $this->cell(10, 2,utf8_decode(' Salagua, Manzanillo, Colima, México'), 4, 3, '', 0);
    $this->setXY(167,29);
    $this->cell(10, 2,' utem@utem.edu.mx  ', 4, 3, 'c', 0);
    $this->setXY(171,32);
    $this->cell(10, 2,utf8_decode(' 01 (314) 33 14450 '), 4, 3, '', 0);
    $this->Image('../../styles/logoUTEM1.png',1,13,80); //imagen(archivo, png/jpg || x,y,tamaño)
    $this->Image('../../styles/12.png',5,40,200); //imagen(archivo, png/jpg || x,y,tamaño)
    $this->setXY(100,280);


    // Movernos a la derecha
    $this->SetFont('Arial','B',16);
    $this->Cell(60);
    // Título
    $this->setXY(75,60);
    $this->Cell(70,10,'Laboratorio de desarrollo',0,0,'C');

    $this->SetFont('Arial','B',20);
    $this->Cell(60);
    // Título
    $this->setXY(75,50);
    $this->Cell(70,10,'Reporte de mobiliario',0,0,'C');
    // Salto de línea
    $this->Ln(30);

    $this->SetFont('Times','',10);
    $this->setX(20);
    $this->cell(37, 10, utf8_decode('N.º Inv. Esc. Mobiliario'), 1, 0, 'C', 0);
    $this->cell(34, 10, utf8_decode('N.º Secciones de mesa'), 1, 0, 'C', 0);
    $this->cell(100, 10, utf8_decode('Descripción'), 1, 1, 'C', 0);
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
    $this->Image('../../styles/12.png',55,265,100); //imagen(archivo, png/jpg || x,y,tamaño)
    $this->setXY(100,270);
    $this->cell(10, 2,'Firma', 4, 3, 'C', 0);
    $this->Cell(10,5,utf8_decode($_SESSION['nombreC']) ,0,0,'C');
    }
}
}


$mysqli = new mysqli("localhost","root","","sigelab");

$consulta= "SELECT * FROM vwmobiliario WHERE estado=1 AND idLaboratorio=2";
$resultado = $mysqli->query($consulta);


$pdf = new PDF();
$pdf->isFinished = false;
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetAutoPageBreak(true, 40);
$pdf->SetFont('Arial','B',16);



while($row = $resultado->fetch_assoc()){

    $pdf->SetFont('Times','',10);
    $pdf->setX(20);
    $pdf->cell(37, 10, $row['numInvMobiliario'], 1, 0, '', 0);
    $pdf->cell(34, 10, $row['seccionesDeMesa'], 1, 0, '', 0);
    $pdf->cell(100, 10, $row['descripcion'], 1, 1, '', 0);
    $pdf->isFinished = false;
}
$pdf->isFinished = true;




$pdf->Output();
?>
