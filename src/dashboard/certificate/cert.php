<?php

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../../service/connection.php';
include '../../service/utility.php';
require('../../service/fpdf186/fpdf.php');

// get user details
$getCert = $conn->query("SELECT c.*, cf.field_name, cf.field_value, u.*, e.*
            FROM certificates c
            JOIN certificate_fields cf ON c.id = cf.certificate_id 
            JOIN users u ON c.user_id = u.id 
            JOIN courses e ON c.event_id = e.id 
            WHERE c.certificate_code = '7SFVL9lmfz-2024'")->fetch_array();

header("content-type: application/png");

$fontBold = "../../assets/font/montserrat/static/Montserrat-Bold.ttf";
$font = "../../assets/font/montserrat/static/Montserrat-Light.ttf";

$width = 2000;
$height = 1414;

$time = time();

$img = imagecreatefrompng("../../assets/uploads/templates/" . $getCert['certificate_template'] . ".png");
$color = imagecolorallocate($img, 19, 21, 22);

$firstLineText = "Untuk menyelesaikan pelatihan " . $getCert['event_name'] . " yang";
$secondLineText = "diselenggarakan oleh " . $getCert['organizer'] . " pada " . hummanDate($getCert['event_date']);

$certificateIdCenter = calculateTextCenter($getCert['certificate_code'], $fontBold, 25);
$participantCenterName = calculateTextCenter($getCert['full_name'], $fontBold, 60);
$firstLineTextCenter = calculateTextCenter($firstLineText, $font, 29);
$secondLineTextCenter = calculateTextCenter($secondLineText, $font, 29);

$organizationCenter = calculateHalfWidthTextCenter($getCert['organizer'], $fontBold, 30);

imagettftext($img, 25, 0, $certificateIdCenter[0], $certificateIdCenter[1] + 600, $color, $fontBold, $getCert['certificate_code']);
imagettftext($img, 60, 0, $participantCenterName[0], $participantCenterName[1], $color, $fontBold, $getCert['full_name']);
imagettftext($img, 29, 0, $firstLineTextCenter[0], $firstLineTextCenter[1] + 100, $color, $font, $firstLineText);
imagettftext($img, 29, 0, $secondLineTextCenter[0], $secondLineTextCenter[1] + 150, $color, $font, $secondLineText);
imagettftext($img, 30, 0, $organizationCenter[0] + 30, 1130, $color, $fontBold, $getCert['organizer']);
imagettftext($img, 30, 0, 327.5 * 3.5 + 60, 1130, $color, $fontBold, "Drs. Lambas Pakpahan,MM"); // dont change this!


imagepng($img, "../../assets/uploads/certificates/certificates-$time-" . $getCert['certificate_code'] . ".png");
imagedestroy($img);

$pdf = new FPDF();
$pdf->AddPage("L", "A5");

$pdf->Image("../../assets/uploads/certificates/certificates-$time-" . $getCert['certificate_code'] . ".png", 0, 0, 210, 148);
ob_end_clean();
$pdf->Output();

function calculateTextCenter($text, $typeFont, $fontSize)
{
  global $height, $width;

  // Define the font size and path to the TTF font file
  // $fontSize = 60;

  $bbox = imagettfbbox($fontSize, 0, $typeFont, $text);

  // Calculate the width of the text
  $textWidth = abs($bbox[2] - $bbox[0]);

  // Calculate the x-coordinate to center the text
  $x = ($width - $textWidth) / 2;

  // Set the y-coordinate (you can adjust this value)
  $y = ($height / 2) + ($fontSize / 2);

  return [$x, $y];
}

function calculateHalfWidthTextCenter($text, $typeFont, $fontSize)
{
  global $height, $width;

  // Define the font size and path to the TTF font file
  // $fontSize = 60;

  $width = $width / 2;

  $bbox = imagettfbbox($fontSize, 0, $typeFont, $text);

  // Calculate the width of the text
  $textWidth = abs($bbox[2] - $bbox[0]);

  // Calculate the x-coordinate to center the text
  $x = ($width - $textWidth) / 2;

  // Set the y-coordinate (you can adjust this value)
  $y = ($height / 2) + ($fontSize / 4);

  return [$x, $y];
}
