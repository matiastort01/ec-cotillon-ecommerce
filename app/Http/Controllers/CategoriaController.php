<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;
use Mpdf\Mpdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_cat()
    {
        $categorias = Categoria::paginate(6);

        $parametros = [
            "categorias" => $categorias
        ];

        return view('categorias', $parametros);
    }

    public function adminIndex()
    {
        $categorias = Categoria::all();
        return view('admin.abm-categorias', compact('categorias'));
    }

    public function destroy($id_categoria)
    {
        $categoria = Categoria::findOrFail($id_categoria);

        // Verificar si hay productos asociados
        if ($categoria->productos()->exists()) {
            return redirect()->route('admin.categorias')
                ->with('warning', 'No se puede eliminar la categoría porque está asociada a productos.');
        }

        // Si no hay productos asociados, elimina la categoría
        $categoria->delete();

        return redirect()->route('admin.categorias')
            ->with('success', 'Categoría eliminada correctamente.');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /* Esto solo retorna la vista */
    public function create()
    {
        return view('admin.store-categoria');
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'nombre_categoria' => 'required|string|max:255',
            'descripcion_categoria' => 'required|string',
            'url_categoria' => 'required|image'
        ], [
            "required" => "Este campo es obligatorio!",
            "image" => "El archivo debe ser una imagen!"
        ]);

        // Manejar la imagen
        $urlImagen = null;
        if ($request->hasFile('url_categoria')) {
            // Guardar la imagen en la carpeta 'images/categorias'
            $archivo = $request->file('url_categoria');
            $nombreArchivo = uniqid() . '.' . $archivo->getClientOriginalExtension();
            $archivo->move(public_path('images/categorias'), $nombreArchivo);

            // Generar la URL relativa para almacenar en la base de datos
            $urlImagen = 'images/categorias/' . $nombreArchivo;
        }

        $datos["url_categoria"] = $urlImagen;

        Categoria::create($datos);

        return redirect()->route('admin.categorias')->with('success', 'Categoría agregada exitosamente.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function edit($id_categoria)
    {
        $categoria = Categoria::findOrFail($id_categoria);
        return view('admin.edit-categoria', compact('categoria'));
    }

    public function update(Request $request, $id_categoria)
    {
        $categoria = Categoria::findOrFail($id_categoria);

        // Validaciones basicas, despues toca agregar mas
        $datos = $request->validate([
            'nombre_categoria' => 'required|string|max:255',
            'descripcion_categoria' => 'required|string',
            'url_categoria' => 'image'
        ], [
            "required" => "Este campo es obligatorio!",
            "image" => "El archivo debe ser una imagen!"
        ]);

        // Manejar la imagen (si se sube una nueva)
        if ($request->hasFile('url_categoria')) {
            // Eliminar la imagen anterior si existe
            if ($categoria->url_categoria && file_exists(public_path($categoria->url_categoria))) {
                unlink(public_path($categoria->url_categoria));
            }

            // Guardar la nueva imagen
            $archivo = $request->file('url_categoria');
            $nombreArchivo = uniqid() . '.' . $archivo->getClientOriginalExtension();
            $archivo->move(public_path('images/categorias'), $nombreArchivo);

            // Generar la URL relativa para almacenar en la base de datos
            $categoria->url_categoria = 'images/categorias/' . $nombreArchivo;
        }

        $categoria->nombre_categoria = $datos["nombre_categoria"];
        $categoria->descripcion_categoria = $datos["descripcion_categoria"];

        // Actualizar la categoría
        $categoria->save();

        // Redirigir con mensaje de éxito
        return redirect()->route('admin.categorias')->with('success', 'Categoría actualizada exitosamente.');
    }

    public function exportPDF() {
        $categorias = Categoria::all();

        // Crear una instancia de mPDF
        $mpdf = new Mpdf();

        // Contenido HTML para el PDF
        $html = view("admin.categorias-export-pdf", ['categorias' => $categorias])->render();

        // Escribir el contenido HTML al PDF
        $mpdf->WriteHTML($html);

        // Salida: Descargar el archivo como "listado_categorias.pdf"
        $mpdf->Output("listado_categorias.pdf", \Mpdf\Output\Destination::DOWNLOAD);
    }

    public function exportCSV() {
        $categorias = Categoria::all();

        // Crear el contenido del CSV
        $callback = function () use ($categorias) {
            // Abrir un stream de salida para escribir el CSV
            $file = fopen('php://output', 'w');

            // Escribir la primera fila (encabezados)
            fputcsv($file, mb_convert_encoding(['Nombre', 'Descripción'], 'UTF-16', 'auto'), ';');

            // Escribir los datos de cada categoria
            foreach ($categorias as $categoria) {
                $row = [
                    $categoria->nombre_categoria,
                    $categoria->descripcion_categoria
                ];

                // Convierto los caracteres a UTF-8
                fputcsv($file, mb_convert_encoding($row, 'UTF-16', 'auto'), ';');
            }

            // Cerrar el archivo
            fclose($file);
        };

        // Nombre del archivo CSV
        $fileName = "categorias.csv";

        // Configurar los encabezados para descarga
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            "Content-Disposition" => "attachment; filename=$fileName",
        ];

        // Retornar la respuesta con el archivo CSV
        return response()->stream($callback, 200, $headers);
    }

    public function exportExcel() {
        // Obtener los datos de la base de datos
        $categorias = Categoria::all();

        // Crear una nueva hoja de cálculo
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Encabezados de las columnas
        $headers = ['Nombre', 'Descripción'];

        // Escribir los encabezados en la primera fila
        foreach ($headers as $index => $header) {
            $sheet->setCellValue(chr(65 + $index) . '1', $header);  // Usar A1, B1, C1, etc.
        }

        // Escribir los datos
        $row = 2; // Comenzamos desde la fila 2
        foreach ($categorias as $categoria) {
            $sheet->setCellValue('A' . $row, $categoria->nombre_categoria); // Columna A
            $sheet->setCellValue('B' . $row, $categoria->descripcion_categoria); // Columna B
            $row++;
        }

        // Crear un escritor para el archivo Excel
        $writer = new Xlsx($spreadsheet);

        // Nombre del archivo Excel
        $fileName = "listado_categorias.xlsx";

        // Crear un archivo temporal en disco
        $tempFilePath = storage_path('app/public/listado_categorias.xlsx');

        // Guardar el contenido del archivo temporal
        $writer->save($tempFilePath);

        // Enviar el archivo como respuesta para descargar
        return response()->download($tempFilePath)->deleteFileAfterSend(true);
    }
}

