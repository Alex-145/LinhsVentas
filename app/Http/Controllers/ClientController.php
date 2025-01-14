<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::all();
        return view('clients.index', compact('clients'));
    }

    public function create()
    {
        return view('clients.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'dni_ruc' => 'required|string|max:20',
            'business_name' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:20',
        ]);

        Client::create($request->all());

        return redirect()->route('clients.index')->with('success', 'Client created successfully.');
    }

    public function show($id)
    {
        $client = Client::find($id);
        return view('clients.show', compact('client'));
    }

    public function edit($id)
    {
        $client = Client::find($id);
        return view('clients.edit', compact('client'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'dni_ruc' => 'required|string|max:20',
            'business_name' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:20',
        ]);

        $client = Client::find($id);
        $client->update($request->all());

        return redirect()->route('clients.index')->with('success', 'Client updated successfully.');
    }

    public function destroy($id)
    {
        Client::find($id)->delete();
        return redirect()->route('clients.index')->with('success', 'Client deleted successfully.');

    }
}
