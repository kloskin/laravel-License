<?php

namespace App\Http\Controllers;

use App\Models\LicenseCategory;
use Illuminate\Http\Request;

class LicenseCategoryController extends Controller
{
    public function index()
    {
        $categories = LicenseCategory::all();
        return view('license_categories.index', compact('categories'));
    }

    public function create()
    {
        return view('license_categories.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);

        LicenseCategory::create($request->only('name','description'));
        return redirect()->route('license_categories.index')->with('status', 'Kategoria utworzona!');
    }

    public function show(LicenseCategory $licenseCategory)
    {
        return view('license_categories.show', compact('licenseCategory'));
    }

    public function edit(LicenseCategory $licenseCategory)
    {
        return view('license_categories.edit', compact('licenseCategory'));
    }

    public function update(Request $request, LicenseCategory $licenseCategory)
    {
        $request->validate(['name' => 'required']);

        $licenseCategory->update($request->only('name', 'description'));
        return redirect()->route('license_categories.index')->with('status', 'Kategoria zaktualizowana!');
    }

    public function destroy(LicenseCategory $licenseCategory)
    {
        $licenseCategory->delete();
        return redirect()->route('license_categories.index')->with('status', 'Kategoria usunięta!');
    }
}
