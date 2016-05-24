<?php

class Fechas{


	public static function formatearBaseDatos($fecha,$separador="-"){
		if(empty($fecha)){
			return '';
		}
		if (strpos($fecha, " ") !== false){
			$time = explode(" ",$fecha);
			return self::formatearBaseDatos($time[0]) . " " . $time[1];
		}else{
			$fecha = explode("/",$fecha);
			return $fecha[2] . $separador . $fecha[1] . $separador . $fecha[0];
		}


	}


	public static function formatearHtml($fecha,$separador="/"){
		if(empty($fecha)){
			return '';
		}
		if (strpos($fecha, " ") !== false){
			$time = explode(" ",$fecha);
			return self::formatearHtml($time[0]) . " " . $time[1];
		}else{
			$fecha = explode("-",$fecha);
			return $fecha[2] . $separador . $fecha[1] . $separador . $fecha[0];
		}
		
	}


	public static function traducirFecha($fecha){
		return str_replace('day','día',str_replace('mon','mes',str_replace('mons','meses',str_replace('year','año',$fecha))));
	}


	public static function fechaLiteral($fecha){
		$fecha = strftime("%e de %B de %Y",strtotime($fecha));
		$fecha = explode(" ",trim($fecha));

		return $fecha[0]." de ".ucfirst($fecha[2])." de ".$fecha[4]; 
	}


	public static function diffDias($fecha_i,$fecha_f,$solo_dias=false){
		if($solo_dias){
			$fecha_i = explode(" ",$fecha_i);
			$fecha_f = explode(" ",$fecha_f);
			$dias	= (strtotime($fecha_i[0])-strtotime($fecha_f[0]))/86400;
			$dias 	= abs($dias); $dias = floor($dias);		
			return $dias;
		}
		$dias	= (strtotime($fecha_i)-strtotime($fecha_f))/86400;
		$dias 	= abs($dias); $dias = floor($dias);		
		return $dias;
	}


	


	/**
	 * calcula la edad de una persona segun su fecha de nacimiento en formato AAAA-MM-DD
	 * @param  [type] $fecha_nacimiento [description]
	 * @return [type]                   [description]
	 */
	public function calcularEdad($fecha_nacimiento){
		list($ano,$mes,$dia) = explode("-",$fechanacimiento);
	    $ano_diferencia  = date("Y") - $ano;
	    $mes_diferencia = date("m") - $mes;
	    $dia_diferencia   = date("d") - $dia;
	    if ($dia_diferencia < 0 || $mes_diferencia < 0)
	        $ano_diferencia--;
	    return $ano_diferencia;
	}
}