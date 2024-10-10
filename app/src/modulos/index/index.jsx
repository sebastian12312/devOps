import { useEffect, useState } from "react"; // Mantén esta importación.
import { useNavigate } from 'react-router-dom'; // Elimina la segunda importación de 'useState'
import Swal from 'sweetalert2'
export const Index = () => {
    const [usernameState, setUserName] = useState();
    const [passwordState, setPassword] = useState();
    const navigate = useNavigate();
    const Swal = require('sweetalert2')
    const userName = (e) => {
        setUserName(e.target.value);
    };

    const password = (e) => {
        setPassword(e.target.value);
    };

    const iniciarSesion = (e) => {
        e.preventDefault();
        console.log(usernameState + " " + passwordState);

        async function validarDatos() {
            try {
                const response = await fetch('http://192.168.18.230:8089/autenticacion', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        username: usernameState,
                        password: passwordState,
                    }),
                });

                if (!response.ok) {
                    throw new Error('Error al iniciar sesión');
                    Swal.fire({
                      title: 'Error!',
                      text: 'Credenciales Incorrecta',
                      icon: 'error',
                      confirmButtonText: 'regresar'
                    })
                }

                const data = await response.json();
                  if(data){
                    Swal.fire({
                      position: "top-end",
                      icon: "success",
                      title: "Iniciando sesion  ",
                      showConfirmButton: false,
                      timer: 1000
                    });
                    navigate("/index"); 
                  }
            
            } catch (Exception) {
            
                Swal.fire({
                  title: 'Error!',
                  text: 'Credenciales Incorrecta',
                  icon: 'error',
                  confirmButtonText: 'regresar'
                })

            }
        }

        validarDatos();
    };

    return (
        <div className="flex justify-center items-center h-screen bg-gray-200">
            <div className=" flex flex-col lg:flex-row justify-center items-center lg:space-x-8 p-4 lg:p-12 rounded-2xl w-full lg:w-auto bg-gray-50 shadow-lg">

                <div className="w-full lg:w-[350px] bg-white p-6 rounded-lg shadow-md border border-gray-100">
                    <form action="" method="POST">
                        <div className="mb-4">
                            <label htmlFor="username" className="block text-gray-600 font-semibold">Username*:</label>
                            <input
                                type="text"
                                id="username"
                                name="username"
                                onChange={userName}
                                className="border border-gray-300 rounded-lg px-4 py-2 mt-1 w-full focus:ring-2 focus:ring-gray-400 outline-none shadow-sm"
                            />
                        </div>

                        <div className="mb-4">
                            <label htmlFor="password" className="block text-gray-600 font-semibold">Password*:</label>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                onChange={password}
                                className="border border-gray-300 rounded-lg px-4 py-2 mt-1 w-full focus:ring-2 focus:ring-gray-400 outline-none shadow-sm"
                            />
                        </div>
                        <div className="flex text-gray-500 hover:text-gray-600 transition duration-200 text-sm gap-2">
                          <input type="checkbox" className="w-4"/>
                          <p>Guardar sesion</p>
                        </div>
                        <a href="#" className="text-gray-500 hover:text-gray-600 transition duration-200 text-sm">Recuperar contraseña!</a>

                        <div className="mt-6 flex justify-center">
                            <button
                                onClick={iniciarSesion}
                                className="bg-gray-700 text-white px-6 py-2 rounded-lg shadow-md hover:bg-gray-800 transition duration-300"
                            >
                                Iniciar sesión
                            </button>
                        </div>
                    </form>
                </div>

                <div className="mt-8 lg:mt-0">
                    <img src="/img/6343825.jpg" alt="Imagen" className="w-full lg:w-[35rem] rounded-lg shadow-lg" />
                </div>
            </div>
        </div>
    );
};
