<?php
@include 'config.php';

session_start();

require('vendor/fpdf/fpdf/original/fpdf.php');

@include 'config.php';
if (isset($_SESSION["user_id"])) {
    $user_id = $_SESSION['user_id'];
}
if (isset($_COOKIE["user_id"])) {
    $user_id = $_COOKIE['user_id'];
}

$order_id = $_POST['order_id'];

$select_orders = mysqli_query($conn, "SELECT * FROM `orders` WHERE user_id = '$user_id' AND id = $order_id") or die('query failed');
$row_order = mysqli_fetch_assoc($select_orders);
$id = $row_order['id'];
$date = $row_order['app_date'];
$place = $row_order['place'];
$total_products = $row_order['total_products'];
$price = number_format($row_order['total_price'], 2, ',', '.');

$user_query = mysqli_query($conn, "SELECT email FROM `users` WHERE id = $user_id") or die('query failed');
$row = mysqli_fetch_assoc($user_query);
$user = $row['email'];


class PDF extends FPDF
{
    function Header()
    {
        @include 'config.php';
        if (isset($_SESSION["user_id"])) {
            $user_id = $_SESSION['user_id'];
        }
        if (isset($_COOKIE["user_id"])) {
            $user_id = $_COOKIE['user_id'];
        }

        $order_id = $_POST['order_id'];

        $select_orders = mysqli_query($conn, "SELECT * FROM `orders` WHERE user_id = '$user_id' AND id = $order_id") or die('query failed');
        $row_order = mysqli_fetch_assoc($select_orders);
        $id = $row_order['id'];
        $date = $row_order['app_date'];
        $place = $row_order['place'];

        $user_query = mysqli_query($conn, "SELECT email FROM `users` WHERE id = $user_id") or die('query failed');
        $row = mysqli_fetch_assoc($user_query);
        $user = $row['email'];

        $this->setY(12);
        $this->setX(10);

        $this->Image('src/logo-small.png', 25, 5, 33);

        $this->SetFont('times', 'B', 20);

        $this->Text(90, 15, utf8_decode('PHOENIX COMPS'));

        $this->SetFont('times', 'B', 13);

        $this->Text(70, 25, utf8_decode('IES Pío Baroja, Madrid'));
        $this->Text(70, 32, utf8_decode('Tel: +34 658543300'));
        $this->Text(70, 39, utf8_decode('andreiggar@gmail.es'));

        $this->SetFont('Arial', 'B', 10);
        $this->Text(150, 48, utf8_decode('FACTURA N°:'));
        $this->SetFont('Arial', '', 10);
        $this->Text(176, 48, $id);

        $this->SetFont('Arial', 'B', 10);
        $this->Text(10, 48, utf8_decode('Fecha:'));
        $this->SetFont('Arial', '', 10);
        $this->Text(25, 48, $date);

        $this->SetFont('Arial', 'B', 10);
        $this->Text(10, 54, utf8_decode('Cliente:'));
        $this->SetFont('Arial', '', 10);
        $this->Text(25, 54, $user);

        $this->SetFont('Arial', 'B', 10);
        $this->Text(10, 60, utf8_decode('Dirección:'));
        $this->SetFont('Arial', '', 10);
        $this->Text(30, 60, $place);

        $this->Ln(50);
    }

    function Footer()
    {
        $this->SetFont('helvetica', 'B', 8);
        $this->SetY(-15);
        $this->Cell(95, 5, utf8_decode('Página ') . $this->PageNo() . ' / {nb}', 0, 0, 'L');
        $this->Cell(95, 5, date('d/m/Y | g:i:a'), 00, 1, 'R');
        $this->Line(10, 287, 200, 287);
        $this->Cell(0, 5, utf8_decode("Phoenix Comps © Todos los derechos reservados."), 0, 0, "C");
    }
}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetAutoPageBreak(true, 20);
$pdf->SetTopMargin(15);
$pdf->SetLeftMargin(10);
$pdf->SetRightMargin(10);
$pdf->setY(65);
$pdf->setX(135);
$pdf->Ln();

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(20, 7, utf8_decode('Cod'), 1, 0, 'C', 0);
$pdf->Cell(95, 7, utf8_decode('Descripción'), 1, 0, 'C', 0);
$pdf->Cell(20, 7, utf8_decode('Cant'), 1, 0, 'C', 0);
$pdf->Cell(25, 7, utf8_decode('Precio'), 1, 0, 'C', 0);
$pdf->Cell(25, 7, utf8_decode('Total'), 1, 1, 'C', 0);

$pdf->SetFont('Arial', '', 10);

for ($i = 0; $i < 1; $i++) {

    $pdf->Cell(20, 7, $i + 1, 1, 0, 'L', 0);
    $pdf->Cell(95, 7, utf8_decode('Descripción del producto'), 1, 0, 'L', 0);
    $pdf->Cell(20, 7, utf8_decode('20'), 1, 0, 'R', 0);
    $pdf->Cell(25, 7, utf8_decode('5'), 1, 0, 'R', 0);
    $pdf->Cell(25, 7, utf8_decode('100'), 1, 1, 'R', 0);
}

$pdf->Ln(10);

$pdf->setX(95);
$pdf->Cell(40, 6, 'Total', 1, 0);
$pdf->Cell(60, 6, utf8_decode($price . "$"), '1', 1, 'R');

$pdf->Output();

?>