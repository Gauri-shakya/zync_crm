@extends('superadmin.layout.app')

@section('title', 'Mobile App Management')

@section('content')
<div class="p-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Mobile App Management</h1>
            <p class="text-slate-500">Upload and manage your application APK files</p>
        </div>
    </div>

    @php
        $active = $apps->firstWhere('is_active', true);
        $downloadUrl = route('app.download');
    @endphp
    <div class="mb-6 bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <p class="text-sm font-semibold text-slate-700">Public Download Link</p>
            @if($active)
                <p class="text-xs text-slate-500 mt-1">Version {{ $active->version }} • {{ $active->created_at->format('M d, Y H:i') }}</p>
            @else
                <p class="text-xs text-amber-600 mt-1">No active app found. Upload a version to enable download.</p>
            @endif
            <div class="mt-2">
                <input id="publicLink" type="text" readonly value="{{ $downloadUrl }}" class="w-full md:w-[36rem] px-3 py-2 rounded-lg border border-slate-200 text-slate-700 text-sm">
            </div>
        </div>
        <div class="flex gap-3">
            <a href="{{ $downloadUrl }}" target="_blank" class="inline-flex items-center justify-center bg-blue-600 text-white px-4 py-2.5 rounded-lg font-bold hover:bg-blue-700 transition-colors">
                <i class="fas fa-download mr-2"></i> Download Latest
            </a>
            <button id="copyLink" class="inline-flex items-center justify-center bg-slate-100 text-slate-700 px-4 py-2.5 rounded-lg font-bold hover:bg-slate-200 transition-colors">
                <i class="fas fa-copy mr-2"></i> Copy Link
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Upload Form -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <h2 class="text-lg font-bold text-slate-900 mb-4">Upload New Version</h2>
                <form action="{{ route('superadmin.mobile-apps.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Version Name</label>
                        <input type="text" name="version" placeholder="e.g. 1.0.0" class="w-full px-4 py-2 rounded-xl border border-slate-200 focus:outline-none focus:border-blue-500" required>
                    </div>
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">APK File</label>
                        <div class="relative group">
                            <input type="file" name="apk_file" class="hidden" id="apk_file" required>
                            <label for="apk_file" class="flex flex-col items-center justify-center w-full h-32 px-4 transition bg-white border-2 border-slate-300 border-dashed rounded-xl appearance-none cursor-pointer hover:border-blue-400 focus:outline-none">
                                <span class="flex items-center space-x-2">
                                    <i class="fas fa-cloud-upload-alt text-slate-400 group-hover:text-blue-500"></i>
                                    <span class="font-medium text-slate-600">Select file to upload</span>
                                </span>
                                <span id="file-name" class="text-xs text-slate-400 mt-2">Maximum file size: 100MB</span>
                            </label>
                        </div>
                    </div>
                    <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-xl font-bold shadow-lg shadow-blue-200 hover:bg-blue-700 transition-colors">
                        Upload App
                    </button>
                </form>
            </div>
        </div>

        <!-- History Table -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-6 border-b border-slate-50">
                    <h2 class="text-lg font-bold text-slate-900">Upload History</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-slate-50">
                                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Version</th>
                                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">File Name</th>
                                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Uploaded At</th>
                                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($apps as $app)
                            <tr>
                                <td class="px-6 py-4 font-bold text-slate-900">{{ $app->version }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ $app->file_name }}</td>
                                <td class="px-6 py-4 text-slate-500">{{ $app->created_at->format('M d, Y H:i') }}</td>
                                <td class="px-6 py-4">
                                    @if($app->is_active)
                                    <span class="px-3 py-1 rounded-full bg-green-100 text-green-600 text-xs font-bold">Active</span>
                                    @else
                                    <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-500 text-xs font-bold">Archived</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-slate-400">No apps uploaded yet</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('apk_file').addEventListener('change', function(e) {
        const fileName = e.target.files[0] ? e.target.files[0].name : 'Select file to upload';
        document.getElementById('file-name').textContent = fileName;
    });
    document.getElementById('copyLink').addEventListener('click', async function() {
        const input = document.getElementById('publicLink');
        input.select();
        input.setSelectionRange(0, 99999);
        try {
            await navigator.clipboard.writeText(input.value);
            this.textContent = 'Link Copied';
            setTimeout(() => { this.innerHTML = '<i class="fas fa-copy mr-2"></i> Copy Link'; }, 1500);
        } catch (e) {
            document.execCommand('copy');
        }
    });
</script>
@endsection
