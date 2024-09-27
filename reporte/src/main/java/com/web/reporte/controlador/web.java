package com.web.reporte.controlador;

import org.apache.poi.ss.formula.functions.Column;
import org.apache.poi.ss.usermodel.Cell;
import org.apache.poi.ss.usermodel.Row;
import org.apache.poi.ss.usermodel.Sheet;
import org.apache.poi.ss.usermodel.Workbook;
import org.apache.poi.xssf.usermodel.XSSFWorkbook;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.multipart.MultipartFile;

import java.util.ArrayList;
import java.util.List;

@Controller
public class web {

    @GetMapping("/")
    public String main() {
        return "web/index";
    }

    @PostMapping("/upload")
    public String subirArchivo(MultipartFile file, Model model) {
        List<String> lista = new ArrayList<>();

        if (!file.isEmpty()) {
            System.out.println("RECEPCIONADO: " + file.getOriginalFilename());

            try (Workbook workbook = new XSSFWorkbook(file.getInputStream())) {
                Sheet sheet = workbook.getSheetAt(0);
                Row row = sheet.getRow(0);
                for (Cell cell : row) {
                    System.out.println(cell.getStringCellValue());
                    lista.add(cell.getStringCellValue());
                }
            } catch (Exception e) {
                e.printStackTrace(); // Para ver los errores en la consola
            }
        } else {
            System.out.println("ERROR: El archivo está vacío.");
        }

        System.out.println("Listar usuarios: " + lista);
        model.addAttribute("listar", lista);
        return "web/index"; // Cambia esto para volver a la vista donde quieres mostrar la lista
    }
}
