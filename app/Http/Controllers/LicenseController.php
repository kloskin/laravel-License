<?php

namespace App\Http\Controllers;

use App\Models\License;
use App\Models\LicenseCategory;
use Illuminate\Http\Request;

class LicenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Lista licencji, np. dostępna dla użytkowników
        $licenses = License::with('category')->get();
        return view('licenses.index', compact('licenses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Formularz tworzenia licencji (dla moderator/admin)
        $categories = LicenseCategory::all();
        return view('licenses.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'license_category_id' => 'required|exists:license_categories,id'
        ]);

        License::create($request->only('name', 'description', 'license_category_id'));
        return redirect()->route('licenses.index')->with('status', 'Licencja utworzona!');
    }

    /**
     * Display the specified resource.
     */
    public function show(License $license)
    {
        return view('licenses.show', compact('license'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(License $license)
    {
        $categories = LicenseCategory::all();
        return view('licenses.edit', compact('license', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, License $license)
    {
        $request->validate([
            'name' => 'required',
            'license_category_id' => 'required|exists:license_categories,id'
        ]);

        $license->update($request->only('name', 'description', 'license_category_id'));
        return redirect()->route('licenses.index')->with('status', 'Licencja zaktualizowana!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(License $license)
    {
        $license->delete();
        return redirect()->route('licenses.index')->with('status', 'Licencja usunięta!');
    }

    // Dodatkowa metoda do wyświetlania licencji użytkownika
    public function myLicenses()
    {
        $user = auth()->user();
        $licenses = $user->licenses()->with('category')->get();
        return view('licenses.my', compact('licenses'));
    }

    // Dodatkowa metoda do wyświetlania wszystkich licencji (np. dla moderatora/admina)
    public function all()
    {
        $licenses = License::with('category')->get();
        return view('licenses.all', compact('licenses'));
    }

}
