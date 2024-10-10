package com.web.app.clases;

import jakarta.persistence.Column;
import jakarta.persistence.Entity;
import jakarta.persistence.Table;
import jakarta.persistence.Id; // Asegúrate de que sea este
import lombok.Data;

import java.sql.Time;
import java.util.Date;

@Data
@Entity
@Table(name ="tb_usuario")
public class Usuario {

    @Id
    @Column(name = "id_usuario")
    private int id_usuario;

    @Column(name = "tipo_documento")
    private int tipo_documento;

    @Column(name = "num_documento")
    private String num_documento;

    @Column(name = "nombre")
    private String nombre;

    @Column(name = "primer_apellido")
    private String primer_apellido;

    @Column(name = "segundo_apellido")
    private String segundo_apellido;

    @Column(name = "email")
    private String email;

    @Column(name = "contraseña")
    private String contraseña;
    //private String telefono;

    @Column(name = "genero")
    private int genero;

    @Column(name = "role")
    private int role;

    @Column(name = "fecha_creacion")
    private Date fecha_creacion;

    @Column(name = "hora_creacion")
    private Time hora_creacion;

    @Column(name = "id_encargado")
    private String id_encargado;

    @Column(name = "estado")
    private int estado;

}
