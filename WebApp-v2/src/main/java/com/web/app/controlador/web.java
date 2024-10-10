package com.web.app.controlador;

import com.web.app.clases.Usuario;
import com.web.app.clases.UsuarioLogin;
import com.web.app.implemento.AutenticacionImplemento;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.sql.Timestamp;
import java.time.Instant;
import java.time.LocalDateTime;
import java.time.format.DateTimeFormatter;
import java.util.HashMap;
import java.util.List;
import java.util.Map;
import java.util.TimeZone;

@RestController
@CrossOrigin("http://localhost:3000")

public class web {

    @Autowired
    private AutenticacionImplemento autenticacionImplemento;

    @PostMapping("/autenticacion")
    public ResponseEntity<?> autenticacion(@RequestBody UsuarioLogin usuarioLogin, TimeZone timeZone) {
        Map<String, String> responseMap = new HashMap<>();
     try {
         Usuario user = autenticacionImplemento.autenticar(usuarioLogin.getUsername(), usuarioLogin.getPassword());
         if(user != null) {
             responseMap.put("dni", user.getNum_documento());
             responseMap.put("nombre", user.getNombre());
             responseMap.put("apellido_1", user.getPrimer_apellido());
             responseMap.put("apellido_2", user.getSegundo_apellido());
             responseMap.put("email", user.getEmail());
             return ResponseEntity.status(202).body(responseMap);
         }else {

             LocalDateTime ahora = LocalDateTime.now();
             DateTimeFormatter formatoCorto = DateTimeFormatter.ofPattern("dd-MM-yyyy, HH:mm");
             String fechaHoraCorta = ahora.format(formatoCorto);
             responseMap.put("timestamp", fechaHoraCorta.toString());
             responseMap.put("message", "error");
             return  ResponseEntity.status(404).body(responseMap);
         }

     }catch (Exception e) {
         return  ResponseEntity.status(404).body("Usuario no encontrado");
     }


    }
}
