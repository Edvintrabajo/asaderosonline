<?php
function codificarHTML($html) {
    return htmlspecialchars($html, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8");
}

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
?>