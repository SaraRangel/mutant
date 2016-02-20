
<?php 

//converts array in super string separating elements with a comma
function getString($array){
	$cadena="";
	$new=Array();
	$rows=count($array);
	for($i=0; $i<$rows; $i++){
		$new[$i]= strtoupper(implode($array[$i]));
	}
	
	return join(",",$new);	
}

//convert columns in rows 
function transponse($array){
  array_unshift($array, null);
  return call_user_func_array('array_map', $array);
}

//get diagonals from right to left ignoring diagonals 
//with length <4
function getRightDiagonal($array){
	$diag_r=Array();
	$rows=count($array);
	for($t=$rows-4; $t>-1; $t--){
		$cadena="";
		$i=0;
		for($j=$t;$j<$rows;$j++){
			$cadena.= $array[$j][$i];
			$i++;
		}
		$diag_r[]=$cadena;
	}
	for($t=1; $t<$rows-3; $t++){
		$cadena="";
		$i=$t;
		for($j=0;$j<$rows-2;$j++){
			$cadena.= $array[$j][$i];
			$i++;
		}
		$diag_r[]=$cadena;
	}
	//print_r($diag_r);
	//echo "<br>";
	return $diag_r;
}

// inverts the order of columns in a 
function invertColumns($array){
	$new=Array();
	$rows=count($array);
	$cols=$rows-1;
	for($i=0; $i<$rows;$i++){
		$new[$cols]=$array[$i];
		$cols--;
	}
	return $new;
}

function isMutant($horizontal){
	$compara= ["AAAA", "GGGG", "CCCC", "TTTT"];
	$vertical= transponse($horizontal);
	
	$cont=0;
	
	$str_horizontal=getString($horizontal);
	$str_vertical=getString($vertical);
	$str_dr=strtoupper(join(",",getRightDiagonal($horizontal)));
	
	$vertical= invertColumns($vertical);
	$str_dl=strtoupper(join(",",getRightDiagonal($vertical)));
	
	echo $str_horizontal."<br>";
	echo $str_vertical."<br>";
	echo $str_dr."<br>";
	echo $str_dl."<br>";
	
	$cont=0;
	foreach($compara as $c){
		if(strpos( $str_horizontal,$c)!==false){
			$cont++;
		}
		if(strpos($str_vertical,$c)!==false){
			$cont++;
		}
		if(strpos($str_dr,$c)!==false){
			$cont++;
		}
		if(strpos($str_dl,$c)!==false){
			$cont++;
		}
		if($cont>=2){
				return true;
		}
				
	}
	return false;
}

//PROCESS POST
if(count($_POST) !== count($_POST[0]) || count($_POST)==0 || count($_POST)<4 ){
	echo "ERROR la secuencia de ADN debe ser una matriz.";
	exit(0);
}
if(isMutant($_POST)){
	header('Location:es-mutante.html');
}
else{
	header('Location: no-mutante.html');
}






?>