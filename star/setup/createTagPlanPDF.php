<?php
require('fpdf17/fpdf.php');

$kpis = "Visites|Leads|Conversions";
$clientName = 'Direct Energie';
$typeTag = "Pixel";
$idsite = 1;
$urlTracker = "tracker.reeperf.com";

class PDF extends FPDF
{
	// En-tête
	function Header()
	{
		// Logo
		$this->Image('../img/leadsmonitor.png',10,6,30);
		// Police Arial gras 15
		$this->SetFont('Arial','B',15);
		// Décalage à droite
		$this->Cell(70);
		// Titre
		$this->Cell(50,10,'Plan de taggage',1,0,'C');
		// Saut de ligne
		$this->Ln(20);
	}

	// Pied de page
	function Footer()
	{
		// Positionnement à 1,5 cm du bas
		$this->SetY(-15);
		// Police Arial italique 8
		$this->SetFont('Arial','I',8);
		// Numéro de page
		$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	}
	
	function TitreTag($num, $libelle)
	{
		// Titre
		$this->SetFont('Arial','',12);
		$this->SetFillColor(200,220,255);
		$this->Cell(0,6,"Chapitre $num : $libelle",0,1,'L',true);
		$this->Ln(4);
		// Sauvegarde de l'ordonnée
		$this->y0 = $this->GetY();
	}
	
	function CorpsTagPixel($idsite, $urlTracker)
	{
		// Police
		$this->SetFont('Times','',12);
		// Sortie du texte sur 6 cm de largeur
		$this->Cell(100,5,'<img src="https://'.$urlTracker.'/reeperf.php?idsite='.$idsite.'&rec=1" style="border:0;" alt="" />');
		$this->Ln();
		// Mention
		$this->SetFont('','I');
		//$this->Cell(0,5,"(fin de l'extrait)");
		// Retour en première colonne
		//$this->SetCol(0);
	}
	
	function AjouterTag($num, $tag, $typeTag, $idsite, $urlTracker)
	{
		// Ajout du chapitre
		$this->AddPage();
		$this->TitreTag($num,$tag);
		if ($typeTag == "Pixel")
			$this->CorpsTagPixel($idsite, $urlTracker);
		//else
		//	$this->CorpsTagCookie($tag);
	}
}
echo "Test";
// Instanciation de la classe dérivée
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->AjouterTag(1, "Visites", $typeTag, $idsite, $urlTracker);

$pdf->SetFont('Times','',12);
echo "Test2";
$pdf->Output();
echo "Test3";
//$pdf->Output("example.pdf", 'D');
?>