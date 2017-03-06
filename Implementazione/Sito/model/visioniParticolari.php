<?php
  ### file pdf della visione dei particolari
  // inclusione del file per la connessione al DB
  include_once "../connection.php";
  // start della sessione
  session_start();
  // richiesta per la libreria pdf
  require('../pdf/fpdf.php');
  $query="";
  $colonne="";
  $where="";
  // faccio un controllo se sono stati inviati come post i checkbox, se sono checkati verranno inviati come post, altrimenti no
  if(isset($_POST["cerca"])){
    // se è checckato il docente allora seleziona il nome e il cognome del docente
    if(isset($_POST["docente"])){
      $colonne.="CONCAT(ut.ute_cognome,' ',ut.ute_nome) AS 'docente',";
    }
    // se è checkata la materia, allora viene selezionata la materia nella query
    if(isset($_POST["materia"])){
      $colonne.="ma.mat_nome AS 'materia',";
    }
    // se è checckato il corso, allora seleziona il corso
    if(isset($_POST["tipo"])){
      $colonne.="co.cor_nome AS 'corso',";
    }
    // se è checkata la classe, allora viene selezionata la classe nella query
    if(isset($_POST["classe"])){
      $colonne.="cl.cla_nome AS 'classe',";
    }
    // se è checckato il ciclo, allora seleziona l'inizio e la fine del corso
    if(isset($_POST["durata"])){
      $colonne.="co.cor_durata AS 'durata',";
    }
    // se è checckato il ciclo, allora seleziona l'inizio e la fine del corso
    if(isset($_POST["ore"])){
      $colonne.="pi.pia_ore_tot AS 'ore sem.',";
    }
    // se è checckato il ciclo, allora seleziona l'inizio e la fine del corso
    if(isset($_POST["ore"])){
      $colonne.="pi.pia_sem AS 'sem',";
    }
    // se è checckato il ciclo, allora seleziona l'inizio e la fine del corso
    if(isset($_POST["ciclo"])){
      $colonne.="CONCAT(pi.pia_ini_anno,'--',pi.pia_fin_anno) AS  'ciclo',";
    }
    // se è checckato il ciclo, allora seleziona l'inizio e la fine del corso
    if(isset($_POST["AIT"])){
      $colonne.="CONCAT(ROUND(if(pi.pia_ore_AIT is null,0,pi.pia_ore_AIT)/pia_ore_tot*100,2),'%') as '% AIT',";
    }
    // cancella l'ultima virgola della SELECT
    $colonne=substr($colonne,0,count($colonne)-2);
    // filtraggio della barra di ricerca tramite where
    if(!empty($_POST["cerca"])){
      $where.=" where ";
      $ricerca = $_POST["cerca"];
      $option = explode(" ",$ricerca);
      for($i=0;$i<count($option);$i++){
        $where .=" (ut.ute_cognome like '%".$option[$i]."%' OR ut.ute_nome like '%".$option[$i]."%' OR cl.cla_nome like '%".$option[$i]."%'
        OR ma.mat_nome like '%".$option[$i]."%' OR co.cor_nome like '%".$option[$i]."%' OR co.cor_durata like '%".$option[$i]."%' OR pi.pia_ini_anno like '%".$option[$i]."%'
        OR pi.pia_fin_anno like '%".$option[$i]."%' OR pi.pia_ore_tot like '%".$option[$i]."%' OR pi.pia_ore_AIT like '%".$option[$i]."%')";
        if($i<count($option)-1){
          $where.=" AND ";
        }
      }
    }
    // scrittura della query
    $query="SELECT ".$colonne." FROM pianifica pi
    JOIN classe cl ON cl.cla_id = pi.cla_id
    JOIN materia ma ON ma.mat_id = pi.mat_id
    JOIN corso co ON co.cor_id = pi.cor_id
    JOIN utente ut ON ut.ute_email = pi.ute_email ".$where." AND pi.pia_flag=1;";
    $result = $newDB->query($query);
    $queryEmail = "SELECT CONCAT(ute_cognome,' ',ute_nome) AS 'utente' FROM utente WHERE ute_email ='".$_SESSION['email']."';";
    $resultQuery = $newDB->query($queryEmail);
    $dum = $resultQuery->fetch_assoc();
    $utente =  $dum['utente'];

    ### creazione del file pdf
    // creazione della classe PDF per l'intestazione
    class PDF extends FPDF{
      public $ute;
      public function setUte($input){
          $this->ute = $input;
      }
      function Header()
      {
          $date = time();
          $date = date("d/m/Y H:i",$date);
          // Arial bold 15
          $this->SetFont('Arial','',12);
          // utente
          $this->Cell(100,10,"Creato da: ".$this->ute,0,0,'L');
          // logo
          $this->Image('../img/logo.png',130,6,30);
          // spazio per mettere la data all'angolo
          $this->Cell(120,10,"",0,0,'L');
          // data
          $this->Cell(100,10,"Data: ".$date,0,0,'L');
          // Line break
          $this->Ln(20);
      }
    }
    $pdf = new PDF("L"); // istanzio il pdf in landscape
    $pdf->setUte($utente); // inserisco l utente nella classe
    $pdf->AddPage();
    // setto il font di scrittura
		$pdf->SetFont('Arial','B',12);
    $width=0; // larghezza delle colonne
    $title=array(); // array per i nomi delle colonne
    // riempimento di title
    while ($finfo = $result->fetch_field()) {
      $nome = $finfo->name;
      array_push($title,$nome);
    }
    //cella di spazio laterale sinistro
  //  $pdf->Cell(10,7,"",0,0,'L',0);
    // set della grandezza a dipendenza di quale colonna stiamo parlando
    for ($i=0; $i < count($title); $i++) {
      switch ($title[$i]){
          case '% AIT':
          case 'durata':
          case 'classe':
          case 'sem':
          case 'ore sem.':
              $width=20;
              break;
          case 'ciclo':
          case 'materia':
              $width=30;
              break;
          default:
              $width=50;
              break;
      }
      // stampo nella cella il nome della colonna
      $pdf->Cell($width,7,$title[$i],1,0,'L',0);
    }
    // vado a capo
    $pdf->Cell(0,7,'','',1,'L',0);
    // setto il font
		$pdf->SetFont('Arial','',10);
    // faccio un while riga per riga cosi da avere una select per ciclo
    while($row = $result->fetch_array()){
      //cella di spazio laterale sinistro
    //  $pdf->Cell(10,7,"",0,0,'L',0);
      // faccio un for colonna per colonna per avere la colonna a dipendeza della riga
      for ($j=0; $j < $result->field_count; $j++) {
        // setto la larghezza delle celle
        switch ($title[$j]){
          case '% AIT':
          case 'classe':
          case 'durata':
          case 'sem':
          case 'ore sem.':
              $width=20;
              break;
          case 'ciclo':
          case 'materia':
              $width=30;
              break;
          default:
              $width=50;
              break;
        }
        //stampo il dato
        $pdf->Cell($width,7,$row[$j],1,0,'L',0);
      }
      //vado a capo
      $pdf->Cell(0,7,'','',1,'L',0);
    }
    // stampo il file pdf
    $pdf->Output();
    // creazione del log
    $newDB->createLog($_SESSION['email'],"informazione","creazione di un file pdf");
  }
?>
