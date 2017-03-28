<?php
	### pagina per la pagina di approcci
	// inclusione del file per la connessione al DB
include_once "connection.php";
	// start della sessione
session_start();
if(($_SESSION['email']!="" OR $_SESSION['email']!=null) AND ($_SESSION["amministratore"]==1)){
	$sql = "SELECT co.cor_nome AS 'corso',pia_ini_anno AS 'inizio_anno',pia_fin_anno AS 'fine_anno' from pianifica pia
					join corso co on co.cor_id = pia.cor_id
 					where pia_flag = 1
					group by pia_ini_anno,pia_fin_anno,pia.cor_id order by pia.pia_ini_anno";
	//echo $sql."<br>";
	$result = $newDB->query($sql);
	while($row = $result->fetch_assoc()){
		$corso = $row["corso"];
		$inizio = $row["inizio_anno"];
		$fine = $row["fine_anno"];
		echo "corso: ".$corso." anno: ".$inizio." - ".$fine."<br>";
		$sql = "SELECT ma.mat_nome AS 'materia',cl.cla_nome AS 'classe',pia_gruppo AS 'gruppo',pia_sem AS 'semestre' from pianifica pia
		join materia ma on ma.mat_id = pia.mat_id
		join corso co on co.cor_id = pia.cor_id
		join classe cl on cl.cla_id = pia.cla_id
		where co.cor_nome ='$corso' AND pia.pia_fin_anno = $fine AND pia.pia_ini_anno = $inizio AND pia_flag = 1 group by pia_gruppo order by cl.cla_nome,pia.pia_gruppo";
		//echo $sql."<br>";
				$array=null;
		$res = $newDB->query($sql);
		while($row = $res->fetch_assoc()){
			$nSem=0;
			if(strpos($row['classe'],'B')!==false){
			}
			else{
				$classe = $row["classe"];
				// creo un for per la lunghezza della classe e cerco il numero che mi indichi l'anno
				for ($i=0; $i <strlen($classe) ; $i++) {
					// quando lo trovo lo assegno alla variabile del semestre
					if(is_numeric($classe[$i])){
						//echo $classe." ".$classe[$i]." ";
						$nSem = $classe[$i]*2-2;
					}
				}
				$nSem = $nSem+$row["semestre"];
				echo "classe: ".$row["classe"]." materia: ".$row["materia"]." sem: ".$nSem." gruppo: ".$row["gruppo"]."<br>";
				$array[$nSem][]=$row["gruppo"];
			}
		}
		print_r($array);echo "<br>";
	$riga=0;

	//echo "grandezza array: ".count($array)."<br>";
		//  trovare il numero massimo di gruppi e avere così le righe
		// ho messo 8 poiché è essendo massimo 4 anni quindi 8 semestri ci possono essere al massimo 8 indici dell'array
		for ($i=0; $i <=8 ; $i++) {
			//echo "r ".$riga." - c ".count($array[$i])."<br>";
			if($riga<count($array[$i])){
				$riga=count($array[$i]);
			}

		}
		//echo $array[2][1];

		echo "righe:".$riga."<br>";

		for ($i=0; $i < $riga ; $i++) { // righe
			for ($j=1; $j <=8 ; $j++) { // colonne
					echo $j."/".$i;
					//echo $array[2][1];
					$gruppo = $array[$j][$i];
					echo "tabella".$gruppo."<br>";
					if($gruppo != null AND $gruppo!="" AND $array[$j][$i]!=$array[$j][$i-1]){
						$sqlGruppo = "SELECT ma.mat_nome AS 'materia',cl.cla_nome AS 'classe',pia_gruppo AS 'gruppo',pia_sem AS 'semestre' from pianifica pia
						join materia ma on ma.mat_id = pia.mat_id
						join corso co on co.cor_id = pia.cor_id
						join classe cl on cl.cla_id = pia.cla_id
						where co.cor_nome ='$corso' AND pia.pia_fin_anno = $fine AND pia.pia_ini_anno = $inizio AND pia.pia_gruppo=$gruppo AND pia_flag = 1 order by cl.cla_nome,pia.pia_gruppo";
						//echo $sqlGruppo."<br>";
						$resGruppo = $newDB->query($sqlGruppo);
						$stringa=" ";
						while($materie = $resGruppo->fetch_assoc()){
							$stringa=$stringa." ".$materie["materia"];
							//echo $stringa;
						}
						//$pdf->Cell($width,$height,"c",1,0,'L',0);
					}
				else{
					//$pdf->Cell($width,$height*4,"",1,0,'L',0);
				}
			}
			//$pdf->Ln($height*4);
		}
	}
}
?>
