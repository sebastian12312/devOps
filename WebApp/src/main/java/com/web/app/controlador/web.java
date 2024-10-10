package com.web.app.controlador;

import com.web.app.clases.UsuarioLogin;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

@RestController
@CrossOrigin("http://localhost:3000")

public class web {


    @PostMapping("/autenticacion")
    public ResponseEntity<?> autenticacion(@RequestBody UsuarioLogin usuarioLogin) {
        System.out.println("RESPUESTA USUARIO" + usuarioLogin);
        return  ResponseEntity.ok(usuarioLogin);
    }
}
