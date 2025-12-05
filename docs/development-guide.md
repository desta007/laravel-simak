# Development Guide - SIMAK

## Panduan untuk Developer

Dokumen ini berisi panduan untuk developer yang akan melakukan pengembangan pada aplikasi SIMAK.

## Tech Stack

### Backend
- **Laravel 10.x**: PHP Framework
- **PHP 8.1+**: Programming Language
- **MySQL/MariaDB**: Database

### Frontend
- **Blade Templates**: Laravel templating engine
- **AdminLTE 3**: Admin dashboard template
- **jQuery 3.x**: JavaScript library
- **Bootstrap 4**: CSS framework
- **DataTables**: Table plugin
- **Select2**: Dropdown enhancement
- **SweetAlert2**: Alert dialogs

### Libraries & Packages
- **Laravel Fortify**: Authentication
- **Laravel Sanctum**: API tokens
- **Yajra DataTables**: Server-side DataTables
- **Maatwebsite Excel**: Excel export/import
- **DomPDF**: PDF generation
- **Simple QRCode**: QR code generator

## Project Structure

```
app/
├── Actions/Fortify/          # Fortify custom actions
├── Exports/                  # Excel export classes
├── Http/
│   ├── Controllers/          # Application controllers
│   │   ├── CabangController.php
│   │   ├── ProyekController.php
│   │   ├── TransaksiController.php
│   │   ├── ReportController.php
│   │   └── ...
│   ├── Middleware/           # Custom middleware
│   └── Requests/             # Form request validation
├── Models/                   # Eloquent models
│   ├── User.php
│   ├── Cabang.php
│   ├── Transaksi.php
│   └── ...
└── Providers/                # Service providers
```

## Coding Standards

### PHP Coding Style
Mengikuti PSR-12 coding standard. Gunakan Laravel Pint untuk formatting:

```bash
./vendor/bin/pint
```

### Naming Conventions

**Controllers:**
- Singular noun + "Controller"
- Example: `UserController`, `TransaksiController`

**Models:**
- Singular noun, PascalCase
- Example: `User`, `KodePerkiraan`, `TransaksiDetail`

**Database Tables:**
- Plural noun, snake_case
- Example: `users`, `kode_perkiraans`, `transaksi_details`

**Routes:**
- kebab-case
- Example: `/kode-perkiraan`, `/transaksi-jurnal`

**Views:**
- kebab-case
- Example: `kode-perkiraan.index.blade.php`

**Variables:**
- camelCase
- Example: `$kodePerkiran`, `$totalDebit`

## Development Workflow

### 1. Setup Development Environment

```bash
# Clone repository
git clone <repo-url>
cd laravel-simak

# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Setup database
php artisan migrate
php artisan db:seed

# Run development server
php artisan serve
npm run dev
```

### 2. Create New Feature

#### a. Database Migration

```bash
# Create migration
php artisan make:migration create_table_name_table

# Edit migration file
# database/migrations/YYYY_MM_DD_HHMMSS_create_table_name_table.php

# Run migration
php artisan migrate
```

#### b. Create Model

```bash
# Create model with migration
php artisan make:model NamaModel -m

# With controller and migration
php artisan make:model NamaModel -mc
```

Example model:

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KodePerkiraan extends Model
{
    protected $fillable = [
        'id_cabang',
        'id_group_account',
        'kode',
        'nama'
    ];

    // Relations
    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'id_cabang');
    }

    public function groupAccount()
    {
        return $this->belongsTo(GroupAccount::class, 'id_group_account');
    }
}
```

#### c. Create Controller

```bash
# Create controller
php artisan make:controller NamaController --resource
```

Example controller:

```php
namespace App\Http\Controllers;

use App\Models\KodePerkiraan;
use Illuminate\Http\Request;

class KodePerkiraanController extends Controller
{
    public function index()
    {
        $data = KodePerkiraan::with(['cabang', 'groupAccount'])->get();
        return view('master.kode-perkiraan.index', compact('data'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_cabang' => 'required|exists:cabangs,id',
            'kode' => 'required|unique:kode_perkiraans',
            'nama' => 'required'
        ]);

        KodePerkiraan::create($validated);

        return redirect()->back()->with('success', 'Data berhasil disimpan');
    }
}
```

#### d. Create Routes

Add routes in `routes/web.php`:

```php
Route::middleware(['auth'])->group(function () {
    Route::resource('kodePerkiraan', KodePerkiraanController::class);
    
    // Custom routes
    Route::get('addModalKodePerkiraan', [KodePerkiraanController::class, 'addModal'])
        ->name('addModalKodePerkiraan');
});
```

#### e. Create Views

Create blade templates in `resources/views/`:

```php
{{-- resources/views/master/kode-perkiraan/index.blade.php --}}
@extends('layout.main')

@section('title', 'Kode Perkiraan')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Kode Perkiraan</h3>
        <button class="btn btn-primary btn-sm float-right" onclick="addModal()">
            <i class="fas fa-plus"></i> Add New
        </button>
    </div>
    <div class="card-body">
        <table id="table" class="table table-bordered">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Cabang</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("kodePerkiraan.index") }}',
        columns: [
            { data: 'kode', name: 'kode' },
            { data: 'nama', name: 'nama' },
            { data: 'cabang.nama', name: 'cabang.nama' },
            { data: 'actions', orderable: false, searchable: false }
        ]
    });
});
</script>
@endpush
```

## Database Operations

### Query Builder

```php
// Basic query
$users = DB::table('users')->where('active', 1)->get();

// Join
$data = DB::table('transaksis')
    ->join('cabangs', 'transaksis.id_cabang', '=', 'cabangs.id')
    ->select('transaksis.*', 'cabangs.nama as cabang_nama')
    ->get();

// Aggregate
$total = DB::table('transaksi_details')->sum('debit');
```

### Eloquent ORM

```php
// Find by ID
$transaksi = Transaksi::find($id);

// With relations
$transaksi = Transaksi::with(['cabang', 'proyek', 'transaksiDetail'])->find($id);

// Where clause
$data = KodePerkiraan::where('id_cabang', $cabangId)
    ->where('id_proyek', $proyekId)
    ->get();

// Create
$transaksi = Transaksi::create([
    'id_cabang' => $cabangId,
    'tgl' => $tanggal,
    'no_bukti' => $noBukti
]);

// Update
$transaksi->update(['keterangan' => 'Updated']);

// Delete
$transaksi->delete();
```

## Frontend Development

### DataTables Implementation

```javascript
$('#table').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: '{{ route("transaksi.index") }}',
        data: function(d) {
            d.id_cabang = $('#filter_cabang').val();
            d.id_proyek = $('#filter_proyek').val();
        }
    },
    columns: [
        { data: 'tgl', name: 'tgl' },
        { data: 'no_bukti', name: 'no_bukti' },
        { data: 'keterangan', name: 'keterangan' },
        { data: 'actions', orderable: false, searchable: false }
    ]
});
```

### Select2 Integration

```javascript
$('.select2').select2({
    theme: 'bootstrap4',
    placeholder: 'Pilih...',
    allowClear: true,
    ajax: {
        url: '{{ route("ajaxSearchKodePerkiraan") }}',
        dataType: 'json',
        delay: 250,
        data: function(params) {
            return {
                search: params.term,
                id_cabang: $('#id_cabang').val()
            };
        },
        processResults: function(data) {
            return {
                results: data.results
            };
        }
    }
});
```

### SweetAlert2 Usage

```javascript
// Confirmation
Swal.fire({
    title: 'Apakah Anda yakin?',
    text: "Data akan dihapus permanen!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya, hapus!',
    cancelButtonText: 'Batal'
}).then((result) => {
    if (result.isConfirmed) {
        // Delete action
    }
});

// Success
Swal.fire('Berhasil!', 'Data berhasil disimpan', 'success');

// Error
Swal.fire('Error!', 'Terjadi kesalahan', 'error');
```

### Modal Implementation

```javascript
function addModal() {
    $.get('{{ route("addModalKodePerkiraan") }}', function(data) {
        $('#modalContainer').html(data);
        $('#addModal').modal('show');
    });
}

function editModal(id) {
    $.get('/kodePerkiraan/' + id + '/edit', function(data) {
        $('#modalContainer').html(data);
        $('#editModal').modal('show');
    });
}
```

## Export Implementation

### Excel Export

Create export class:

```bash
php artisan make:export ExportNeraca
```

```php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportNeraca implements FromCollection, WithHeadings
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            'Kode',
            'Nama Perkiraan',
            'Saldo Debit',
            'Saldo Kredit'
        ];
    }
}
```

Controller:

```php
use App\Exports\ExportNeraca;
use Maatwebsite\Excel\Facades\Excel;

public function exportNeraca(Request $request)
{
    $data = $this->getNeracaData($request);
    
    return Excel::download(
        new ExportNeraca($data), 
        'neraca-' . date('Ymd') . '.xlsx'
    );
}
```

### PDF Export

```php
use Barryvdh\DomPDF\Facade\Pdf;

public function exportPDF(Request $request)
{
    $data = $this->getData($request);
    
    $pdf = Pdf::loadView('report.neraca-pdf', compact('data'));
    
    return $pdf->download('neraca-' . date('Ymd') . '.pdf');
    
    // Or stream in browser
    // return $pdf->stream();
}
```

## Validation

### Form Request Validation

Create form request:

```bash
php artisan make:request StoreTransaksiRequest
```

```php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransaksiRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id_cabang' => 'required|exists:cabangs,id',
            'id_proyek' => 'required|exists:proyeks,id',
            'tgl' => 'required|date',
            'keterangan' => 'required|string|max:500',
            'details' => 'required|array|min:2',
            'details.*.id_kode_perkiraan' => 'required|exists:kode_perkiraans,id',
            'details.*.debit' => 'nullable|numeric|min:0',
            'details.*.kredit' => 'nullable|numeric|min:0'
        ];
    }

    public function messages()
    {
        return [
            'id_cabang.required' => 'Cabang harus dipilih',
            'details.min' => 'Minimal 2 detail transaksi diperlukan'
        ];
    }
}
```

Use in controller:

```php
public function store(StoreTransaksiRequest $request)
{
    $validated = $request->validated();
    // Process data
}
```

## Middleware

### Create Custom Middleware

```bash
php artisan make:middleware CheckUserAccess
```

```php
namespace App\Http\Middleware;

use Closure;

class CheckUserAccess
{
    public function handle($request, Closure $next, $menu)
    {
        $user = auth()->user();
        
        // Check permission
        $permission = UserPermission::where('id_group_user', $user->id_group_user)
            ->where('nama_menu', $menu)
            ->first();
            
        if (!$permission || $permission->hak_akses === 'none') {
            abort(403, 'Unauthorized action');
        }
        
        return $next($request);
    }
}
```

Register in `app/Http/Kernel.php`:

```php
protected $routeMiddleware = [
    // ...
    'check.access' => \App\Http\Middleware\CheckUserAccess::class,
];
```

Use in routes:

```php
Route::get('/transaksi', [TransaksiController::class, 'index'])
    ->middleware('check.access:Transaksi Jurnal');
```

## Testing

### Feature Tests

```bash
php artisan make:test TransaksiTest
```

```php
namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

class TransaksiTest extends TestCase
{
    public function test_user_can_view_transaksi()
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)
            ->get('/transJurnal');
            
        $response->assertStatus(200);
    }
    
    public function test_user_can_create_transaksi()
    {
        $user = User::factory()->create();
        
        $data = [
            'id_cabang' => 1,
            'id_proyek' => 1,
            'tgl' => '2024-01-01',
            'keterangan' => 'Test transaksi'
        ];
        
        $response = $this->actingAs($user)
            ->post('/submitTransJurnal', $data);
            
        $response->assertRedirect();
        $this->assertDatabaseHas('transaksis', ['keterangan' => 'Test transaksi']);
    }
}
```

Run tests:

```bash
php artisan test
```

## Debugging

### Laravel Debugbar

Install:

```bash
composer require barryvdh/laravel-debugbar --dev
```

### Logging

```php
use Illuminate\Support\Facades\Log;

// Different log levels
Log::emergency($message);
Log::alert($message);
Log::critical($message);
Log::error($message);
Log::warning($message);
Log::notice($message);
Log::info($message);
Log::debug($message);

// Log with context
Log::info('User login', ['user_id' => $user->id]);
```

### Dump & Die

```php
// Dump and continue
dump($variable);

// Dump and die
dd($variable);

// Dump to Laravel Log
logger($variable);
```

## Performance Optimization

### Query Optimization

```php
// Eager loading (avoid N+1 problem)
$transaksis = Transaksi::with(['cabang', 'proyek', 'transaksiDetail'])
    ->get();

// Select specific columns
$data = KodePerkiraan::select('id', 'kode', 'nama')->get();

// Chunking large datasets
KodePerkiraan::chunk(100, function($records) {
    foreach ($records as $record) {
        // Process record
    }
});
```

### Caching

```php
use Illuminate\Support\Facades\Cache;

// Store cache
Cache::put('key', 'value', 3600); // 1 hour

// Remember cache
$data = Cache::remember('cabangs', 3600, function() {
    return Cabang::all();
});

// Forget cache
Cache::forget('key');

// Clear all cache
Cache::flush();
```

## Git Workflow

### Branch Strategy

- `main`: Production-ready code
- `develop`: Development branch
- `feature/*`: New features
- `bugfix/*`: Bug fixes
- `hotfix/*`: Emergency fixes

### Commit Messages

Format: `type: subject`

Types:
- `feat`: New feature
- `fix`: Bug fix
- `docs`: Documentation
- `style`: Code style changes
- `refactor`: Code refactoring
- `test`: Adding tests
- `chore`: Maintenance tasks

Example:
```
feat: add export to PDF for neraca report
fix: calculation error in laba rugi
docs: update installation guide
```

## Deployment

### Production Checklist

```bash
# Update code
git pull origin main

# Install dependencies
composer install --optimize-autoloader --no-dev

# Run migrations
php artisan migrate --force

# Clear caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# Cache for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Optimize
composer dump-autoload -o

# Set permissions
chmod -R 755 storage bootstrap/cache

# Build assets
npm run build
```

### Environment Configuration

Set `.env` for production:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

# Database
DB_CONNECTION=mysql
DB_HOST=your-db-host
DB_DATABASE=your-db-name

# Cache & Session
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis
```

## Security Best Practices

1. **Never commit .env file**
2. **Keep dependencies updated**
3. **Use prepared statements (Eloquent/Query Builder)**
4. **Validate all inputs**
5. **Use CSRF protection**
6. **Hash passwords (Laravel does this automatically)**
7. **Use HTTPS in production**
8. **Regular security audits**

## Resources

- [Laravel Documentation](https://laravel.com/docs)
- [AdminLTE Documentation](https://adminlte.io/docs)
- [DataTables Documentation](https://datatables.net/)
- [Select2 Documentation](https://select2.org/)

