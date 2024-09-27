package com.web.reporte.controlador;

import com.web.reporte.clases.Table_excel;
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

import java.io.IOException;
import java.util.ArrayList;
import java.util.Iterator;
import java.util.List;

@Controller
public class web {

    @GetMapping("/")
    public String main() {
        return "web/index";
    }

    @GetMapping("/cargar-archivo")
    public String cargarArchivo(Model model) {


        return  "web/cargar-archivo";
    }

    @PostMapping("/upload")
    public String subirArchivo(MultipartFile file, Model model) {
        Table_excel excelClase = new Table_excel();
       ArrayList<Table_excel> listaArrayExcel = new ArrayList<>();

        if (!file.isEmpty()) {
            System.out.println("RECEPCIONADO: " + file.getOriginalFilename());
            try {
                Workbook workbook = new XSSFWorkbook(file.getInputStream());
                Sheet sheet = workbook.getSheetAt(0); // Get the first sheet

                // Get the first row (row index 0)
                Row row = sheet.getRow(0);
                System.out.println(row);
                ArrayList<String > lista = new ArrayList<>();
                if (row != null) {
                    // Iterate through the cells in the first row
                    for (Cell cell : row) {
                        // Print the cell value

                        lista.add(cell.getStringCellValue());
                    }
                    System.out.println(lista);
                }


            } catch (IOException e) {


                throw new RuntimeException(e);
            }


        } else {
            System.out.println("ERROR: El archivo está vacío.");
        }

        //   System.out.println("Listar usuarios: " + data);
       // model.addAttribute("listar", data);
        return "redirect:/"; // Cambia esto para volver a la vista donde quieres mostrar la lista
    }
}
