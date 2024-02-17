<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use App\Models\Code_products;
use App\Models\Model_Products;
use App\Models\Model_Receipt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Controller_Create_Products extends Controller
{
    public function index(Request $request)
    {
        try {
            // Obtener el número de pedido de la solicitud
            $orderNumber = $request->input('order_num', null);

            // Agregar un mensaje de depuración para verificar el número de orden
            Log::info("Order Number (provided): $orderNumber");

            // Obtener productos basados en el número de pedido (si se proporciona)
            $productos = $orderNumber
                ? Model_Products::where('order_num', $orderNumber)->where('state', 1)->with('code_products')->get()
                : collect();

            // Agregar un mensaje de depuración para verificar la cantidad de productos
            Log::info("Productos Count: " . $productos->count());

            // Obtener todos los recibos con estado 1
            $recibos = Model_Receipt::where('state', 1)->get();

            // Obtener todos los SKUs y descripciones disponibles
            $skus = Code_products::pluck('sku');
            $descripciones = Code_products::pluck('description');

            // Almacenar SKUs y descripciones en la sesión para su uso posterior
            session(['skus' => $skus, 'descriptions' => $descripciones]);

            // Pasar datos a la vista
            return view('Productos.index', compact('productos', 'orderNumber', 'recibos', 'skus', 'descripciones'));
        } catch (\Exception $e) {
            // Manejar excepciones proporcionando detalles en el log y mostrando un mensaje de consola
            Log::error("Error en ControllerCreateProducts@index: " . $e->getMessage());
            Log::error($e->getTraceAsString()); // Mostrar el rastreo de la pila en la consola
            return back()->withErrors(['error' => 'Ha ocurrido un error.']);
        }
    }

    public function create()
    {
        // Recuperar los SKUs almacenados en la sesión y ordenar alfabéticamente
        $skus = session('skus', collect())->sort()->values();

        // Obtener descripciones asociadas a SKUs y ordenar alfabéticamente
        $descripciones = Code_products::pluck('description')->sort()->values()->toArray();

        // Obtener recibos con estado 1 y ordenarlos por número de recibo
        $recibos = Model_Receipt::where('state', 1)->orderBy('order_num')->get();

        // Almacenar las descripciones en la sesión para su uso posterior
        session(['descripciones' => $descripciones]);

        // Configurar la vista con los datos necesarios antes de la condición
        return view('Productos.create', compact('recibos', 'skus', 'descripciones'));
    }

    public function obtenerSkus(Request $request)
    {
        $orderNum = $request->input('orderNum');

        // Obtén los SKUs asociados al número de recibo
        $skus = Model_Products::where('order_num', $orderNum)->distinct('sku')->pluck('sku');

        return response()->json($skus);
    }

    public function obtenerSkuPorDescripcion(Request $request)
    {
        $descripcion = $request->input('descripcion');

        // Realizar la consulta a la base de datos para obtener el SKU
        $codeProduct = Code_products::where('description', $descripcion)->first();

        if ($codeProduct) {
            $sku = $codeProduct->sku;
            return response()->json(['sku' => $sku]);
        } else {
            return response()->json(['sku' => null]);
        }
    }

    public function store(Request $request)
    {
        try {
            // Validación de datos
            $request->validate([
                // ... (tus reglas de validación)
            ], [
                // ... (tus mensajes de error personalizados)
            ]);

            // Crear instancia del modelo y asignar valores
            $producto = new Model_Products();
            $producto->sku = $request->sku;
            $producto->description = $request->description;
            $producto->unit_measurement = $request->unit_measurement;
            $producto->amount = $request->amount;
            $producto->gross_weight = $request->gross_weight;
            $producto->packaging_weight = $request->packaging_weight;
            $producto->net_weight = $request->net_weight;
            $producto->order_num = $request->orden_num;
            $producto->delivery_date = $request->delivery_date;
            $producto->criterium = $request->criterium;
            $producto->notes = $request->notes;
            $producto->code_customer = $request->code_customer;

            // Asignar el valor '1' al campo 'state'
            $producto->state = 1;

            // Intentar guardar el producto
            $producto->save();
            
            // Redirección después de guardar
            return redirect(route('create.index'));
        } catch (\Exception $e) {
            // Manejo del error
            return back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function obtenerInfoRecibo(Request $request)
    {
        $orderNum = $request->input('order_num');

        // Obtener información de recibo según el número de recibo
        $recibo = Model_Receipt::where('order_num', $orderNum)->first();

        if ($recibo) {
            return response()->json([
                'success' => true,
                'data' => [
                    'delivery_date' => $recibo->delivery_date,
                    'code_customer' => $recibo->code_customer,
                ],
            ]);
        } else {
            return response()->json([
                'success' => false,
            ], 404);
        }
    }
    public function obtenerProductosPorOrden($orderNum) {
        $productos = Model_Products::where('order_num', $orderNum)->get();
        return response()->json(['productos' => $productos]);
    }

}
