<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Models\Medicamento;
use App\Http\Requests\MedicamentoRequest;
use Illuminate\Http\Request;

class MedicamentoController extends Controller
{
    
    public function __construct()
    {
        $this-> middleware('can:admin.medicamento.index')->only('index');
        $this-> middleware('can:admin.medicamento.create')->only('create', 'store');        
        $this-> middleware('can:admin.medicamento.edit')->only('edit', 'update');
        $this-> middleware('can:admin.medicamento.destroy')->only('destroy');
    }
    
    public function index()
    {
        $medicamentos = Medicamento::all();
        return view('admin.medicamento.index', compact('medicamentos'));
    }

     public function create()
    {
        ;
        return view('admin.medicamento.create');
    }
    
    public function store1(MedicamentoRequest $request)
    {
        Medicamento::create($request->all());
        
        Cache::flush();
        return redirect()->route('admin.medicamento.index')-> with('info', 'Medicamento Creado correctamente');;

    } 
    
    public function lista()
    {
        $medicamentos = Medicamento::all(); // Suponiendo que tienes una tabla "medicamentos" en la base de datos

        $medicamentoList = [];
        foreach ($medicamentos as $medicamento) {
            $medicamentoList[$medicamento->id] = $medicamento->nombre_completo;
        }

        return response()->json($medicamentoList);
    }

    
    public function store(Request $request)
    {
        // Realiza las validaciones necesarias para los campos del formulario
        $request->validate([
            'nombre' => 'required',
            'comercial' => 'nullable',
            'concentracion' => 'nullable',
            'presentacion' => 'nullable',
        ]);

        // Crea una nueva instancia del modelo Medicamento y asigna los valores del formulario
        $medicamento = new Medicamento();
        $medicamento->nombre = $request->input('nombre');
        $medicamento->comercial = $request->input('comercial');
        $medicamento->concentracion = $request->input('concentracion');
        $medicamento->presentacion = $request->input('presentacion');

        // Intenta guardar el medicamento en la base de datos
        try {
            $medicamento->save();
        } catch (\Exception $e) {
            // Si ocurre un error, devuelve una respuesta de error
            return response()->json(['error' => 'Error al guardar el medicamento'], 500);
        }

        // Si se guardó exitosamente, devuelve una respuesta con el ID del nuevo medicamento
        return response()->json(['medicamentoId' => $medicamento->id], 200);
    }

    public function edit($id)
    {
        $medicamento = Medicamento::where('id', $id)->firstOrFail();
        
        return view('admin.medicamento.edit', compact('medicamento'));
    }

     public function update(MedicamentoRequest $request, $id)
    {
        $medicamento = Medicamento::findOrFail($id);

       
        $medicamento->update($request->all());
        
        Cache::flush();
        return redirect()->route('admin.medicamento.index')-> with('info', 'Datos Actualizados correctamente');;

       
    }
       
    public function destroy($id)
    {
        
        $medicamento = Medicamento::findOrFail($id);
        $medicamento->delete();

        Cache::flush();
        return redirect()->route('admin.medicamento.index')-> with('eliminar', 'ok');
  
    }
}
