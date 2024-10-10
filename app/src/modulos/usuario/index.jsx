import { motion } from 'framer-motion';
import { useEffect, useState } from 'react';

import { BsChevronLeft } from "react-icons/bs";
import { useAnimate, stagger } from "framer-motion";
import { BsChevronDown, BsBell, BsChatLeftDots, BsEnvelopeOpen   } from 'react-icons/bs';


const staggerMenuItems = stagger(0.1, { startDelay: 0.15 });
function useMenuAnimation(isOpen) {
  const [scope, animate] = useAnimate();

  useEffect(() => {
    // Animar la rotación de la flecha
    animate('.arrow', { rotate: isOpen ? 180 : 0 }, { duration: 0.2 });

    // Animar el clipPath del menú
    animate(
      'ul',
      {
        clipPath: isOpen
          ? 'inset(0% 0% 0% 0% round 10px)'
          : 'inset(10% 50% 90% 50% round 10px)',
      },
      {
        type: 'spring',
        bounce: 0,
        duration: 0.5,
      }
    );

    // Animar los elementos de la lista
    animate(
      'li',
      isOpen
        ? { opacity: 1, scale: 1, filter: 'blur(0px)' }
        : { opacity: 0, scale: 0.3, filter: 'blur(20px)' },
      {
        duration: 0.2,
        delay: isOpen ? staggerMenuItems : 0,
      }
    );
  }, [isOpen]);

  return scope;
}

export const UsuarioIndex = () => {
  const [isOpen, setIsOpen] = useState(false);
  const scope = useMenuAnimation(isOpen);

  useEffect(() => {
    const caracteres = document.getElementById("caracteres-container");

    if (caracteres) {
      let texto = caracteres.textContent || caracteres.innerText;

      // Si el texto es mayor a 20 caracteres, truncar y añadir '...'
      if (texto.length > 20) {
        texto = texto.substring(0, 17) + ". . .";
      }
      // Si el texto es menor a 20 caracteres, completar hasta que tenga 20 caracteres
      else if (texto.length < 20) {
        const completar = "...".substring(0, 20 - texto.length);
        texto = texto + completar;
      }

      // Actualizar el texto en el elemento HTML
      caracteres.textContent = texto;
    }
  }, []);


  return (
    <div className="flex">
      <div>
        <MenuLateralUsuario />
      </div>
      <div className="bg-gray-200 w-screen h-screen">
        <div className="w-full bg-white p-4">
          <div className="flex justify-between items-center">
            <div className="flex items-center gap-2">
              <div className="border p-2 text-black bg-gray-800 text-white rounded shadow-sm cursor-pointer">
                <BsChevronLeft />
              </div>
              <h1 className="text-2xl">Dashboard</h1>
            </div>

            <div className='flex gap-2'>
              <div className='hover:bg-gray-700 cursor-pointer bg-gray-800 p-2.5 rounded text-white shadow-sm text-xl m-auto'>
                <BsEnvelopeOpen />
              </div>
              <div className='hover:bg-gray-700 cursor-pointer bg-gray-800 p-2.5 rounded text-white shadow-sm text-xl m-auto'>
                  <BsChatLeftDots />
              </div>
              <div className='hover:bg-gray-700 cursor-pointer bg-gray-800 p-2.5 rounded text-white shadow-sm text-xl m-auto'>
                  <BsBell/>
              </div>
              <div className=''>
                <nav className="menu relative" ref={scope}>
                  <motion.button
                    whileTap={{ scale: 0.97 }}
                    onClick={() => setIsOpen((prev) => !prev)}
                    className="flex items-center p-2 bg-gray-800 hover:bg-gray-700 text-white rounded focus:outline-none shadow-sm"
                 
                  >
                    <p    id='caracteres-container'>   SEBASTIAN BARRIENTOS(BGS)</p>
                 
                    <div className="arrow ml-2" style={{ transformOrigin: '50% 55%' }}>
                      <BsChevronDown />
                    </div>
                  </motion.button>
                  <motion.ul
                    className={`transition-all duration-300 ease-in-out absolute w-full bg-gray-800 text-white mt-2 border ${isOpen ? 'block' : 'hidden'}`}
                    style={{
                      pointerEvents: isOpen ? 'auto' : 'none',
                      clipPath: isOpen
                        ? 'inset(0% 0% 0% 0% round 10px)'
                        : 'inset(10% 50% 90% 50% round 10px)',
                    }}
                  >
                    <motion.li className="p-2 hover:bg-gray-700 cursor-pointer">Perfil</motion.li>
                    <motion.li className="p-2 hover:bg-gray-700 cursor-pointer">Ajustes</motion.li>
                    <motion.li className="p-2 hover:bg-gray-700 cursor-pointer">Help</motion.li>
                    <motion.li className="p-2 hover:bg-gray-700 cursor-pointer">Ver sesiones</motion.li>
                    <motion.li className="p-2 bg-red-800 hover:bg-red-700 cursor-pointer">cerrar sesion</motion.li>
                  </motion.ul>
                </nav>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

const MenuLateralUsuario = () => {
  const [openMenu, setOpenMenu] = useState(null);

  const toggleMenu = (menuIndex) => {
    if (openMenu === menuIndex) {
      setOpenMenu(null); // Cierra si ya está abierto
    } else {
      setOpenMenu(menuIndex); // Abre el menú seleccionado
    }
  };

  const menuVariants = {
    open: {
      height: 'auto',
      opacity: 1,
      transition: { duration: 0.5 }
    },
    closed: {
      height: 0,
      opacity: 0,
      transition: { duration: 0.5 }
    }
  };

  return (
    <div className="w-[200px] h-screen border bg-white p-4 shadow-xl">
      <div className='mb-8'>
        <h1 className='text-center'>Titulo Proyecto</h1>
        <img src="" alt="img" className='w-full border h-16' />
      </div>
      <div className="space-y-4">

        {/* Menú 1 */}
        <div>
          <a
            className="bg-gray-800 w-full flex p-2 rounded-t-lg text-white cursor-pointer shadow-md transition-all duration-200 hover:bg-gray-700"
            onClick={() => toggleMenu(1)}
          >
            dashbord
          </a>
          <motion.ul
            className="overflow-hidden bg-gray-100 w-full rounded-b-lg shadow-sm"
            initial={false}
            animate={openMenu === 1 ? 'open' : 'closed'}
            variants={menuVariants}
          >
            <li>
              <a href="#" className="block py-1 hover:bg-gray-300 hover:text-gray-800 transition-colors duration-200 p-2">
                Opción 1.1
              </a>
            </li>
            <li>
              <a href="#" className="block py-1 hover:bg-gray-300 hover:text-gray-800 transition-colors duration-200 p-2">
                Opción 1.2
              </a>
            </li>
            <li>
              <a href="#" className="block py-1 hover:bg-gray-300 hover:text-gray-800 transition-colors duration-200 p-2">
                Opción 1.3
              </a>
            </li>
            <li>
              <a href="#" className="block py-1 hover:bg-gray-300 hover:text-gray-800 transition-colors duration-200 p-2">
                Opción 1.4
              </a>
            </li>
          </motion.ul>
        </div>

        {/* Menú 2 */}
        <div>
          <a
            className="bg-gray-800 w-full flex p-2 rounded-t-lg text-white cursor-pointer shadow-md transition-all duration-200 hover:bg-gray-700"
            onClick={() => toggleMenu(2)}
          >
            Usuarios
          </a>
          <motion.ul
            className="overflow-hidden bg-gray-100 w-full rounded-b-lg shadow-sm"
            initial={false}
            animate={openMenu === 2 ? 'open' : 'closed'}
            variants={menuVariants}
          >
            <li>
              <a href="#" className="block py-1 hover:bg-gray-300 hover:text-gray-800 transition-colors duration-200 p-2">
                Opción 2.1
              </a>
            </li>
            <li>
              <a href="#" className="block py-1 hover:bg-gray-300 hover:text-gray-800 transition-colors duration-200 p-2">
                Opción 2.2
              </a>
            </li>
            <li>
              <a href="#" className="block py-1 hover:bg-gray-300 hover:text-gray-800 transition-colors duration-200 p-2">
                Opción 2.3
              </a>
            </li>
            <li>
              <a href="#" className="block py-1 hover:bg-gray-300 hover:text-gray-800 transition-colors duration-200 p-2">
                Opción 2.4
              </a>
            </li>
          </motion.ul>
        </div>

        {/* Menú 3 */}
        <div>
          <a
            className="bg-gray-800 w-full flex p-2 rounded-t-lg text-white cursor-pointer shadow-md transition-all duration-200 hover:bg-gray-700"
            onClick={() => toggleMenu(3)}
          >
            Mesa Partes
          </a>
          <motion.ul
            className="overflow-hidden bg-gray-100 w-full rounded-b-lg shadow-sm"
            initial={false}
            animate={openMenu === 3 ? 'open' : 'closed'}
            variants={menuVariants}
          >
            <li>
              <a href="#" className="block py-1 hover:bg-gray-300 hover:text-gray-800 transition-colors duration-200 p-2">
                Opción 3.1
              </a>
            </li>
            <li>
              <a href="#" className="block py-1 hover:bg-gray-300 hover:text-gray-800 transition-colors duration-200 p-2">
                Opción 3.2
              </a>
            </li>
            <li>
              <a href="#" className="block py-1 hover:bg-gray-300 hover:text-gray-800 transition-colors duration-200 p-2">
                Opción 3.3
              </a>
            </li>
            <li>
              <a href="#" className="block py-1 hover:bg-gray-300 hover:text-gray-800 transition-colors duration-200 p-2">
                Opción 3.4
              </a>
            </li>
          </motion.ul>
        </div>

        {/* Menú 4 */}
        <div>
          <a
            className="bg-gray-800 w-full flex p-2 rounded-t-lg text-white cursor-pointer shadow-md transition-all duration-200 hover:bg-gray-700"
            onClick={() => toggleMenu(4)}
          >
            Roles
          </a>
          <motion.ul
            className="overflow-hidden bg-gray-100 w-full rounded-b-lg shadow-sm"
            initial={false}
            animate={openMenu === 4 ? 'open' : 'closed'}
            variants={menuVariants}
          >
            <li>
              <a href="#" className="block py-1 hover:bg-gray-300 hover:text-gray-800 transition-colors duration-200 p-2">
                Opción 4.1
              </a>
            </li>
            <li>
              <a href="#" className="block py-1 hover:bg-gray-300 hover:text-gray-800 transition-colors duration-200 p-2">
                Opción 4.2
              </a>
            </li>
            <li>
              <a href="#" className="block py-1 hover:bg-gray-300 hover:text-gray-800 transition-colors duration-200 p-2">
                Opción 4.3
              </a>
            </li>
            <li>
              <a href="#" className="block py-1 hover:bg-gray-300 hover:text-gray-800 transition-colors duration-200 p-2">
                Opción 4.4
              </a>
            </li>
          </motion.ul>
        </div>
      </div>
    </div>
  );

}