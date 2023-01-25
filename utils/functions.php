<?php

/**
 * Función para codificar el HTML
 * @param string $html
 * @return string
 */
function codificarHTML($html) {
    return htmlspecialchars($html, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8");
}

/**
 * Función para validar el registro
 * @param string $nombre
 * @param string $passwd
 * @param string $passwd2
 * @param string $email
 * @param string $telefono
 * @return array con el mensaje de error y si hay error o no
 */
function validateregister($nombre, $passwd, $passwd2, $email, $telefono) {
    $resultado['error'] = false;
    $resultado['mensaje'] = 'Usuario registrado correctamente';
    if (empty($nombre)) {
        $resultado['error'] = true;
        $resultado['mensaje'] = 'El nombre no puede estar vacío';
        return $resultado;
    } else if (empty($passwd)) {
        $resultado['error'] = true;
        $resultado['mensaje'] = 'La contraseña no puede estar vacía';
        return $resultado;
    } else if (empty($email)) {
        $resultado['error'] = true;
        $resultado['mensaje'] = 'El email no puede estar vacío';
        return $resultado;
    } else if (empty($telefono)) {
        $resultado['error'] = true;
        $resultado['mensaje'] = 'El telefono no puede estar vacío';
        return $resultado;
    }

    if (strlen($nombre) < 3) {
        $resultado['error'] = true;
        $resultado['mensaje'] = 'El nombre debe tener al menos 3 caracteres';
        return $resultado;
    } else if (strlen($passwd) < 6) {
        $resultado['error'] = true;
        $resultado['mensaje'] = 'La contraseña debe tener al menos 6 caracteres';
        return $resultado;
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $resultado['error'] = true;
        $resultado['mensaje'] = 'El email no es válido';
        return $resultado;
    } else if (!is_numeric($telefono)) {
        $resultado['error'] = true;
        $resultado['mensaje'] = 'El telefono no es válido';
        return $resultado;
    }

    if ($passwd != $passwd2) {
        $resultado['error'] = true;
        $resultado['mensaje'] = 'Las contraseñas no coinciden';
        return $resultado;
    }

    if (!preg_match('/[A-Z]/', $passwd ) || !preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $passwd )) {
        $resultado['error'] = true;
        $resultado['mensaje'] = 'La contraseña debe tener al menos una mayúscula y un caracter especial';
        return $resultado;
    }
    return $resultado;
};

/**
 * Función para validar los datos al crear un asadero
 * @param string $nombre
 * @param string $lugar
 * @param string $fecha
 * @param string $descripcion
 * @param string $precio
 * @param string $maxpersonas
 * @return array
 */
function validatecrearasadero($nombre, $lugar, $fecha, $descripcion, $precio, $maxpersonas) {
    $resultado['error'] = false;
    $resultado['mensaje'] = 'Asadero creado correctamente';
    if (empty($nombre)) {
        $resultado['error'] = true;
        $resultado['mensaje'] = 'El nombre del asadero no puede estar vacío';
        return $resultado;
    } else if(empty($lugar)) {
        $resultado['error'] = true;
        $resultado['mensaje'] = 'El lugar del asadero no puede estar vacío';
        return $resultado;
    }else if(strtotime($fecha) < strtotime(date("Y-m-d"))) {
        $resultado['error'] = true;
        $resultado['mensaje'] = 'La fecha debe ser posterior a hoy';
        return $resultado;
    } else if(empty($descripcion)) {
        $resultado['error'] = true;
        $resultado['mensaje'] = 'La descripción del asadero no puede estar vacía';
        return $resultado;
    } else if($precio <= 0) {
        $resultado['error'] = true;
        $resultado['mensaje'] = 'El precio debe ser mayor a 0';
        return $resultado;
    } else if($maxpersonas <= 0) {
        $resultado['error'] = true;
        $resultado['mensaje'] = 'El máximo de personas debe ser mayor a 0';
        return $resultado;
    } 
    return $resultado;
}
?>