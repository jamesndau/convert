<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use Illuminate\Support\Facades\Log;
use FFMpeg\Format\Audio\Wav;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ConvertController extends Controller
{
    public function convert(Request $request)
    {
    
        $request->validate([
            'file' => 'required|mimes:mp4|max:10240', 
        ]);


        $file = $request->file('file');
        $path = $file->store('uploads');
        $inputFile = storage_path('app/' . $path);

    
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $outputFile = storage_path('app/uploads/' . $originalName . '.wav');

        Log::info("Original file name: $originalName");
        Log::info("Input file path: $inputFile");
        Log::info("Output file path: $outputFile");

        try {
            Log::info("Starting conversion: $inputFile to $outputFile");

            
            $media = FFMpeg::fromDisk('local')
                ->open($path); 

            Log::info("Opened file: $inputFile");

        
            $media->export()
                ->toDisk('local')
                ->inFormat(new Wav())
                ->save('uploads/' . $originalName . '.wav');

            Log::info("Saved file: $outputFile");

           
            if (file_exists($outputFile)) {
                Log::info("File conversion successful: $outputFile");

                return response()->download($outputFile, $originalName . '.wav', [
                    'Content-Disposition' => 'attachment; filename="' . $originalName . '.wav"',
                ]);
            } else {
                Log::error('File conversion failed: Output file does not exist.');
                return response()->json(['error' => 'File conversion failed.'], 500);
            }
        } catch (\Exception $e) {
            Log::error('File conversion error: ' . $e->getMessage());
            return response()->json(['error' => 'File conversion failed: ' . $e->getMessage()], 500);
        }
    }
}
