import React from "react";
// React

import { useState } from "react";

export const HeaderUsuario= () =>{
    
    
    return(
        <>
           <header className="flex justify-between border shadow-sm px-6 py-6">
                <div>
                    <h1>Titulo Proyecto o Banner</h1>   
                </div>

                <div>
                    <ul className="flex gap-2">
                        <li><a href="#">Index</a></li>
                        <li><a href=""></a>Servicios</li>
                        <li><a href=""></a>aboutUs</li>
                        <li><a href=""></a>Contacto</li>
                        <li><a href="" className="border shadow-sm text-white bg-sky-700 px-4 py-2 rounded">iniciar sesion</a></li>
                        <li><a href="" className="border shadow-sm text-white bg-sky-700 px-4 py-2 rounded">registrate</a></li>
                    </ul>
                </div>
           </header>
        </>
    )
}

