UPDATE lugares
SET LUG_localidad = REPLACE(LUG_localidad, 'A CoruÃ±a', 'A Coruña'),
    LUG_provincia = REPLACE(LUG_provincia, 'A CoruÃ±a', 'A Coruña'),
    LUG_delegacion = REPLACE(LUG_delegacion, 'A CoruÃ±a', 'A Coruña')
WHERE 
    LUG_id > 0; -- Cambia "ID" por el nombre de tu columna clave real


UPDATE lugares
SET LUG_nombre = REPLACE(LUG_nombre, 'Obra de la SeÃ±ora', 'Obra de la Señora')
WHERE 
    LUG_id > 0 AND LUG_nombre LIKE '%Obra de la SeÃ±ora%';


UPDATE lugares
SET LUG_nombre = REPLACE(LUG_nombre, 'SeÃ±ora de Isabel Becerra' , 'Señora de Isabel Becerra' )
WHERE 
    LUG_id > 0 AND LUG_nombre LIKE 'SeÃ±ora de Isabel Becerra';


UPDATE lugares
SET LUG_nombre = REPLACE(LUG_nombre, 'RecuperaciÃ³n de montes' , 'Recuperación de montes' )
WHERE 
    LUG_id > 0 AND LUG_nombre LIKE 'RecuperaciÃ³n de montes';


UPDATE lugares
SET LUG_nombre = REPLACE(LUG_nombre, 'Las AngÃ©licas' , 'Las Angélicas' )
WHERE 
    LUG_id > 0 AND LUG_nombre LIKE 'Las AngÃ©licas';


UPDATE lugares
SET LUG_nombre = REPLACE(LUG_nombre, 'Obra de La SeÃ±ora' , 'Obra de la Señora' )
WHERE 
    LUG_id > 0 AND LUG_nombre LIKE 'Obra de La SeÃ±ora';


UPDATE lugares
SET LUG_nombre = REPLACE(LUG_nombre, 'Hogar San JosÃ©' , 'Hogar San José' )
WHERE 
    LUG_id > 0 AND LUG_nombre LIKE 'Hogar San JosÃ©';

UPDATE lugares
SET LUG_nombre = REPLACE(LUG_nombre, 'CÃ¡ritas' , 'Cáritas' )
WHERE 
    LUG_id > 0 AND LUG_nombre LIKE 'CÃ¡ritas';

UPDATE lugares
SET LUG_nombre = REPLACE(LUG_nombre, 'Centro CÃ­vico de Teis' ,'Centro Cívico de Teis' )
WHERE 
    LUG_id > 0 AND LUG_nombre LIKE 'Centro CÃ­vico de Teis';
UPDATE lugares
SET LUG_nombre = REPLACE(LUG_nombre, 'Cocina econÃ³mica / asilo', 'Cocina económica / asilo' )
WHERE 
    LUG_id > 0 AND LUG_nombre LIKE 'Cocina econÃ³mica / asilo';


UPDATE lugares
SET LUG_localidad = REPLACE(LUG_localidad, 'NigrÃ¡n', 'Nigrán' )
WHERE 
    LUG_id > 0 AND LUG_localidad LIKE 'NigrÃ¡n';

UPDATE lugares
SET LUG_localidad = REPLACE(LUG_localidad, 'Salvaterra do MiÃ±o', 'Salvaterra do Miño' )
WHERE 
    LUG_id > 0 AND LUG_localidad LIKE 'Salvaterra do MiÃ±o';

UPDATE lugares
SET LUG_localidad = REPLACE(LUG_localidad, 'RaxÃ³', 'Raxó' )
WHERE 
    LUG_id > 0 AND LUG_localidad LIKE 'RaxÃ³';

UPDATE lugares
SET LUG_localidad = REPLACE(LUG_localidad, 'SÃ¡rdoma (Vigo)', 'Sárdoma (Vigo)' )
WHERE 
    LUG_id > 0 AND LUG_localidad LIKE 'SÃ¡rdoma (Vigo)';


UPDATE lugares
SET LUG_localidad = REPLACE(LUG_localidad, 'SanguiÃ±eda-Mos', 'Sanguiñeda-Mos')
WHERE 
    LUG_id > 0 AND LUG_localidad LIKE 'SanguiÃ±eda-Mos';