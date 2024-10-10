import logo from './logo.svg';
import './App.css';
import { Index } from './modulos/index';
import { UsuarioIndex } from './modulos/usuario';
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';
function App() {
  return (
    <Router>
      <div className="App">
        <Routes>
          {/* Ruta para el login */}
          <Route path="/" element={<Index />} />
          {/* Ruta para la página protegida */}
          <Route path="/index" element={<UsuarioIndex />} />
        </Routes>
      </div>
    </Router>
  );
}

export default App;
