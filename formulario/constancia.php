<?php

setlocale(LC_ALL, "es_ES");
// setlocale(LC_TIME, "spanish");

$titulo = 'CONSTANCIA DE EXAMEN';
?>

<?php

require('../fpdf/fpdf.php');

class PDF extends FPDF {

// Cabecera de pagina
    function Header() {
        // Logo
        $this->Image('logo.png', 5, 8, 83);

        // Arial bold 15
        // Movernos a la derecha
//	    $this->Cell(80);
        // Titulo
        $this->SetFont('times', 'I', 8);
        // $this->Cell(0,10, iconv('UTF-8', 'windows-1252', '2020 - Año del General Manuel Belgrano'),0,0,'R');
        $this->Cell(0, 10, iconv('UTF-8', 'windows-1252', ' '), 0, 0, 'R');
        $this->ln(35);
        $this->ln();
        $this->SetFont('Arial', 'B', 13);
        $this->Cell(0, 0, iconv('UTF-8', 'windows-1252', 'CONSTANCIA DE EXAMEN'), 0, 2, 'C');
        // Salto de linea
        $this->Ln(10);
    }

// Pie de pagina
    function Footer() {
        // Posicion: a 1,5 cm del fiiconv('UTF-8', 'windows-1252',nal
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Numero de pagina
// //    $this->Cell(0,10, iconv('UTF-8', 'windows-1252', '"Año de la gratuidad "'),0,0,'C');
//    $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
    }

}

if ($_POST['carrera'] == 'Ingeniería Pesquera') {
    $ciudad = 'Ushuaia';     // Add a recipient
} else {
    $ciudad = 'Río Grande';
}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage('P', 'A4');
$pdf->SetFont('Arial', 'B', 12);

$pdf->Image('logo.png', 5, 8, 83);

$mes = date("m", strtotime($_POST['fecha']));
$dias = date("d", strtotime($_POST['fecha']));
$anio = date("Y", strtotime($_POST['fecha']));

// include('../includes/mes.php');

$pdf->Cell(60);
$pdf->SetFont('Arial', '', 10);
$pdf->Ln();


$pdf->write(10, '               ');
$pdf->write(10, 'Por la presente se hace constar que el alumno ');
$pdf->SetFont('Arial', 'B', 10);
$pdf->write(10, iconv('UTF-8', 'windows-1252', ' ' . $_POST['nom']));
$pdf->SetFont('Arial', '', 10);
$pdf->write(10, '  DNI ');
$pdf->SetFont('Arial', 'B', 10);
$pdf->write(10, ' ' . $_POST['dni']);
$pdf->SetFont('Arial', '', 10);
$pdf->write(10, iconv('UTF-8', 'windows-1252', '  Legajo número '));
$pdf->SetFont('Arial', 'B', 10);
$pdf->write(10, ' ' . $_POST['legajo']);
$pdf->SetFont('Arial', '', 10);

$pdf->write(10, iconv('UTF-8', 'windows-1252', ' rindió examen '));
$pdf->SetFont('Arial', 'B', 10);
$pdf->write(10, iconv('UTF-8', 'windows-1252', ' ' . $_POST['examen']));
$pdf->SetFont('Arial', '', 10);
$pdf->write(10, ' de la asignatura ');
$pdf->SetFont('Arial', 'B', 10);
$pdf->write(10, iconv('UTF-8', 'windows-1252', ' ' . $_POST['asignatura']));
$pdf->SetFont('Arial', '', 10);
$pdf->write(10, ' a cargo del profesor ');
$pdf->SetFont('Arial', 'B', 10);
$pdf->write(10, iconv('UTF-8', 'windows-1252', ' ' . $_POST['docente']));
$pdf->SetFont('Arial', '', 10);
$pdf->write(10, ' correspondiente a la carrera ');
$pdf->SetFont('Arial', 'B', 10);

$pdf->write(10, iconv('UTF-8', 'windows-1252', ' ' . $_POST['carrera']));
$pdf->Ln();
$pdf->SetFont('Arial', '', 10);
$pdf->write(10, '               ');
$pdf->write(10, 'A solicitud del interesado y a los fines de ser presentado ante quien corresponda, se le extiende el presente certificado, sin enmiendas ni raspaduras, ');

$pdf->write(10, iconv('UTF-8', 'windows-1252', $ciudad));

$pdf->Write(10, iconv('UTF-8', 'windows-1252', ' a los  '));
$pdf->Write(10, iconv('UTF-8', 'windows-1252', $dias));

$pdf->Write(10, iconv('UTF-8', 'windows-1252', ' días del mes de '));

$mes = nombremes($mes);
$pdf->Write(10, iconv('UTF-8', 'windows-1252', $mes));
$pdf->Write(10, iconv('UTF-8', 'windows-1252', ' de '));
$pdf->Write(10, iconv('UTF-8', 'windows-1252', $anio . '.'));
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('Arial', '', 10);
$pdf->Ln();
$pdf->Image('sello.jpg', 50, 125, 30);
$pdf->Cell(120);
$pdf->write(6, '     ........................................');
$pdf->Ln();
$pdf->Cell(120);
  if ($_POST['examen'] == 'Final') {
	 $pdf->write(10, iconv('UTF-8', 'windows-1252', 'Firma y aclaración de Autoridad'));

    } else {
	 $pdf->write(10, iconv('UTF-8', 'windows-1252', 'Firma y aclaración del Docente'));

    }

//  $pdf->write(10, iconv('UTF-8', 'windows-1252', 'Firma y aclaración del Docente')); 
$pdf->Ln();

// $pdf->Output();
//------------------------------------------------------------------------------------------
//                       FUNCION PARA EL MES
function nombremes($mes) {
    setlocale(LC_TIME, 'spanish');
    $nombre = strftime("%B", mktime(0, 0, 0, $mes, 1, 2000));
    return $nombre;
}

$pdf->Output('constancia.pdf', 'F');


require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';
require '../phpmailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
// require 'vendor/autoload.php';
// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
//    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host = 'smtp.office365.com';                    // Set the SMTP server to send through
    $mail->SMTPAuth = true;                                   // Enable SMTP authentication
    $mail->Username = 'gguzman@alumnos.frtdf.utn.edu.ar';                     // SMTP username
    $mail->Password = 'Gonza197';                               // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
    //Recipients
    $mail->setFrom('gguzman@alumnos.frtdf.utn.edu.ar', 'Gonza ');

    if ($_POST['examen'] == 'Final') {
        if ($_POST['carrera'] == 'Ingeniería Pesquera') {
            $mail->addAddress('gonzaguzman60@gmail.com');     // Add a recipient
        } else {
            $mail->addAddress('gonzaguzman60@gmail.com');     // Add a recipient
//            $mail->addAddress('mfernandez@frtdf.utn.edu.ar');     // Add a recipient
        }
    } else {
        $mail->addAddress('gonzaguzman60@gmail.com');     // Add a recipient
    }

    // Attachments
    $mail->addAttachment('constancia.pdf');         // Add attachments
    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'CONSTANCIA DE EXAMEN';
    $mail->Body = 'Encontrara adjunto la constancia de examen ' . $_POST['examen'] . '  de ' . $_POST['nom']. '  - ' . $_POST['email_alumno']. ' la que debera firmar y devolver al alumno';
    $mail->AltBody = 'Encontrara adjunto la constancia de examen ' . $_POST['examen'] . '  de ' . $_POST['nom'] . ' la que debera firmar y devolver al alumno';

    $mail->send();


    echo 'La constancia fue enviada por correo, usted la recibira cuando este firmada';
} catch (Exception $e) {
    echo "Mensaje no pudo ser enviado. Mailer Error: {$mail->ErrorInfo}";
}
?>
