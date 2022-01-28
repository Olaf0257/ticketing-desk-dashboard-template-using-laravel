<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Localization;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/lang/{locale}', function($locale){
    session()->put('locale', $locale);
    //dd($locale);
   // App::setlocale($locale);
    return redirect()->back();
});

Auth::routes(['verify' => true]);

Route::get('/', [App\Http\Controllers\DashboardController::class, 'index'])->name('home');

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
// TicketStatusController CRUD
Route::resource('ticket_status', App\Http\Controllers\TicketStatusController::class);
Route::resource('department', App\Http\Controllers\DepartmentController::class);
Route::resource('ticket', App\Http\Controllers\TicketController::class);
Route::resource('staff', App\Http\Controllers\StaffController::class);
Route::resource('user', App\Http\Controllers\UserController::class);
Route::resource('language', App\Http\Controllers\LanguageController::class);
Route::resource('settings', App\Http\Controllers\SettingController::class);
Route::resource('imap_ticket', App\Http\Controllers\ImapTicketController::class);
Route::resource('error_log', App\Http\Controllers\ErrorLogController::class);
Route::resource('email_template', App\Http\Controllers\EmailTemplateController::class);
Route::resource('tags', App\Http\Controllers\TagController::class);
Route::resource('faq_category', App\Http\Controllers\FaqCategoryController::class);
Route::resource('faq', App\Http\Controllers\FaqController::class);
Route::resource('permissions', App\Http\Controllers\PermissionController::class);
Route::resource('kb_category', App\Http\Controllers\KbCategoryController::class);
Route::resource('kb_article', App\Http\Controllers\KbArticleController::class);
Route::resource('articles', App\Http\Controllers\ArticleController::class);
Route::resource('faq_list', App\Http\Controllers\FaqListController::class);
Route::resource('canned_responses', App\Http\Controllers\CannedResponseController::class);

Route::get('/article/{slug}', [App\Http\Controllers\ArticleController::class, 'showArticle'])->name('showArticle');

Route::match(['get', 'post'], '/{uuid}/ticket_reply', [App\Http\Controllers\TicketController::class, 'reply'])
    ->name('ticket.reply');
Route::match(['get', 'post'], '/{uuid}/ticket_modify', [App\Http\Controllers\TicketController::class, 'modify'])
    ->name('ticket.modify');
Route::match(['get', 'post'], '/{uuid}/ticket_note', [App\Http\Controllers\TicketController::class, 'note'])
    ->name('ticket.note');
Route::match(['get', 'post'], '/{uuid}/internal_ticket_note', [App\Http\Controllers\TicketController::class, 'internalNote'])
    ->name('ticket.internal_note');
Route::match(['get', 'post'], '/status_tickets/{id}', [App\Http\Controllers\TicketController::class, 'ticketByStatus'])
    ->name('tickets');
Route::get('/my_ticket', [App\Http\Controllers\TicketController::class, 'myTicket'])->name('my_ticket');;
Route::get('/assigned_to_me', [App\Http\Controllers\TicketController::class, 'assignedToMe'])->name('ticket_assigned_me');

Route::match(['get', 'post'], '/{uuid}/imap_ticket_reply', [App\Http\Controllers\ImapTicketController::class, 'reply'])
    ->name('imap_ticket.reply');
Route::match(['get', 'post'], '/{uuid}/imap_ticket_modify', [App\Http\Controllers\ImapTicketController::class, 'modify'])
    ->name('imap_ticket.modify');
Route::match(['get', 'post'], '/{uuid}/imap_ticket_note', [App\Http\Controllers\ImapTicketController::class, 'note'])
    ->name('imap_ticket.note');
Route::match(['get', 'post'], '/{uuid}/internal_imap_ticket_note', [App\Http\Controllers\ImapTicketController::class, 'internalNote'])
    ->name('imap_ticket.internal_note');
Route::match(['get', 'post'], '/imap_status_tickets/{id}', [App\Http\Controllers\ImapTicketController::class, 'ticketByStatus'])
    ->name('imapTickets');
Route::get('/email_assigned_to_me', [App\Http\Controllers\ImapTicketController::class, 'assignedToMe'])->name('email_ticket_assigned_me');

Route::get('/download/{file}', [App\Http\Controllers\TicketController::class, 'download'])->name('download');
Route::get('/imap_download/{file}', [App\Http\Controllers\ImapTicketController::class, 'download'])->name('imap_download');

Route::delete('/delete_reply/{uuid}', [App\Http\Controllers\TicketController::class, 'replyDelete'])->name('delete_reply');
Route::delete('/delete_note/{uuid}', [App\Http\Controllers\TicketController::class, 'noteDelete'])->name('delete_note');
Route::delete('/delete_internal_note/{uuid}', [App\Http\Controllers\TicketController::class, 'internalNoteDelete'])->name('delete_internal_note');

Route::delete('/delete_imap_reply/{uuid}', [App\Http\Controllers\ImapTicketController::class, 'replyDelete'])->name('delete_imap_reply');
Route::delete('/delete_imap_note/{uuid}', [App\Http\Controllers\ImapTicketController::class, 'noteDelete'])->name('delete_imap_note');
Route::delete('/delete_imap_internal_note/{uuid}', [App\Http\Controllers\ImapTicketController::class, 'internalNoteDelete'])->name('delete_imap_internal_note');

Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile');
Route::post('/profile/update', [App\Http\Controllers\ProfileController::class, 'update'])->name('profileUpdate');
Route::get('/languages', [App\Http\Controllers\LanguageController::class, 'lang'])->name('lang');

Route::get('/permissions', [App\Http\Controllers\PermissionController::class, 'index'])->name('permissions');
Route::post('/permissions/update', [App\Http\Controllers\PermissionController::class, 'update'])->name('permissionUpdate');

Route::get('/privacy_policy', [App\Http\Controllers\FooterController::class, 'privacyPolicy'])->name('privacyPolicy');
Route::get('/terms_of_use', [App\Http\Controllers\FooterController::class, 'terms'])->name('terms');

Route::get('/get_canned_responses_api', [App\Http\Controllers\CannedResponseController::class, 'getCannedResponsesApi'])->name('getCannedResponsesApi');

Route::get('/get_tags_api', [App\Http\Controllers\TagController::class, 'getTagsApi'])->name('getTagsApi');

