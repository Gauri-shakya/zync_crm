<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocsController;

Route::get('/', function () {
    return redirect('/docs/introduction');
});

Route::get('/docs', function () {
    return redirect('/docs/introduction');
});

Route::get('/docs/{module}/{page?}', [DocsController::class, 'show'])->name('docs.show');
Route::get('/docs-search', [DocsController::class, 'search'])->name('docs.search');
