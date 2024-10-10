package com.web.app.servicio;

import com.web.app.clases.Usuario;

public interface AutenticacionServicio {
    Usuario autenticar(String usuario, String contraseña) throws Exception;
}
