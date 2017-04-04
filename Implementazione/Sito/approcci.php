<!-- © 2016-2017 Andrea Lupica (I4AC) ALL RIGHTS RESERVED -->
<?php
	### pagina per la pagina di approcci
	// inclusione del file per la connessione al DB
	include_once "connection.php";
	// per questa pagina è richiesto la libreria fpdf
	require('pdf/fpdf.php');
	// start della sessione
	session_start();
	if($_SESSION['email']!="" OR $_SESSION['email']!=null){
		$pdf = new FPDF(); // istanzio il pdf
		$pdf->AddPage();
		$width=22;
		$height=5;
		$nrighe=0; // variabile per sapere il numero di righe necessarie per ogni tabella
		// setto il font di scrittura
		$pdf->SetFont('Arial','B',12);
		// query per conoscere il corso e l'anno di inizio e di fine
		$sql = "SELECT co.cor_nome AS 'corso',pia_ini_anno AS 'inizio_anno',pia_fin_anno AS 'fine_anno' from pianifica pia
		join corso co on co.cor_id = pia.cor_id
		where pia_flag = 1
		group by pia_ini_anno,pia_fin_anno,pia.cor_id order by pia.pia_ini_anno,co.cor_nome";
		$result = $newDB->query($sql);
		while($row = $result->fetch_assoc()){
			$corso = $row["corso"];
			$inizio = $row["inizio_anno"];
			$fine = $row["fine_anno"];
			// per il nome delle tabelle
			$pdf->SetFont('Arial','B',12);
			$pdf->Cell($width,$height,$corso." ".$inizio." - ".($fine-1),0,0,'L',0);
			// vado a capo
			$pdf->Ln($height);
			// set colore riempimento
			$pdf->SetFillColor(204,255,255);
			// set font testo
			$pdf->SetFont('Arial','',10);
			// n tabella
			$tabella++;
			$pdf->setFillColor(230,230,230);
			// scrittura del nome delle colonne semestre
			for ($i=1; $i <9 ; $i++) {
				$pdf->Cell($width,$height,$i." sem.",1,0,'L',1);
			}
			// settaggio dello sfondo bianco
			$pdf->setFillColor(255,255,255);
			// vado a capo di una riga così da ritrovarmi esattamente sotto alla riga dei semestri
			$pdf->Ln($height);

			// query per le materie
			$sql = "SELECT ma.mat_nome AS 'materia',cl.cla_nome AS 'classe',pia_gruppo AS 'gruppo',pia_sem AS 'semestre' from pianifica pia
			join materia ma on ma.mat_id = pia.mat_id
			join corso co on co.cor_id = pia.cor_id
			join classe cl on cl.cla_id = pia.cla_id
			where co.cor_nome ='$corso' AND pia.pia_fin_anno = $fine AND pia.pia_ini_anno = $inizio AND pia_flag = 1 group by pia_gruppo order by cl.cla_nome,pia.pia_gruppo";
			// array bidimensionale per sapere [semestre]{corso coinvolto 1, corso coinvolto 2,...}
			$array=null;
			$res = $newDB->query($sql);
			while($row = $res->fetch_assoc()){
				$nSem=0;
				// se il nome della classe non contiene il valore B
				if(strpos($row['classe'],'B')!==false){
				}
				else{
					$classe = $row["classe"];
					// creo un for per la lunghezza della classe e cerco il numero che mi indichi l'anno
					for ($i=0; $i <strlen($classe) ; $i++) {
						// quando lo trovo lo assegno alla variabile del semestre
						if(is_numeric($classe[$i])){
							// metodo per indicare il semestre per ciclo formativo (da 1 a 8)
							$nSem = $classe[$i]*2-2;
						}
					}
					// sommo il nSem con il semestre della pianificazione per sapere il semestre corretto
					$nSem = $nSem+$row["semestre"];
					// nella posizione dell'array salvo l'id del gruppo
					$array[$nSem][]=$row["gruppo"];
				}
			}
			$riga=0;

			//  trovare il numero massimo di gruppi e avere così le righe
			// ho messo 8 poiché è essendo massimo 4 anni quindi 8 semestri ci possono essere al massimo 8 indici dell'array
			for ($i=0; $i <=8 ; $i++) {
				// metto come valore di riga sempre il numero più grande nell'array
				if($riga<count($array[$i])){
					$riga=count($array[$i]);
				}
			}
			// prendo l'anno corrente per indicare quali semestri dovrò evidenziare
			$evidenza = (date("Y") - $inizio)*2;
			for ($i=0; $i < $riga ; $i++) { // righe
				for ($j=1; $j <=8 ; $j++) { // colonne
					if($evidenza==$j OR $evidenza-1==$j){ // se la colonna corrisponde alla colonna da evidenziare o alla precedente
						$pdf->SetFillColor(255,255,155);
					}
					else{
						$pdf->SetFillColor(255,255,255);
					}
					$gruppo = $array[$j][$i];
					// se non è nullo e il gruppo non è quello precedente
					if($gruppo != null AND $gruppo!="" AND $array[$j][$i]!=$array[$j][$i-1]){
						// query per la selezione della materia a dipendenza  gruppo del corso e dell'anno di inizio e di fine
						$sqlGruppo = "SELECT ma.mat_nome AS 'materia' from pianifica pia
						join materia ma on ma.mat_id = pia.mat_id
						join corso co on co.cor_id = pia.cor_id
						join classe cl on cl.cla_id = pia.cla_id
						where co.cor_nome ='$corso' AND pia.pia_fin_anno = $fine AND pia.pia_ini_anno = $inizio AND pia.pia_gruppo=$gruppo AND pia_flag = 1 order by cl.cla_nome,pia.pia_gruppo";
						$resGruppo = $newDB->query($sqlGruppo);
						$stringa=" ";
						// salvataggio della posizione del cursore
						$x = $pdf->getX();
						$y = $pdf->getY();
						// copia della posizione
						$dumx=$x;
						$dumy=$y;
						// numero necessario per l'aggiunta righe nel caso fossero meno di 4
						$righeNecessarie=4;
						while($materie = $resGruppo->fetch_assoc()){
							$materia="";
							// gestione delle materie scritte troppo lunghe
							// se ha più di 10 caratteri
							if(strlen($materie["materia"])> 10){
								// divido le parole
								$exp = explode(" ",$materie["materia"]);

								// se è maggiore di 15 e meno di 20 caratteri ed è composto da più parole prendo solo la prima parola
								if(strlen($materie["materia"])>15 AND strlen($materie["materia"])<20  AND count($exp)>1){
									$materia=$exp[0];
								}
								else{
									for ($m=0; $m < count($exp); $m++) {
										// se la parola è più lunga di 4 lettere tronco a 4 caratteri e aggiungo il .
										if(strlen($exp[$m])>4){
											$str = substr($exp[$m],0,4);
											$materia=$materia.$str.". ";
										}
										else{
											$materia=$materia.$exp[$m]." ";
										}
									}
								}
							}
							else{
								$materia=$materie["materia"];
							}
							// rimuovo 1 riga necessaria poiché la aggiungo
							$righeNecessarie--;
							// se è la prima riga metti i bordi di lato e sopra
							if($righeNecessarie==3){
								$pdf->Cell($width,$height,$materia,"LRT",0,'L',1);
							}
							else if($righeNecessarie!=0){ // se non è l'ultima riga mostra i bordi destro e sinistro
								$pdf->Cell($width,$height,$materia,"LR",0,'L',1);
							}
							else{ // se è l'ultimo allora aggiungi anche il bordo sotto
								$pdf->Cell($width,$height,$materia,"LBR",0,'L',1);
							}
							// riposiziono la y sotto di una riga
							$dumy=$dumy+$height;
							$pdf->SetXY($x, $dumy);

						}
						// metto le righe necessari con i bordi sulla cella sui lati e sotto
						$pdf->Cell($width,$height*$righeNecessarie,"","BLR",0,'L',1);
						// mi posiziono a destra di una colonna con la y nella posizione iniziale (in riga con l'altra colonna)
						$pdf->SetXY($x+$width,$y);
					}
					else{
						// disegno una cella grande 4 senza scritte
						$pdf->Cell($width,$height*4,"",1,0,'L',1);
					}
				}
				// vado a capo di 4 righe
				$pdf->Ln($height*4);
			}
			// faccio uno spazio di 2 righe tra una tabella e l'altra
			$pdf->Ln($height*2);
			// se ci sono 3 tabelle in una pagina, aggiungo una pagina e inizio su quella
			if($tabella%3==0){
				$pdf->addPage();
			}
		}
		// stampo il tutto
		$pdf->Output();
	}
?>
