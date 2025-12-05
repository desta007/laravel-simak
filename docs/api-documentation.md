# API Documentation - SIMAK

## Base URL

```
http://localhost:8000
```

## Authentication

SIMAK menggunakan Laravel Sanctum untuk API authentication dan Laravel Fortify untuk web authentication.

### Login

**Endpoint:** `POST /login`

**Request:**
```json
{
  "email": "user@example.com",
  "password": "password"
}
```

**Response Success:**
```json
{
  "success": true,
  "redirect": "/"
}
```

**Response Error:**
```json
{
  "errors": {
    "email": ["These credentials do not match our records."]
  }
}
```

### Logout

**Endpoint:** `POST /logout`

**Headers:**
```
Authorization: Bearer {token}
```

## API Endpoints

### Kode Perkiraan

#### Get Proyeks by Cabang

**Endpoint:** `GET /get-proyeks-by-cabang`

**Parameters:**
- `id_cabang` (required): ID cabang

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "kode": "PRJ001",
      "nama": "Proyek A"
    }
  ]
}
```

#### AJAX Search Kode Perkiraan

**Endpoint:** `GET /ajaxSearchKodePerkiraan`

**Parameters:**
- `search` (optional): Search term
- `id_cabang` (optional): Filter by cabang
- `id_proyek` (optional): Filter by proyek

**Response:**
```json
{
  "results": [
    {
      "id": 1,
      "text": "1101 - Kas",
      "kode": "1101",
      "nama": "Kas"
    }
  ]
}
```

### Transaksi

#### Get No Urut Bukti by Kode

**Endpoint:** `GET /getNoUrutBuktiByKode`

**Parameters:**
- `id_kode_bukti` (required): ID kode bukti
- `tgl` (required): Tanggal transaksi (YYYY-MM-DD)
- `id_cabang` (required): ID cabang
- `id_proyek` (required): ID proyek

**Response:**
```json
{
  "success": true,
  "no_urut": "0001",
  "no_bukti": "BKK-202401-0001"
}
```

#### Search Transaksi

**Endpoint:** `POST /transJurnalSearch`

**Request:**
```json
{
  "id_cabang": 1,
  "id_proyek": 1,
  "tgl_dari": "2024-01-01",
  "tgl_sampai": "2024-01-31",
  "id_kode_bukti": null
}
```

**Response:**
Returns DataTables JSON response

#### View Modal Detail Transaksi

**Endpoint:** `GET /viewModalDetailTrx`

**Parameters:**
- `id` (required): ID transaksi

**Response:**
Returns HTML modal content

#### Hitung Session Jumlah

**Endpoint:** `GET /hitungSessionJumlah`

**Parameters:**
- `jenis` (required): "debit" or "kredit"

**Response:**
```json
{
  "total": 1000000
}
```

#### Save Session Jumlah

**Endpoint:** `POST /saveSessionJumlah`

**Request:**
```json
{
  "jenis": "debit",
  "jumlah": 1000000
}
```

**Response:**
```json
{
  "success": true,
  "message": "Jumlah berhasil disimpan"
}
```

### User

#### List Cabang by Group User

**Endpoint:** `GET /listCabangByGroupUser`

**Parameters:**
- `id_group_user` (required): ID group user

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "kode": "CAB001",
      "nama": "Cabang Jakarta"
    }
  ]
}
```

#### View Modal Proyek by User

**Endpoint:** `GET /viewModalProyekByUser`

**Parameters:**
- `id_user` (required): ID user

**Response:**
Returns HTML modal content

#### View Modal Reset Password

**Endpoint:** `GET /viewModalResetPwd`

**Parameters:**
- `id` (required): ID user

**Response:**
Returns HTML modal content

#### Update Password

**Endpoint:** `POST /updatePass`

**Request:**
```json
{
  "id_user": 1,
  "password": "newpassword",
  "password_confirmation": "newpassword"
}
```

**Response:**
```json
{
  "success": true,
  "message": "Password berhasil diupdate"
}
```

### Reports

#### Search Neraca

**Endpoint:** `POST /neracaSearch`

**Request:**
```json
{
  "id_cabang": 1,
  "id_proyek": 1,
  "bulan": 1,
  "tahun": 2024,
  "view": "1"
}
```

**Response:**
Returns HTML report or redirect to export

#### Search Laba Rugi

**Endpoint:** `POST /labaRugiSearch`

**Request:**
```json
{
  "id_cabang": 1,
  "id_proyek": 1,
  "bulan": 1,
  "tahun": 2024,
  "view": "1"
}
```

**Response:**
Returns HTML report or redirect to export

#### Search General Ledger

**Endpoint:** `POST /generalLedgerSearch`

**Request:**
```json
{
  "id_cabang": 1,
  "id_proyek": 1,
  "tgl_dari": "2024-01-01",
  "tgl_sampai": "2024-01-31",
  "id_kode_perkiraan": null
}
```

**Response:**
Returns HTML report or redirect to export

#### Search Resume Keuangan Proyek

**Endpoint:** `POST /resumeKeuanganProyekSearch`

**Request:**
```json
{
  "id_cabang": 1,
  "id_proyek": 1,
  "tgl_dari": "2024-01-01",
  "tgl_sampai": "2024-01-31"
}
```

**Response:**
Returns HTML report or redirect to export

#### Search Buku Tambahan

**Endpoint:** `POST /bukuTambahanSearch`

**Request:**
```json
{
  "id_cabang": 1,
  "id_proyek": 1,
  "tgl_dari": "2024-01-01",
  "tgl_sampai": "2024-01-31",
  "id_kode_perkiraan": 1
}
```

**Response:**
Returns HTML report

### Export

#### Export Neraca

**Endpoint:** `POST /neracaExport`

**Request:**
```json
{
  "id_cabang": 1,
  "id_proyek": 1,
  "bulan": 1,
  "tahun": 2024,
  "format": "excel" // or "pdf"
}
```

**Response:**
File download (Excel or PDF)

#### Export Laba Rugi

**Endpoint:** `POST /labaRugiExport`

**Request:**
```json
{
  "id_cabang": 1,
  "id_proyek": 1,
  "bulan": 1,
  "tahun": 2024,
  "format": "excel" // or "pdf"
}
```

**Response:**
File download (Excel or PDF)

#### Export General Ledger

**Endpoint:** `POST /generalLedgerExport`

**Request:**
```json
{
  "id_cabang": 1,
  "id_proyek": 1,
  "tgl_dari": "2024-01-01",
  "tgl_sampai": "2024-01-31",
  "id_kode_perkiraan": null,
  "format": "excel" // or "pdf"
}
```

**Response:**
File download (Excel or PDF)

#### Export Resume Keuangan Proyek

**Endpoint:** `POST /resumeKeuanganProyekExport`

**Request:**
```json
{
  "id_cabang": 1,
  "id_proyek": 1,
  "tgl_dari": "2024-01-01",
  "tgl_sampai": "2024-01-31",
  "format": "excel" // or "pdf"
}
```

**Response:**
File download (Excel or PDF)

## Modal Endpoints

### Add Modal Cabang

**Endpoint:** `GET /addModalCabang`

**Response:** HTML modal for adding Cabang

### Add Modal Proyek

**Endpoint:** `GET /addModalProyek`

**Response:** HTML modal for adding Proyek

### Add Modal Kode Bukti

**Endpoint:** `GET /addModalKodeBukti`

**Response:** HTML modal for adding Kode Bukti

### Add Modal Group Account

**Endpoint:** `GET /addModalGroupAccount`

**Response:** HTML modal for adding Group Account

### Add Modal Kode Perkiraan

**Endpoint:** `GET /addModalKodePerkiraan`

**Response:** HTML modal for adding Kode Perkiraan

### Add Modal Pedoman Mutu

**Endpoint:** `GET /addModalPedomanMutu`

**Response:** HTML modal for adding Pedoman Mutu

### Add Modal Catatan Mutu

**Endpoint:** `GET /addModalCatatanMutu`

**Response:** HTML modal for adding Catatan Mutu

### Add Modal Pejabat

**Endpoint:** `GET /addModalPejabat`

**Response:** HTML modal for adding Pejabat

### Add Modal Kunci Transaksi

**Endpoint:** `GET /addModalKunciTransaksi`

**Response:** HTML modal for adding Kunci Transaksi

### Add Transaksi Jurnal Detail

**Endpoint:** `GET /addTransJurnalDetail`

**Response:** HTML modal for adding transaction detail

## Resource Routes

Laravel resource routes are used for CRUD operations:

### Cabang
- `GET /cabang` - Index
- `GET /cabang/create` - Create form
- `POST /cabang` - Store
- `GET /cabang/{id}` - Show
- `GET /cabang/{id}/edit` - Edit form
- `PUT /cabang/{id}` - Update
- `DELETE /cabang/{id}` - Delete

### Proyek
- `GET /proyek` - Index
- `POST /proyek` - Store
- `GET /proyek/{id}/edit` - Edit
- `PUT /proyek/{id}` - Update
- `DELETE /proyek/{id}` - Delete

### Kode Bukti
- `GET /kodeBukti` - Index
- `POST /kodeBukti` - Store
- `PUT /kodeBukti/{id}` - Update
- `DELETE /kodeBukti/{id}` - Delete

### Group Account
- `GET /groupAccount` - Index
- `POST /groupAccount` - Store
- `PUT /groupAccount/{id}` - Update
- `DELETE /groupAccount/{id}` - Delete

### Kode Perkiraan
- `GET /kodePerkiraan` - Index
- `POST /kodePerkiraan` - Store
- `PUT /kodePerkiraan/{id}` - Update
- `DELETE /kodePerkiraan/{id}` - Delete

### User
- `GET /user` - Index
- `POST /user` - Store
- `PUT /user/{id}` - Update
- `DELETE /user/{id}` - Delete

### Pedoman Mutu
- `GET /pedomanMutu` - Index
- `POST /pedomanMutu` - Store
- `PUT /pedomanMutu/{id}` - Update
- `DELETE /pedomanMutu/{id}` - Delete

### Catatan Mutu
- `GET /catatanMutu` - Index
- `POST /catatanMutu` - Store
- `PUT /catatanMutu/{id}` - Update
- `DELETE /catatanMutu/{id}` - Delete

### Kunci Transaksi
- `GET /kunciTransaksi` - Index
- `POST /kunciTransaksi` - Store
- `PUT /kunciTransaksi/{id}` - Update
- `DELETE /kunciTransaksi/{id}` - Delete

### Pejabat
- `GET /pejabat` - Index
- `POST /pejabat` - Store
- `PUT /pejabat/{id}` - Update
- `DELETE /pejabat/{id}` - Delete

## Error Responses

### 401 Unauthorized
```json
{
  "error": "Unauthenticated"
}
```

### 403 Forbidden
```json
{
  "error": "Unauthorized action"
}
```

### 404 Not Found
```json
{
  "error": "Resource not found"
}
```

### 422 Validation Error
```json
{
  "message": "The given data was invalid.",
  "errors": {
    "field_name": [
      "Error message"
    ]
  }
}
```

### 500 Server Error
```json
{
  "error": "Internal server error",
  "message": "Error description"
}
```

## DataTables Integration

Many list endpoints use Yajra DataTables for server-side processing.

**Example Request:**
```
GET /kodePerkiraan?draw=1&start=0&length=10&search[value]=kas
```

**Example Response:**
```json
{
  "draw": 1,
  "recordsTotal": 100,
  "recordsFiltered": 5,
  "data": [
    {
      "id": 1,
      "kode": "1101",
      "nama": "Kas",
      "cabang": "Cabang Jakarta",
      "actions": "<button>Edit</button>"
    }
  ]
}
```

## Rate Limiting

API rate limiting is configured in Laravel:
- 60 requests per minute for authenticated users
- 10 requests per minute for guests

## Security

### CSRF Protection
All POST, PUT, DELETE requests must include CSRF token:

```html
<meta name="csrf-token" content="{{ csrf_token() }}">
```

```javascript
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
```

### File Upload
Maximum file size: 2MB (configurable in php.ini)

Allowed file types:
- Documents: pdf, doc, docx, xls, xlsx
- Images: jpg, jpeg, png, gif

## Testing

### Example using cURL

```bash
# Login
curl -X POST http://localhost:8000/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@example.com","password":"password"}'

# Get Kode Perkiraan
curl -X GET http://localhost:8000/kodePerkiraan \
  -H "Cookie: laravel_session=YOUR_SESSION_COOKIE"
```

### Example using JavaScript

```javascript
// Login
fetch('/login', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json',
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
  },
  body: JSON.stringify({
    email: 'admin@example.com',
    password: 'password'
  })
})
.then(response => response.json())
.then(data => console.log(data));

// Get data with DataTables
$('#table').DataTable({
  processing: true,
  serverSide: true,
  ajax: '/kodePerkiraan',
  columns: [
    { data: 'kode', name: 'kode' },
    { data: 'nama', name: 'nama' },
    { data: 'actions', orderable: false, searchable: false }
  ]
});
```

## Changelog

### Version 1.0.0 (Current)
- Initial API implementation
- CRUD operations for all master data
- Transaction management
- Reporting endpoints
- Export functionality

