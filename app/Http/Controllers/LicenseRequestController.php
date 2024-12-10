<?php

namespace App\Http\Controllers;

use App\Models\LicenseRequest;
use App\Models\License;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LicenseRequestController extends Controller
{
    public function index()
    {
        // Lista wniosków zalogowanego użytkownika
        $requests = LicenseRequest::where('user_id', Auth::id())->with('license')->get();
        return view('license_requests.index', compact('requests'));
    }

    public function create()
    {
        // Formularz stworzenia wniosku
        $licenses = License::all();
        return view('license_requests.create', compact('licenses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'license_id' => 'required|exists:licenses,id'
        ]);

        LicenseRequest::create([
            'user_id' => Auth::id(),
            'license_id' => $request->license_id,
            'status' => 'pending'
        ]);

        return redirect()->route('license_requests.index')->with('status', 'Wniosek złożony!');
    }

    public function show(LicenseRequest $licenseRequest)
    {
        // Szczegółowe informacje o wniosku (opcjonalnie)
        return view('license_requests.show', compact('licenseRequest'));
    }

    // Edycja i aktualizacja wniosku może nie być potrzebna,
    // ale jako resource controller mamy te metody:
    public function edit(LicenseRequest $licenseRequest)
    {
        // Opcjonalnie: edycja tylko jeśli status jest pending
        if ($licenseRequest->user_id !== Auth::id()) {
            abort(403);
        }
        return view('license_requests.edit', compact('licenseRequest'));
    }

    public function update(Request $request, LicenseRequest $licenseRequest)
    {
        // Aktualizacja wniosku - np. zmiana licencji o którą prosi
        if ($licenseRequest->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate(['license_id' => 'required|exists:licenses,id']);
        $licenseRequest->update([
            'license_id' => $request->license_id
        ]);

        return redirect()->route('license_requests.index')->with('status', 'Wniosek zaktualizowany!');
    }

    public function destroy(LicenseRequest $licenseRequest)
    {
        // Użytkownik może anulować wniosek
        if ($licenseRequest->user_id !== Auth::id()) {
            abort(403);
        }

        $licenseRequest->delete();
        return redirect()->route('license_requests.index')->with('status', 'Wniosek usunięty!');
    }

    // Metody dla moderatora/admina
    public function approve(LicenseRequest $licenseRequest)
    {
        $licenseRequest->update(['status' => 'accepted']);
        // Możesz tu dodać logikę tworzenia rekordu w user_licenses
        return redirect()->back()->with('status', 'Wniosek zatwierdzony!');
    }

    public function reject(LicenseRequest $licenseRequest)
    {
        $licenseRequest->update(['status' => 'rejected']);
        return redirect()->back()->with('status', 'Wniosek odrzucony!');
    }
}
