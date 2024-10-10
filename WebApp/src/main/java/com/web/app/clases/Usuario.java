package com.web.app.clases;

import lombok.Data;
import lombok.Generated;
import org.springframework.data.annotation.Id;

import java.sql.Time;
import java.util.Date;

@Data
public class Usuario {

    @Id
    private int id_usuario;
    private int tipo_documento;
    private String num_documento;
    private String nombre;
    private String primer_apellido;
    private String segundo_apellido;
    private String email;
    //private String telefono;
    private int genero;
    private int role;
    private Date fecha_creacion;
    private Time hora_creacion;
    private String id_encargado;
    private int estado;
}
