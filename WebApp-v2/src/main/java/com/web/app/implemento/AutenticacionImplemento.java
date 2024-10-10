package com.web.app.implemento;


import com.web.app.clases.Usuario;
import com.web.app.repositorio.UsuarioRepositorio;
import com.web.app.servicio.AutenticacionServicio;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.stereotype.Service;

@Service
public class AutenticacionImplemento  implements AutenticacionServicio {

    @Autowired
    private UsuarioRepositorio usuarioRepositorio;


    @Override
    public Usuario autenticar(String usuario, String contraseña) throws Exception {

           try {
               Usuario user = usuarioRepositorio.findByEmailAndPassword(usuario,contraseña);
               return user;
           }catch (Exception e) {
                 return null;
           }



    }
}
