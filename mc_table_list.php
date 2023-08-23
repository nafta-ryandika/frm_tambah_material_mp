<?php
require('../../fpdf16/fpdf.php');

class PDF_MC_Table extends FPDF
{
var $widths;
var $aligns;

function SetWidths($w)
{
	//Set the array of column widths
	$this->widths=$w;
}

function SetAligns($a)
{
	//Set the array of column alignments
	$this->aligns=$a;
}

function Row($data,$align,$column)
{
	//Calculate the height of the row
//        print_r ($arr_gambar);
	$nb=0;
	for($i=0;$i<count($data);$i++){
		$nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
        }
            $h=5*$nb;
	//Issue a page break first if needed
	$this->CheckPageBreak($h);
	//Draw the cells of the row
	for($i=0;$i<$column;$i++)
	{
		$w=$this->widths[$i];
        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : $align[$i];
		//Save the current position
		$x=$this->GetX();
		$y=$this->GetY();
                
                if($i == 0){
                   $this->MultiCell($w,5,$data[$i],0,$a,0);
                   $this->Rect($x,$y,$w,$h);
                }
                else {
                      $this->SetXY($x, $y);
                      $this->Rect($x,$y,30,$h);
                      $this->MultiCell(30, 5, $data[1], 0);
                      $x = $x+30;

                      $this->SetXY($x, $y);
                      $this->Rect($x,$y,50,$h);
                      $this->MultiCell(50, 5, $data[2], 0);
                      $x = $x+50;
                }
		$this->SetXY($x+$w,$y);
	}
	$this->Ln($h);
}

function CheckPageBreak($h)
{
	//If the height h would cause an overflow, add a new page immediately
	if($this->GetY()+$h>$this->PageBreakTrigger)
		$this->AddPage($this->CurOrientation);
}

function NbLines($w,$txt)
{
	//Computes the number of lines a MultiCell of width w will take
	$cw=&$this->CurrentFont['cw'];
	if($w==0)
		$w=$this->w-$this->rMargin-$this->x;
	$wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
	$s=str_replace("\r",'',$txt);
	$nb=strlen($s);
	if($nb>0 and $s[$nb-1]=="\n")
		$nb--;
	$sep=-1;
	$i=0;
	$j=0;
	$l=0;
	$nl=1;
	while($i<$nb)
	{
		$c=$s[$i];
		if($c=="\n")
		{
			$i++;
			$sep=-1;
			$j=$i;
			$l=0;
			$nl++;
			continue;
		}
		if($c==' ')
			$sep=$i;
		$l+=$cw[$c];
		if($l>$wmax)
		{
			if($sep==-1)
			{
				if($i==$j)
					$i++;
			}
			else
				$i=$sep+1;
			$sep=-1;
			$j=$i;
			$l=0;
			$nl++;
		}
		else
			$i++;
	}
	return $nl;
}
}
?>