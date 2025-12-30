<?php

namespace App\Http\Controllers;

use App\Models\CapFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class CapController extends Controller
{
    public function index()
    {
        $caps = CapFile::with('user')->latest()->paginate(10);
        return view('admin.cap_upload', compact('caps'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cap_file' => 'required|file|mimes:pdf|max:10240', // 10MB max
        ], [
            'cap_file.required' => 'Please select a PDF file to upload',
            'cap_file.mimes' => 'Only PDF files are allowed',
            'cap_file.max' => 'File size must not exceed 10MB',
        ]);

        try {
            $file = $request->file('cap_file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('cap_files', $fileName, 'public');

            CapFile::create([
                'file_path' => $fileName,
                'user_id' => auth()->id(),
                'original_name' => $file->getClientOriginalName(),
            ]);

            return redirect()->route('admin.cap.index')->with('success', 'CAP file uploaded successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to upload file. Please try again.');
        }
    }

    public function download($id)
    {
        $cap = CapFile::findOrFail($id);
        $filePath = storage_path('app/public/cap_files/' . $cap->file_path);

        if (!file_exists($filePath)) {
            return back()->with('error', 'File not found');
        }

        return response()->download($filePath, $cap->original_name);
    }

    public function destroy($id)
    {
        $cap = CapFile::findOrFail($id);
        $filePath = 'cap_files/' . $cap->file_path;

        try {
            if (Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }

            $cap->delete();
            return redirect()->route('admin.cap.index')->with('success', 'File deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete file. Please try again.');
        }
    }
}