<?php
session_start();
$correo = $_SESSION['correo'];
$nombreC = $_SESSION['nombreC'];
$idTipoUsuario = $_SESSION['idTipoUsuario'];
$idUsuario = $_SESSION['idUsuario'];
?>

<?php if ($idTipoUsuario == 1) { ?>


<?php

require ('../modLaboratorios/fpdf/fpdf.php');
class PDF extends FPDF {

// Cabecera de página

function Header()
{
    // Arial bold 15
    $this->SetFont('Arial','B',8);
    $this->setXY(140,20);
    $this->cell(10, 2,'Universidad Teconologica de Manzanillo', 4, 3, 'c', 0);
    $this->setXY(146,23);
    $this->cell(10, 2,utf8_decode(' Camino hacías las humedades S/N, '), 4, 3, 'c', 0);
    $this->setXY(145,26);
    $this->cell(10, 2,utf8_decode(' Salagua, Manzanillo, Colima, México'), 4, 3, 'c', 0);
    $this->setXY(167,29);
    $this->cell(10, 2,' utem@utem.edu.mx  ', 4, 3, 'c', 0);
    $this->setXY(171,32);
    $this->cell(10, 2,utf8_decode(' 01 (314) 33 14450 '), 4, 3, 'c', 0);
    $this->Image('../styles/logoUTEM1.png',1,13,80); //imagen(archivo, png/jpg || x,y,tamaño)
    $this->Line(5, 50, 205, 50); //x,y,x,y
 
	

    // Movernos a la derecha
    $this->SetFont('Arial','B',20);
    $this->Cell(60);
    // Título
    $this->setXY(75,60);
    $this->Cell(70,10,'Reporte de incidencias',0,0,'C');
    // Salto de línea
    $this->Ln(20);

   
  
   
}


// Pie de página

	function Footer() {
		// Posición: a 1,5 cm del final
		$this->SetY(-15);

		$this->SetFont('Arial', 'B', 10);
		// Número de página
		$this->Cell(350, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C');
		if($this->isFinished==true){
			$this->Line(70, 282, 140, 282);//x,y,x,y
			$this->setXY(100,285);
			$this->cell(10, 2,'Firma', 4, 3, 'C', 0);
			$this->Cell(10,5,utf8_decode($_SESSION['nombreC']) ,0,0,'C');
			}
	}

// --------------------METODO PARA ADAPTAR LAS CELDAS------------------------------
	var $widths;
	var $aligns;

	function SetWidths($w) {
		//Set the array of column widths
		$this->widths = $w;
	}

	function SetAligns($a) {
		//Set the array of column alignments
		$this->aligns = $a;
	}

	function Row($data, $setX) //yo modifique el script a  mi conveniencia :D
	{
		//Calculate the height of the row
		$nb = 0;
		for ($i = 0; $i < count($data); $i++) {
			$nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
		}

		$h = 8 * $nb;
		//Issue a page break first if needed
		$this->CheckPageBreak($h, $setX);
		//Draw the cells of the row
		for ($i = 0; $i < count($data); $i++) {
			$w = $this->widths[$i];
			$a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'C';
			//Save the current position
			$x = $this->GetX();
			$y = $this->GetY();
			//Draw the border
			$this->Rect($x, $y, $w, $h, 'DF');
			//Print the text
			$this->MultiCell($w, 8, $data[$i], 0, $a);
			//Put the position to the right of the cell
			$this->SetXY($x + $w, $y);
		}
		//Go to the next line
		$this->Ln($h);
	}

	function CheckPageBreak($h, $setX) {
		//If the height h would cause an overflow, add a new page immediately
		if ($this->GetY() + $h > $this->PageBreakTrigger) {
			$this->AddPage($this->CurOrientation);
			$this->SetX($setX);

			$this->SetFont('Times','',13);
            $this->setX(1);
            $this->Cell(10, 10, 'N', 1, 0, 'C', 0);
            $this->cell(50, 10, utf8_decode('Nombre del solicitante'), 1, 0, 'C', 0); //ancho,alto,texto,borde,salto de linea,lineado(izquierda,derecha,centrado),rellenar celda
            $this->cell(40, 10, utf8_decode('Laboratorio'), 1, 0, 'C', 0);
            $this->cell(24, 10, utf8_decode('Grupo'), 1, 0, 'C', 0);
            $this->cell(30, 10, utf8_decode('Fecha'), 1, 0, 'C', 0);
            $this->cell(30, 10, utf8_decode('Horario'), 1, 0, 'C', 0);
            $this->cell(24, 10, utf8_decode('Estado'), 1, 1, 'C', 0);

		}

		if ($setX == 100) {
			$this->SetX(100);
		} else {
			$this->SetX($setX);
		}

	}

	function NbLines($w, $txt) {
		//Computes the number of lines a MultiCell of width w will take
		$cw = &$this->CurrentFont['cw'];
		if ($w == 0) {
			$w = $this->w - $this->rMargin - $this->x;
		}

		$wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
		$s = str_replace("\r", '', $txt);
		$nb = strlen($s);
		if ($nb > 0 and $s[$nb - 1] == "\n") {
			$nb--;
		}

		$sep = -1;
		$i = 0;
		$j = 0;
		$l = 0;
		$nl = 1;
		while ($i < $nb) {
			$c = $s[$i];
			if ($c == "\n") {
				$i++;
				$sep = -1;
				$j = $i;
				$l = 0;
				$nl++;
				continue;
			}
			if ($c == ' ') {
				$sep = $i;
			}

			$l += $cw[$c];
			if ($l > $wmax) {
				if ($sep == -1) {
					if ($i == $j) {
						$i++;
					}

				} else {
					$i = $sep + 1;
				}

				$sep = -1;
				$j = $i;
				$l = 0;
				$nl++;
			} else {
				$i++;
			}

		}
		return $nl;
	}
// -----------------------------------TERMINA---------------------------------
}

    define('DB_HOST','localhost');
    define('DB_NAME','sigelab');
    define('DB_USER','root');
    define('DB_PASSWORD','');
    define('DB_CHARSET','utf8');


class Conexion{
    private $conect;

    public function __construct(){
        $connectionString = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET;
        try{
            $this->conect = new PDO($connectionString, DB_USER, DB_PASSWORD);
            $this->conect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //echo "conexión exitosa";
        }catch(PDOException $e){
            $this->conect = 'Error de conexión';
            echo "ERROR: " . $e->getMessage();
        }
    }

    public function conect(){
        return $this->conect;
    }
}


$data = new Conexion();
$conexion = $data->conect();
$strquery = "SELECT * FROM vwreporteSolicitud";
$result = $conexion->prepare($strquery);
$result->execute();
$data = $result->fetchall(PDO::FETCH_ASSOC);

// Creación del objeto de la clase heredada
$pdf = new PDF(); //hacemos una instancia de la clase
$pdf->AliasNbPages();
$pdf->isFinished = false;
$pdf->AddPage('portrait'); //orientacion de la pagina
$pdf->SetMargins(10, 10, 10); //MARGENES
$pdf->SetAutoPageBreak(true, 20); //salto de pagina automatico



// -----------ENCABEZADO------------------
$pdf->SetX(1);
$pdf->SetFont('Times','',13);
$pdf->Cell(10, 10, 'N', 1, 0, 'C', 0);
$pdf->cell(50, 10, utf8_decode('Nombre del solicitante'), 1, 0, 'C', 0); //ancho,alto,texto,borde,salto de linea,lineado(izquierda,derecha,centrado),rellenar celda
$pdf->cell(40, 10, utf8_decode('Laboratorio'), 1, 0, 'C', 0);
$pdf->cell(24, 10, utf8_decode('Grupo'), 1, 0, 'C', 0);
$pdf->cell(30, 10, utf8_decode('Fecha'), 1, 0, 'C', 0);
$pdf->cell(30, 10, utf8_decode('Horario'), 1, 0, 'C', 0);
$pdf->cell(24, 10, utf8_decode('Estado'), 1, 1, 'C', 0);


// -------TERMINA----ENCABEZADO------------------

$pdf->SetFillColor(255, 255, 255); //color de fondo rgb
$pdf->SetDrawColor(61, 61, 61); //color de linea  rgb
$pdf->SetFont('times', '', 13);

//El ancho de las celdas
$pdf->SetWidths(array(10, 50, 40, 24, 30,30,24)); //???
// esto no lo mencione en el video pero también pueden poner la alineación de cada COLUMNA!!!
$pdf->SetAligns(array('C','C','C','C'));

for ($i = 0; $i < count($data); $i++) {

	if ($data[$i]['estado'] == 2){
		$pdf->Row(array($i+1, utf8_decode($data[$i]['maestro']),utf8_decode($data[$i]['nombreLaboratorio']),utf8_decode($data[$i]['nombreGrupo']),utf8_decode($data[$i]['fecha']),utf8_decode($data[$i]['horario']),utf8_decode('Pendiente')), 1);
	} else if ($data[$i]['estado'] == 1){
		$pdf->Row(array($i+1, utf8_decode($data[$i]['maestro']),utf8_decode($data[$i]['nombreLaboratorio']),utf8_decode($data[$i]['nombreGrupo']),utf8_decode($data[$i]['fecha']),utf8_decode($data[$i]['horario']),utf8_decode('Aceptada')), 1);
		}else {
			$pdf->Row(array($i+1, utf8_decode($data[$i]['maestro']),utf8_decode($data[$i]['nombreLaboratorio']),utf8_decode($data[$i]['nombreGrupo']),utf8_decode($data[$i]['fecha']),utf8_decode($data[$i]['horario']),utf8_decode('Rechazada')), 1);
		}
	}
	$pdf->isFinished = true;


// cell(ancho, largo, contenido,borde?, salto de linea?)

$pdf->Output();

?>

<?php } else { ?>
	<?php header("Location: ../index.php"); ?>
  <?php } ?>