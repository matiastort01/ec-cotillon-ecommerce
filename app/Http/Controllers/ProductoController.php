<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;
use Barryvdh\DomPDF\Facade as PDF;
use Mpdf\Mpdf;
use Illuminate\Support\Facades\Response;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ProductoController extends Controller
{
    public function exportExcel() {
        // Obtener los datos de la base de datos
        $productos = Producto::all();

        // Crear una nueva hoja de cálculo
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Encabezados de las columnas
        $headers = ['Nombre', 'Descripción', 'Precio', 'Stock'];

        // Escribir los encabezados en la primera fila
        foreach ($headers as $index => $header) {
            $sheet->setCellValue(chr(65 + $index) . '1', $header);  // Usar A1, B1, C1, etc.
        }

        // Escribir los datos
        $row = 2; // Comenzamos desde la fila 2
        foreach ($productos as $producto) {
            $sheet->setCellValue('A' . $row, $producto->nombre_producto); // Columna A
            $sheet->setCellValue('B' . $row, $producto->descripcion_producto); // Columna B
            $sheet->setCellValue('C' . $row, $producto->precio); // Columna C
            $sheet->setCellValue('D' . $row, $producto->stock); // Columna D
            $row++;
        }

        // Crear un escritor para el archivo Excel
        $writer = new Xlsx($spreadsheet);

        // Nombre del archivo Excel
        $fileName = "listado_productos.xlsx";

        // Crear un archivo temporal en disco
        $tempFilePath = storage_path('app/public/listado_productos.xlsx');

        // Guardar el contenido del archivo temporal
        $writer->save($tempFilePath);

        // Enviar el archivo como respuesta para descargar
        return response()->download($tempFilePath)->deleteFileAfterSend(true);
    }

    public function exportPDF() {
        $productos = Producto::all();

        // Crear una instancia de mPDF
        $mpdf = new Mpdf();

        // Contenido HTML para el PDF
        $html = view("admin.productos-export-pdf", ['productos' => $productos])->render();

        // Escribir el contenido HTML al PDF
        $mpdf->WriteHTML($html);

        // Salida: Descargar el archivo como "mi_documento.pdf"
        $mpdf->Output("listado_productos.pdf", \Mpdf\Output\Destination::DOWNLOAD);
    }

    public function exportCSV() {
        $productos = Producto::all();

        // Crear el contenido del CSV
        $callback = function () use ($productos) {
            // Abrir un stream de salida para escribir el CSV
            $file = fopen('php://output', 'w');

            // Escribir la primera fila (encabezados)
            fputcsv($file, mb_convert_encoding(['Nombre', 'Descripción', 'Precio', 'Stock'], 'UTF-16', 'auto'), ';');

            // Escribir los datos de cada producto
            foreach ($productos as $producto) {
                $row = [
                    $producto->nombre_producto,
                    $producto->descripcion_producto,
                    $producto->precio,
                    $producto->stock,
                ];

                // Convierto los caracteres a UTF-8
                fputcsv($file, mb_convert_encoding($row, 'UTF-16', 'auto'), ';');
            }

            // Cerrar el archivo
            fclose($file);
        };

        // Nombre del archivo CSV
        $fileName = "productos.csv";

        // Configurar los encabezados para descarga
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            "Content-Disposition" => "attachment; filename=$fileName",
        ];

        // Retornar la respuesta con el archivo CSV
        return response()->stream($callback, 200, $headers);
    }

    public function index(Request $request) {

        $productos = Producto::paginate(3);

        if ($request->ajax()) {
            // Devuelve una respuesta JSON con las dos partes: productos y paginación

            return response()->json([
                'productos' => view('productos_js', ['productos' => $productos])->render(),
                'paginacion' => view('productos_paginacion', ['productos' => $productos])->render(),
            ]);
        }

        return view('welcome', [
            'productos' => $productos,
        ]);
    }


    /* old index
    public function index()
    {

        $productos = Producto::paginate(3);

        return view('welcome', [
            'productos' => $productos,
        ]);
    }
    */

    public function admin_productos_index()
    {
        $productos = Producto::all();

        return view('admin.abm-productos', [
            'productos' => $productos,
        ]);
    }

    // Deprecated
    public function productosPorCategoria($id)
    {
        $categoria = Categoria::findOrFail($id);

        $productos = Producto::where('id_categoria', $id)->paginate(3);

        return view('productos-filtrados', [
            'productos' => $productos,
            'categoria' => $categoria,
        ]);
    }

    public function search(Request $request) {
        // Captura el término de búsqueda
        $producto = $request->input('producto');

        // Inicializa la consulta base
        $query = Producto::query();

        // Filtro por nombre del producto
        if ($producto) {
            $query->where('nombre_producto', 'like', "%$producto%");
        }

        // Filtro por categorías
        if ($request->has('categorias')) {
            $categorias = $request->input('categorias');
            $query->whereIn('id_categoria', $categorias);
        }

        // Filtro por rango de precio
        if ($request->has('precio_min') && $request->input('precio_min') !== null) {
            $precioMin = max($request->input('precio_min'), 0);
        }
        else {
            $precioMin = 0; // Si no hay valor, toma 0
        }

        // Busco el precio maximo para el filtro
        $precioMax = $query->max('precio');

        if ($request->has('precio_max') && $request->input('precio_max') !== null) {
            $precioMax = min($request->input('precio_max'), $precioMax); // Si no hay valor, toma el maximo posible
        }

        $query->whereBetween('precio', [$precioMin, $precioMax]);

        // Paginación
        $productos = $query->paginate(6);

        // Pasar datos adicionales como categorías para los filtros
        $categorias = Categoria::all();

        return view('search-productos', [
            'productos' => $productos,
            'categorias' => $categorias,
            'precioMax' => $precioMax
        ]);
    }

    public function create() {
        $categorias = Categoria::all();

        return view('admin.store-producto', compact('categorias')); //admin/store-producto es la vista en la carpeta de views
    }

    public function store(Request $request) {
        $datos = $request->validate([
            'nombre_producto' => 'required|string|max:100',
            'descripcion_producto' => 'required|string|max:255',
            'precio' => 'required',
            'stock' => 'required',
            'estado' => 'required',
            'id_categoria' => 'required|integer', // Cambiado a id_categoria
            'url_producto' => 'required|image',
        ], [
            "required" => "Este campo es obligatorio!",
            "nombre_producto.max" => "La cantidad máxima de caracteres son 100!",
            "descripcion_producto.max" => "La cantidad máxima de caracteres son 255!",
            "image" => "El archivo debe ser una imagen!"
        ]);

        // Manejar la imagen
        $urlImagen = null;
        if ($request->hasFile('url_producto')) {
            // Guardar la imagen en la carpeta 'images/productos'
            $archivo = $request->file('url_producto');
            $nombreArchivo = uniqid() . '.' . $archivo->getClientOriginalExtension();
            $archivo->move(public_path('images/productos'), $nombreArchivo);

            // Generar la URL relativa para almacenar en la base de datos
            $urlImagen = 'images/productos/' . $nombreArchivo;
        }

        $datos["url_producto"] = $urlImagen;

        // Buscamos la categoria asociada al id_categoria
        $categoria = Categoria::find($request->id_categoria);

        if (!$categoria) {
            return redirect()->back()->with('warning', 'La categoría seleccionada no existe.');
        }

        Producto::create($datos);

        return redirect()->route('admin.productos')->with('success', 'Producto agregado exitosamente.');
    }

    public function edit($id_producto) {
        $producto = Producto::findOrFail($id_producto);
        $categorias = Categoria::all();

        return view('admin.edit-producto', compact('producto', 'categorias'));
    }

    public function update(Request $request, $id_producto) {

        $producto = Producto::findOrFail($id_producto);

        $datos = $request->validate([
            'nombre_producto' => 'required|string|max:100',
            'descripcion_producto' => 'required|string|max:255',
            'precio' => 'required',
            'stock' => 'required',
            'estado' => 'required',
            'id_categoria' => 'required|integer', // Cambiado a id_categoria
            'url_producto' => 'image'
        ], [
            "required" => "Este campo es obligatorio!",
            "nombre_producto.max" => "La cantidad máxima de caracteres son 100!",
            "descripcion_producto.max" => "La cantidad máxima de caracteres son 255!",
            "image" => "El archivo debe ser una imagen!"
        ]);


        // Manejar la imagen (si se sube una nueva)
        if ($request->hasFile('url_producto')) {
            // Eliminar la imagen anterior si existe
            if ($producto->url_producto && file_exists(public_path($producto->url_producto))) {
                unlink(public_path($producto->url_producto));
            }

            // Guardar la nueva imagen
            $archivo = $request->file('url_producto');
            $nombreArchivo = uniqid() . '.' . $archivo->getClientOriginalExtension();
            $archivo->move(public_path('images/productos'), $nombreArchivo);

            // Generar la URL relativa para almacenar en la base de datos
            $producto->url_producto = 'images/productos/' . $nombreArchivo;
        }

        $categoria = Categoria::find($request->id_categoria);

        if (!$categoria) {
            return redirect()->back()->with('warning', 'La categoría seleccionada no existe.');
        }

        $producto->nombre_producto = $datos["nombre_producto"];
        $producto->descripcion_producto = $datos["descripcion_producto"];
        $producto->precio = $datos["precio"];
        $producto->stock = $datos["stock"];
        $producto->estado = $datos["estado"];
        $producto->id_categoria = $datos["id_categoria"];

        $producto->save();

        return redirect()->route('admin.productos')->with('success', 'Producto actualizado exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id_producto)
    {
        $producto = Producto::findOrFail($id_producto);
        //$producto = Producto::where('nombre_producto',$nombre_producto)->get();
        return view('producto-ver-mas', ['producto' => $producto]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_producto)
    {
        $producto = Producto::findOrFail($id_producto);
        $producto->delete();

        // Obtener la ruta de la imagen desde la base de datos
        $imagenRuta = public_path($producto->url_producto);

        // Verificamos si la imagen existe en la ruta
        if ($producto->url_producto && file_exists($imagenRuta)) {
            // Eliminar la imagen del producto
            unlink($imagenRuta);
        }

        return redirect()->route('admin.productos')->with('success', 'Producto eliminado con éxito.');
    }
}
