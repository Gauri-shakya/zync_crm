<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ClientController extends Controller
{
    private function baseQuery()
{
    return Client::where('company_id', auth()->user()->company_id);
}

    public function index()
    {
        $clients = $this->baseQuery()
            ->with(['leadAction.user'])
            ->latest()
            ->get();

        $closedLeads = \App\Models\ClosedLead::with(['lead.client', 'user', 'updater'])
            ->where('company_id', auth()->user()->company_id)
            ->latest()
            ->get();

        $servicesList = [
            'Web Development',
            'Mobile App',
            'E-commerce',
            'UI/UX Design',
            'Digital Marketing',
            'SEO',
            'Custom Software',
            'Other'
        ];

        $users = \App\Models\User::where('company_id', auth()->user()->company_id)->get();

        return view('admin.client', compact('clients', 'closedLeads', 'servicesList', 'users'));
    }


    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email',
            'alternate_email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'alternate_phone' => 'nullable|string|max:20',
            'status' => 'required|in:lead,qualified,proposal,negotiation,client,lost',
            'priority' => 'required|in:low,medium,high',
            'industry' => 'nullable|string|max:255',
            'budget' => 'nullable|numeric|min:0',
            'source' => 'required|in:website,referral,cold_outreach,social_media,event,other,uploaded_by_admin',
            'next_follow_up' => 'nullable|date',
            'notes' => 'nullable|string'
        ]);

        $client = Client::create($validated);
        
        // Notify all users except the creator
        $usersToNotify = \App\Models\User::where('id', '!=', auth()->id() ?? 0)->get();
        if ($usersToNotify->isNotEmpty()) {
            \Illuminate\Support\Facades\Notification::send($usersToNotify, new \App\Notifications\SystemNotification([
                'title' => 'New Lead Added',
                'message' => 'A new lead (' . $client->company_name . ') has been added.',
                'icon' => 'user-plus',
                'url' => route('clients.index')
            ]));
        }

        return response()->json([
            'success' => true,
            'message' => 'Client created successfully!',
            'client' => $client
        ]);
    }

  public function show(Client $client): JsonResponse
{
    $this->authorize('manage', $client);
    return response()->json($client);
}

  public function details(Client $client)
{
    $this->authorize('manage', $client);
    
    // If it already has a lead action, just show the normal myleads.show
    if ($client->leadAction) {
        return redirect()->route('myleads.show', $client->leadAction->id);
    }

    return view('admin.sales.client-show', compact('client'));
}

  public function edit(Client $client)
{
    $this->authorize('manage', $client);
    return view('admin.editlead', compact('client'));
}


public function update(Request $request, Client $client)
{
    $this->authorize('manage', $client);

    $validated = $request->validate([
        'company_name' => 'required|string|max:255',
        'contact_person' => 'required|string|max:255',
        'email' => ['required', 'email', Rule::unique('clients')->ignore($client->id)],
        'alternate_email' => 'nullable|email',
        'phone' => 'nullable|string|max:20',
        'alternate_phone' => 'nullable|string|max:20',
        'status' => 'required|in:lead,qualified,proposal,negotiation,client,lost',
        'priority' => 'required|in:low,medium,high',
        'industry' => 'nullable|string|max:255',
        'budget' => 'nullable|numeric|min:0',
        'source' => 'required|in:website,referral,cold_outreach,social_media,event,other,uploaded_by_admin',
        'next_follow_up' => 'nullable|date',
        'notes' => 'nullable|string'
    ]);

    $client->update($validated);

    return redirect()->route('clients.index')->with('success', 'Client updated successfully!');

    // return response()->json([
    //     'success' => true,
    //     'message' => 'Client updated successfully!',
    //     'client' => $client
    // ]);
}


public function destroy($id)
{
    $client = $this->baseQuery()->findOrFail($id);
    $this->authorize('manage', $client);

    $client->delete();

    return response()->json([
        'success' => true,
        'message' => 'Client deleted successfully!',
        'client_id' => $id
    ]);
}

    public function import(Request $request): JsonResponse
    {
        abort_if(!auth()->user()->hasRole('admin'), 403, 'Only admins can import clients.');
        
        $request->validate([
            'excel_file' => [
                'required',
                'file',
                function ($attribute, $value, $fail) {
                    $extension = strtolower($value->getClientOriginalExtension());
                    if (!in_array($extension, ['csv', 'xls', 'xlsx'])) {
                        $fail('The file must be a valid Excel or CSV file (xlsx, xls, csv). Notepad (.txt) files are not allowed.');
                    }
                },
            ],
        ]);

        try {
            $file = $request->file('excel_file');
            $results = $this->processExcelFile($file);
            
            if ($results['imported'] > 0) {
                $usersToNotify = \App\Models\User::where('id', '!=', auth()->id() ?? 0)->get();
                if ($usersToNotify->isNotEmpty()) {
                    \Illuminate\Support\Facades\Notification::send($usersToNotify, new \App\Notifications\SystemNotification([
                        'title' => 'New Leads Imported',
                        'message' => $results['imported'] . ' new leads have been imported and are available in the system.',
                        'icon' => 'upload',
                        'url' => route('clients.index')
                    ]));
                }
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Clients imported successfully!',
                'imported_count' => $results['imported'],
                'skipped_count' => $results['skipped'],
                'skipped_rows' => $results['skipped_rows']
            ]);
            
        } catch (\Throwable $e) {
            Log::error('Import error: ' . $e->getMessage());
            
            $errorMessage = 'An error occurred while importing the file.';
            if (str_contains($e->getMessage(), 'ZipArchive')) {
                $errorMessage = 'Your server is missing the PHP ZIP extension required for Excel (.xlsx) files. Please upload a .CSV file instead.';
            }
            
            return response()->json([
                'success' => false,
                'message' => $errorMessage
            ], 500);
        }
    }

    private function processExcelFile($file)
    {
        $path = $file->getRealPath();
        $extension = $file->getClientOriginalExtension();
        
        $data = [];
        
        if ($extension === 'csv') {
            $data = $this->readCSV($path);
        } else {
            $data = $this->readExcelWithPhp($path, $extension);
        }
        
        return $this->importClients($data);
    }

    private function readCSV($path)
    {
        $data = [];
        $handle = fopen($path, 'r');
        
        if ($handle === FALSE) {
            throw new \Exception('Could not open CSV file');
        }
        
        $headers = fgetcsv($handle); // Get column headers
        
        if ($headers === FALSE) {
            fclose($handle);
            throw new \Exception('CSV file is empty or invalid');
        }
        
        // Clean headers
        $headers = array_map('trim', $headers);
        $headers = array_map('strtolower', $headers);
        
        $rowCount = 1;
        while (($row = fgetcsv($handle)) !== FALSE) {
            $rowCount++;
            
            // Skip empty rows
            if (empty(array_filter($row))) {
                continue;
            }
            
            // Ensure row has same number of columns as headers
            if (count($row) !== count($headers)) {
                // Pad or truncate row to match headers count
                if (count($row) < count($headers)) {
                    $row = array_pad($row, count($headers), '');
                } else {
                    $row = array_slice($row, 0, count($headers));
                }
            }
            
            $rowData = array_combine($headers, $row);
            $data[] = $rowData;
        }
        fclose($handle);
        
        return $data;
    }

    private function readExcelWithPhp($path, $extension)
    {
        // For Excel files, we'll use a simpler approach with file reading
        // This method works for both .xls and .xlsx by converting them to temporary CSV
        $tempCsvPath = tempnam(sys_get_temp_dir(), 'excel_import_') . '.csv';
        
        try {
            if ($extension === 'xlsx') {
                $this->convertXlsxToCsv($path, $tempCsvPath);
            } else {
                $this->convertXlsToCsv($path, $tempCsvPath);
            }
            
            $data = $this->readCSV($tempCsvPath);
            
            // Clean up temporary file
            if (file_exists($tempCsvPath)) {
                unlink($tempCsvPath);
            }
            
            return $data;
            
        } catch (\Exception $e) {
            // Clean up temporary file on error
            if (file_exists($tempCsvPath)) {
                unlink($tempCsvPath);
            }
            throw new \Exception('Failed to read Excel file: ' . $e->getMessage());
        }
    }

    private function convertXlsxToCsv($xlsxPath, $csvPath)
    {
        if (!class_exists('ZipArchive')) {
            return $this->convertXlsxToCsvWithoutZipArchive($xlsxPath, $csvPath);
        }

        $zip = new \ZipArchive();
        $data = [];
        
        if ($zip->open($xlsxPath) !== TRUE) {
            throw new \Exception('Cannot open XLSX file');
        }
        
        // Find the first worksheet
        $sheetIndex = -1;
        for ($i = 0; $i < $zip->numFiles; $i++) {
            $filename = $zip->getNameIndex($i);
            if (strpos($filename, 'xl/worksheets/sheet') !== false) {
                $sheetIndex = $i;
                break;
            }
        }
        
        if ($sheetIndex === -1) {
            $zip->close();
            throw new \Exception('No worksheet found in XLSX file');
        }
        
        // Read shared strings
        $sharedStrings = [];
        if (($sharedStringsIndex = $zip->locateName('xl/sharedStrings.xml')) !== FALSE) {
            $sharedStringsXml = $zip->getFromIndex($sharedStringsIndex);
            $sharedStrings = $this->parseSharedStrings($sharedStringsXml);
        }
        
        // Read worksheet
        $worksheetXml = $zip->getFromIndex($sheetIndex);
        $zip->close();
        
        $data = $this->parseWorksheet($worksheetXml, $sharedStrings);
        $this->writeDataToCsv($data, $csvPath);
    }

    private function convertXlsxToCsvWithoutZipArchive($xlsxPath, $csvPath)
    {
        $extractDir = sys_get_temp_dir() . '/xlsx_ext_' . uniqid();
        mkdir($extractDir, 0777, true);
        
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            exec("tar -xf " . escapeshellarg($xlsxPath) . " -C " . escapeshellarg($extractDir));
        } else {
            exec("unzip -q " . escapeshellarg($xlsxPath) . " -d " . escapeshellarg($extractDir));
        }
        
        $sheetFile = null;
        if (file_exists($extractDir . '/xl/worksheets/sheet1.xml')) {
            $sheetFile = $extractDir . '/xl/worksheets/sheet1.xml';
        } else {
            $worksheetsDir = $extractDir . '/xl/worksheets';
            if (is_dir($worksheetsDir)) {
                $files = scandir($worksheetsDir);
                foreach ($files as $file) {
                    if (str_contains($file, 'sheet') && str_contains($file, '.xml')) {
                        $sheetFile = $worksheetsDir . '/' . $file;
                        break;
                    }
                }
            }
        }
        
        if (!$sheetFile) {
            $this->deleteDirectory($extractDir);
            throw new \Exception('No worksheet found in XLSX file (ZipArchive fallback)');
        }
        
        $sharedStrings = [];
        $sharedStringsFile = $extractDir . '/xl/sharedStrings.xml';
        if (file_exists($sharedStringsFile)) {
            $sharedStringsXml = file_get_contents($sharedStringsFile);
            $sharedStrings = $this->parseSharedStrings($sharedStringsXml);
        }
        
        $worksheetXml = file_get_contents($sheetFile);
        $data = $this->parseWorksheet($worksheetXml, $sharedStrings);
        $this->writeDataToCsv($data, $csvPath);
        
        $this->deleteDirectory($extractDir);
    }
    
    private function deleteDirectory($dir) {
        if (!file_exists($dir)) return true;
        if (!is_dir($dir)) return unlink($dir);
        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') continue;
            if (!$this->deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) return false;
        }
        return rmdir($dir);
    }

    private function convertXlsToCsv($xlsPath, $csvPath)
    {
        // For .xls files, use a simpler approach - read as binary and parse
        // This is a basic implementation for simple .xls files
        $fileHandle = fopen($xlsPath, 'rb');
        if (!$fileHandle) {
            throw new \Exception('Cannot open XLS file');
        }
        
        $data = [];
        $isFirstRow = true;
        
        // Read file and look for readable text (simplified approach)
        $content = file_get_contents($xlsPath);
        
        // Extract rows using a simple pattern (this works for simple Excel files)
        preg_match_all('/\b([A-Za-z0-9\s@\.\-_]+)\b/s', $content, $matches);
        
        // Group into rows (this is a simplified approach)
        $allValues = $matches[1] ?? [];
        $row = [];
        $data = [];
        
        foreach ($allValues as $value) {
            // Skip very short values that are likely formatting
            if (strlen(trim($value)) > 1) {
                $row[] = trim($value);
                
                // Assume 5 columns per row for simple files
                if (count($row) >= 5) {
                    if ($isFirstRow) {
                        $isFirstRow = false;
                    }
                    $data[] = $row;
                    $row = [];
                }
            }
        }
        
        // If we have a partial row, add it
        if (!empty($row)) {
            $data[] = $row;
        }
        
        fclose($fileHandle);
        $this->writeDataToCsv($data, $csvPath);
    }

    private function parseSharedStrings($sharedStringsXml)
    {
        $sharedStrings = [];
        preg_match_all('/<t[^>]*>(.*?)<\/t>/s', $sharedStringsXml, $matches);
        return $matches[1] ?? [];
    }

    private function parseWorksheet($worksheetXml, $sharedStrings)
    {
        $data = [];
        preg_match_all('/<row[^>]*>(.*?)<\/row>/s', $worksheetXml, $rows);
        
        foreach ($rows[1] as $rowIndex => $rowContent) {
            preg_match_all('/<c[^>]*>.*?<v>(.*?)<\/v>.*?<\/c>/s', $rowContent, $cells);
            $rowData = [];
            
            foreach ($cells[1] as $cellValue) {
                // Check if it's a shared string reference
                if (is_numeric($cellValue) && isset($sharedStrings[$cellValue])) {
                    $rowData[] = $sharedStrings[$cellValue];
                } else {
                    $rowData[] = $cellValue;
                }
            }
            
            if (!empty($rowData)) {
                $data[] = $rowData;
            }
        }
        
        return $data;
    }

    private function writeDataToCsv($data, $csvPath)
    {
        $handle = fopen($csvPath, 'w');
        if ($handle === FALSE) {
            throw new \Exception('Cannot create temporary CSV file');
        }
        
        foreach ($data as $row) {
            fputcsv($handle, $row);
        }
        
        fclose($handle);
    }

    private function importClients($data)
    {
        $imported = 0;
        $skipped = 0;
        $skippedRows = [];
        
        foreach ($data as $index => $row) {
            try {
                // Normalize column names (case-insensitive)
                $normalizedRow = [];
                foreach ($row as $key => $value) {
                    $normalizedKey = strtolower(trim($key));
                    $normalizedRow[$normalizedKey] = trim($value);
                }
                $row = $normalizedRow;
                
                // Validate required fields
                $requiredFields = ['company_name', 'contact_person', 'email'];
                $missingFields = [];
                
                foreach ($requiredFields as $field) {
                    if (empty($row[$field])) {
                        $missingFields[] = $field;
                    }
                }
                
                if (!empty($missingFields)) {
                    $skipped++;
                    $skippedRows[] = "Row " . ($index + 2) . ": Missing required fields - " . implode(', ', $missingFields);
                    continue;
                }
                
                // Validate email format
                if (!filter_var($row['email'], FILTER_VALIDATE_EMAIL)) {
                    $skipped++;
                    $skippedRows[] = "Row " . ($index + 2) . ": Invalid email format - " . $row['email'];
                    continue;
                }
                
                // Check for duplicate company
                $existingClient = Client::where('company_id', auth()->user()->company_id)
                    ->where('company_name', $row['company_name'])
                    ->first();

                if ($existingClient) {
                    $updated = false;
                    $newPhone = $row['phone'] ?? $row['phone_number'] ?? null;
                    
                    if (empty($existingClient->alternate_phone) && !empty($newPhone) && $existingClient->phone != $newPhone) {
                        $existingClient->alternate_phone = $newPhone;
                        $updated = true;
                    }

                    if (empty($existingClient->alternate_email) && !empty($row['email']) && $existingClient->email != $row['email']) {
                        $existingClient->alternate_email = $row['email'];
                        $updated = true;
                    }

                    if ($updated) {
                        $existingClient->save();
                    }
                    
                    $skipped++;
                    $skippedRows[] = "Row " . ($index + 2) . ": Merged alternate contact into existing company " . $row['company_name'];
                    continue;
                }

                // Check for duplicate email
                if (
                    Client::where('company_id', auth()->user()->company_id)
                        ->where('email', $row['email'])
                        ->exists()
                ) {
                    $skipped++;
                    $skippedRows[] = "Row " . ($index + 2) . ": Duplicate email - " . $row['email'];
                    continue;
                }
                
                // Map and validate data
                $clientData = [
                    'company_name' => $row['company_name'],
                    'contact_person' => $row['contact_person'],
                    'email' => $row['email'],
                    'phone' => $row['phone'] ?? $row['phone_number'] ?? null,
                    'status' => $this->validateStatus($row['status'] ?? 'lead'),
                    'priority' => $this->validatePriority($row['priority'] ?? 'medium'),
                    'industry' => $row['industry'] ?? null,
                    'budget' => $this->parseBudget($row['budget'] ?? null),
                    'source' => $this->validateSource(!empty($row['source']) ? $row['source'] : 'uploaded_by_admin'),
                    'next_follow_up' => $this->parseDate(!empty($row['next_follow_up']) ? $row['next_follow_up'] : (!empty($row['follow_up']) ? $row['follow_up'] : null)),
                    'notes' => !empty($row['notes']) ? $row['notes'] : (!empty($row['note']) ? $row['note'] : 'Uploaded by admin'),
                ];
                
                Client::create($clientData);
                $imported++;
                
            } catch (\Exception $e) {
                $skipped++;
                $skippedRows[] = "Row " . ($index + 2) . ": " . $e->getMessage();
                Log::error("Import row error: " . $e->getMessage());
            }
        }
        
        return [
            'imported' => $imported,
            'skipped' => $skipped,
            'skipped_rows' => $skippedRows
        ];
    }

    private function parseBudget($budget)
    {
        if (empty($budget)) {
            return null;
        }
        
        // Remove any currency symbols and thousands separators
        $budget = preg_replace('/[^\d.-]/', '', $budget);
        
        return is_numeric($budget) ? floatval($budget) : null;
    }

    private function validateStatus($status)
    {
        $validStatuses = ['lead', 'qualified', 'proposal', 'negotiation', 'client', 'lost'];
        $status = strtolower(trim($status));
        return in_array($status, $validStatuses) ? $status : 'lead';
    }

    private function validatePriority($priority)
    {
        $validPriorities = ['low', 'medium', 'high'];
        $priority = strtolower(trim($priority));
        return in_array($priority, $validPriorities) ? $priority : 'medium';
    }

    private function validateSource($source)
    {
        $validSources = ['website', 'referral', 'cold_outreach', 'social_media', 'event', 'other', 'uploaded_by_admin'];
        // Convert to lowercase and replace spaces with underscores (e.g. 'Social Media' -> 'social_media')
        $source = str_replace(' ', '_', strtolower(trim($source)));
        return in_array($source, $validSources) ? $source : 'other';
    }

    private function parseDate($dateString)
    {
        if (empty($dateString)) {
            return null;
        }
        
        try {
            // Handle Excel serial date numbers
            if (is_numeric($dateString)) {
                $excelBaseDate = \Carbon\Carbon::create(1899, 12, 30);
                return $excelBaseDate->addDays($dateString)->format('Y-m-d');
            }
            
            return \Carbon\Carbon::parse($dateString)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }

    public function getNotes($id)
    {
        $client = Client::with(['leadAction.histories.user'])->findOrFail($id);
        $this->authorize('manage', $client);
        
        $histories = [];
        if ($client->leadAction) {
            $histories = $client->leadAction->histories()
                ->with('user:id,name')
                ->orderBy('created_at', 'asc')
                ->get()
                ->map(function($history) {
                    return [
                        'id' => $history->id,
                        'user_name' => $history->user ? $history->user->name : 'Unknown User',
                        'response' => $history->response,
                        'created_at' => $history->created_at->format('M d, Y h:i A'),
                        'changes' => $history->changes,
                    ];
                });
        }
        
        return response()->json(['success' => true, 'notes' => $histories]);
    }

    public function addNote(Request $request, $id)
    {
        $request->validate(['note' => 'required|string']);
        
        $client = Client::findOrFail($id);
        $this->authorize('manage', $client);
        
        // Find or create MyLead for this client
        $mylead = \App\Models\Mylead::firstOrCreate(
            ['client_id' => $client->id, 'company_id' => auth()->user()->company_id],
            [
                'user_id' => auth()->id(),
                'status' => 'lead',
                'project_type' => 'other',
                'response' => $request->note
            ]
        );
        
        // Update the mylead response so it reflects the latest note
        if (!$mylead->wasRecentlyCreated) {
            $mylead->update(['response' => $request->note]);
        }
        
        // Add History
        $history = \App\Models\MyleadHistory::create([
            'company_id' => auth()->user()->company_id,
            'mylead_id' => $mylead->id,
            'user_id' => auth()->id(),
            'response' => $request->note,
            'changes' => json_encode(['note_added' => 'Yes'])
        ]);
        
        return response()->json([
            'success' => true, 
            'note' => [
                'id' => $history->id,
                'user_name' => auth()->user()->name,
                'response' => $history->response,
                'created_at' => $history->created_at->format('M d, Y h:i A')
            ]
        ]);
    }

    public function unlockLead($id)
    {
        $client = Client::findOrFail($id);
        
        // Ensure only admin can unlock
        if (!auth()->user()->hasRole('admin')) {
            return response()->json(['success' => false, 'message' => 'Unauthorized access'], 403);
        }

        if ($client->leadAction) {
            $client->leadAction->update(['status' => 'unlocked']);
            
            \App\Models\MyleadHistory::create([
                'company_id' => auth()->user()->company_id,
                'mylead_id' => $client->leadAction->id,
                'user_id' => auth()->id(),
                'response' => 'Admin unlocked this lead.',
                'changes' => json_encode(['status' => ['old' => 'locked', 'new' => 'unlocked']])
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Lead successfully unlocked!']);
    }

    public function assignLead(Request $request, $id)
    {
        $client = Client::findOrFail($id);
        
        // Ensure only admin/superadmin can assign
        if (!auth()->user()->hasRole('admin') && !auth()->user()->hasRole('superadmin')) {
            return response()->json(['success' => false, 'message' => 'Unauthorized access'], 403);
        }

        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        $assignedUser = \App\Models\User::findOrFail($request->user_id);

        if ($client->leadAction) {
            $client->leadAction->update([
                'user_id' => $assignedUser->id,
                'status' => 'follow up'
            ]);
            $leadAction = $client->leadAction;
        } else {
            $leadAction = \App\Models\Mylead::create([
                'company_id' => auth()->user()->company_id,
                'client_id' => $client->id,
                'user_id' => $assignedUser->id,
                'status' => 'follow up',
                'description' => 'Lead assigned by Admin.'
            ]);
        }
        
        \App\Models\MyleadHistory::create([
            'company_id' => auth()->user()->company_id,
            'mylead_id' => $leadAction->id,
            'user_id' => auth()->id(),
            'response' => 'Admin assigned this lead to ' . $assignedUser->name,
            'changes' => json_encode(['assigned_to' => $assignedUser->name])
        ]);

        $assignedUser->notify(new \App\Notifications\SystemNotification([
            'title' => 'New Lead Assigned',
            'message' => 'Admin has assigned a lead to you ('. $client->company_name .').',
            'url' => route('myleads.show', $leadAction->id),
            'icon' => 'user-plus'
        ]));

        return response()->json(['success' => true, 'message' => 'Lead successfully assigned to ' . $assignedUser->name . '!']);
    }

    /**
     * Log a contact action (email / call / whatsapp) from the client detail page via AJAX.
     */
    public function logContact(Request $request, $id)
    {
        $client = Client::findOrFail($id);

        $action = $request->input('action', 'Contact Action');

        // If client has an assigned lead, log to that lead's history
        if ($client->leadAction) {
            \App\Models\MyleadHistory::create([
                'company_id' => auth()->user()->company_id,
                'mylead_id'  => $client->leadAction->id,
                'user_id'    => auth()->id(),
                'response'   => $action,
                'changes'    => json_encode(['action_taken' => $action]),
            ]);
        } else {
            // No lead assigned yet – create a quick note via MyleadHistory linked through store
            // Fallback: just use the notes system or log silently
            \Illuminate\Support\Facades\Log::info("Contact action logged for client #{$id}: {$action}");
        }

        return response()->json(['success' => true]);
    }
}