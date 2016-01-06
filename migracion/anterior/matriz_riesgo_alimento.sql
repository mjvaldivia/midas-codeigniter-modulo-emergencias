UPDATE sipresa_dev.matriz_riesgo_alimento
SET mpa_c_clasificacion = 
	CASE
		WHEN mpa_f_puntaje > 0 AND mpa_f_puntaje <=2 THEN "A"
		WHEN mpa_f_puntaje > 2 AND mpa_f_puntaje <=3 THEN "B"
		WHEN mpa_f_puntaje > 3 AND mpa_f_puntaje <=4 THEN "C"
		WHEN mpa_f_puntaje > 4 AND mpa_f_puntaje <=5 THEN "D"
		WHEN mpa_f_puntaje > 5 AND mpa_f_puntaje <=6 THEN "E"
		WHEN mpa_f_puntaje > 6 AND mpa_f_puntaje <=7 THEN "F"
		WHEN mpa_f_puntaje > 7 AND mpa_f_puntaje <=8 THEN "G"
		WHEN mpa_f_puntaje > 8 THEN "H"
	END;
