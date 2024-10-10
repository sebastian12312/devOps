package com.web.app.repositorio;

import com.web.app.clases.Usuario;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Query;
import org.springframework.data.repository.query.Param;
import org.springframework.stereotype.Repository;

@Repository
public interface UsuarioRepositorio extends JpaRepository<Usuario, Integer> {


    @Query("SELECT u FROM Usuario u WHERE u.email = :email AND u.contraseña = :contraseña")
    Usuario findByEmailAndPassword(@Param("email") String email, @Param("contraseña") String contraseña);
}
