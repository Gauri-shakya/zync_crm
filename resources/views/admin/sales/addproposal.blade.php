@extends('components.layout')

@section('content')
<div class="min-h-screen bg-gray-50 py-4 sm:py-8 px-4">
  <div class="max-w-4xl mx-auto bg-white p-4 sm:p-8 rounded-xl shadow-sm border border-gray-100">
    <div class="flex items-center gap-3 mb-6">
        <div class="bg-blue-50 text-blue-600 p-2 rounded-lg">
            <i class="fas fa-file-invoice text-xl"></i>
        </div>
        <h2 class="text-xl sm:text-2xl font-bold text-gray-900">Create New Proposal</h2>
    </div>

    <form action="{{ route('proposals.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
      @csrf

      <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <div class="space-y-1.5">
            <label class="block text-sm font-bold text-gray-700 ml-1">Client</label>
            <div class="relative">
                <span class="absolute left-3 top-3 text-gray-400"><i class="fas fa-user-tie"></i></span>
                <select name="client_id" class="w-full border border-gray-200 rounded-xl pl-10 pr-4 py-2.5 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none bg-white text-sm" required>
                <option value="">-- Select Client --</option>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}">{{ $client->company_name }}</option>
                @endforeach
                </select>
            </div>
        </div>

        <div class="space-y-1.5">
            <label class="block text-sm font-bold text-gray-700 ml-1">Title</label>
            <div class="relative">
                <span class="absolute left-3 top-3 text-gray-400"><i class="fas fa-heading"></i></span>
                <input type="text" name="title" placeholder="e.g. Website Redesign" class="w-full border border-gray-200 rounded-xl pl-10 pr-4 py-2.5 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none text-sm" required>
            </div>
        </div>
      </div>

      <div class="space-y-1.5">
        <label class="block text-sm font-bold text-gray-700 ml-1">Description</label>
        <textarea name="description" rows="4" placeholder="Briefly describe the proposal details..." class="w-full border border-gray-200 rounded-xl p-4 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none text-sm resize-none"></textarea>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <div class="space-y-1.5">
            <label class="block text-sm font-bold text-gray-700 ml-1">Amount</label>
            <div class="relative">
                <span class="absolute left-3 top-3 text-gray-400"><i class="fas fa-dollar-sign"></i></span>
                <input type="number" name="amount" step="0.01" placeholder="0.00" class="w-full border border-gray-200 rounded-xl pl-10 pr-4 py-2.5 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none text-sm">
            </div>
        </div>

        <div class="space-y-1.5">
            <label class="block text-sm font-bold text-gray-700 ml-1">Attach File</label>
            <div class="relative">
                <input type="file" name="file" class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-all cursor-pointer border border-gray-200 rounded-xl p-1">
            </div>
        </div>
      </div>

      <div class="pt-4">
        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 rounded-xl transition-all shadow-lg shadow-blue-200 active:scale-[0.98] flex items-center justify-center gap-2">
            <i class="fas fa-save"></i> Save Proposal
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
