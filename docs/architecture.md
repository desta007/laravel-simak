# Architecture Documentation - SIMAK

## System Architecture

SIMAK menggunakan arsitektur MVC (Model-View-Controller) yang merupakan pattern default dari Laravel Framework.

### High-Level Architecture

```
┌─────────────────────────────────────────────────────────┐
│                      User Interface                      │
│              (Browser - AdminLTE Theme)                  │
└────────────────────┬────────────────────────────────────┘
                     │ HTTP Request/Response
                     │
┌────────────────────┴────────────────────────────────────┐
│                    Web Server Layer                      │
│              (Apache/Nginx + PHP-FPM)                    │
└────────────────────┬────────────────────────────────────┘
                     │
┌────────────────────┴────────────────────────────────────┐
│                  Laravel Application                     │
│  ┌─────────────────────────────────────────────────┐   │
│  │           Routes (web.php)                      │   │
│  └────────────┬────────────────────────────────────┘   │
│               │                                          │
│  ┌────────────┴────────────────────────────────────┐   │
│  │           Middleware                            │   │
│  │  - Authentication (Fortify)                     │   │
│  │  - CSRF Protection                              │   │
│  │  - Session Management                           │   │
│  └────────────┬────────────────────────────────────┘   │
│               │                                          │
│  ┌────────────┴────────────────────────────────────┐   │
│  │         Controllers                             │   │
│  │  - CabangController                             │   │
│  │  - TransaksiController                          │   │
│  │  - ReportController                             │   │
│  │  - etc.                                         │   │
│  └────────┬────────────────────┬───────────────────┘   │
│           │                    │                        │
│  ┌────────┴─────────┐  ┌──────┴──────────────────┐    │
│  │   Models         │  │   Views (Blade)          │    │
│  │  - User          │  │  - layout/               │    │
│  │  - Transaksi     │  │  - master/               │    │
│  │  - KodePerkiraan │  │  - transaksi/            │    │
│  │  - etc.          │  │  - report/               │    │
│  └────────┬─────────┘  └──────────────────────────┘    │
│           │                                              │
└───────────┴──────────────────────────────────────────────┘
            │
┌───────────┴──────────────────────────────────────────────┐
│                 Database Layer                            │
│                 (MySQL/MariaDB)                           │
└───────────────────────────────────────────────────────────┘
```

## Application Layers

### 1. Presentation Layer (Views)

**Technology:** Blade Templates, AdminLTE, Bootstrap, jQuery

**Responsibilities:**
- Display data to users
- Capture user input
- Client-side validation
- AJAX interactions

**Structure:**
```
resources/views/
├── auth/           # Authentication views
├── layout/         # Layout components (header, sidebar, footer)
├── master/         # Master data views
├── transaksi/      # Transaction views
├── report/         # Report views
└── modal/          # Modal components
```

### 2. Application Layer (Controllers)

**Technology:** Laravel Controllers

**Responsibilities:**
- Handle HTTP requests
- Validate input
- Coordinate between models and views
- Return responses

**Key Controllers:**
- `CabangController`: Manage branches
- `ProyekController`: Manage projects
- `TransaksiController`: Handle transactions
- `ReportController`: Generate reports
- `UserController`: User management
- `KodePerkiraanController`: Chart of accounts

**Pattern:**
```php
class TransaksiController extends Controller
{
    public function index()     // Display list
    public function create()    // Show create form
    public function store()     // Save new data
    public function show($id)   // Show detail
    public function edit($id)   // Show edit form
    public function update($id) // Update data
    public function destroy($id)// Delete data
}
```

### 3. Business Logic Layer (Models)

**Technology:** Eloquent ORM

**Responsibilities:**
- Data structure definition
- Database interactions
- Relationships between entities
- Business rules

**Core Models:**
- `User`: User authentication and profile
- `Cabang`: Branch data
- `Proyek`: Project data
- `Transaksi`: Transaction header
- `TransaksiDetail`: Transaction details
- `KodePerkiraan`: Chart of accounts
- `SaldoAkun`: Account balances

**Relationships:**
```php
// One-to-Many
Cabang -> hasMany -> Proyek
Transaksi -> hasMany -> TransaksiDetail

// Many-to-One
User -> belongsTo -> Cabang
KodePerkiraan -> belongsTo -> GroupAccount

// Many-to-Many
User -> belongsToMany -> Proyek (through UserProyek)
```

### 4. Data Access Layer

**Technology:** Eloquent ORM, Query Builder

**Responsibilities:**
- Database queries
- Data persistence
- Transaction management
- Migrations

**Operations:**
- CRUD operations
- Complex queries for reports
- Aggregations (SUM, COUNT, etc.)
- Joins and relationships

### 5. Database Layer

**Technology:** MySQL/MariaDB

**Schema Overview:**
```
Users & Permissions:
├── users
├── group_users
├── user_permissions
└── user_proyeks

Master Data:
├── cabangs
├── proyeks
├── kode_buktis
├── group_accounts
├── kode_perkiraans
└── pejabats

Transactions:
├── transaksis
├── transaksi_details
├── saldo_akuns
└── kunci_transaksis

Quality:
├── pedoman_mutus
└── catatan_mutus
```

## Design Patterns

### 1. MVC Pattern

**Model:** Represents data and business logic
**View:** Presentation layer
**Controller:** Handles requests and coordinates

### 2. Repository Pattern (Implicit through Eloquent)

```php
// Model acts as repository
$transaksis = Transaksi::where('id_cabang', $cabangId)
    ->with(['cabang', 'proyek'])
    ->get();
```

### 3. Dependency Injection

```php
public function __construct(
    TransaksiRepository $transaksiRepo,
    SaldoAkunService $saldoService
) {
    $this->transaksiRepo = $transaksiRepo;
    $this->saldoService = $saldoService;
}
```

### 4. Service Provider Pattern

```php
// AppServiceProvider
public function register()
{
    $this->app->bind(
        TransaksiServiceInterface::class,
        TransaksiService::class
    );
}
```

## Data Flow

### Transaction Entry Flow

```
1. User fills form
   ↓
2. JavaScript validation
   ↓
3. Submit form (POST request)
   ↓
4. Laravel receives request
   ↓
5. Middleware checks (Auth, CSRF)
   ↓
6. Controller receives request
   ↓
7. Server-side validation
   ↓
8. Controller calls Model
   ↓
9. Model saves to database
   ↓
10. Database returns result
    ↓
11. Controller returns response
    ↓
12. View displays success/error
```

### Report Generation Flow

```
1. User selects report parameters
   ↓
2. Submit request
   ↓
3. Controller receives request
   ↓
4. Validate parameters
   ↓
5. Query database (complex queries)
   ↓
6. Process data
   ↓
7. Format data for display
   ↓
8. Return view/export file
   ↓
9. Display report to user
```

## Security Architecture

### Authentication Flow

```
1. User submits credentials
   ↓
2. Fortify handles authentication
   ↓
3. Verify credentials
   ↓
4. Create session
   ↓
5. Set cookies
   ↓
6. Redirect to dashboard
```

### Authorization Layers

1. **Route Middleware:**
   - `auth`: Requires authentication
   
2. **Permission Check:**
   - Check user_permissions table
   - Verify menu access (admin/read/none)

3. **Controller Logic:**
   - Additional business logic checks
   - Data scope (cabang, proyek)

### Data Security

- **Passwords:** Hashed with bcrypt
- **CSRF:** Token validation on all POST/PUT/DELETE
- **SQL Injection:** Protected via Eloquent ORM
- **XSS:** Blade templating auto-escapes output
- **Session:** Encrypted session data

## Performance Optimization

### Database Level

1. **Indexes:**
```sql
-- Primary indexes
CREATE INDEX idx_transaksis_tgl ON transaksis(tgl);
CREATE INDEX idx_transaksis_cabang_proyek ON transaksis(id_cabang, id_proyek);

-- Foreign key indexes
CREATE INDEX idx_transaksi_details_transaksi ON transaksi_details(id_transaksi);
```

2. **Query Optimization:**
- Eager loading (N+1 problem prevention)
- Select only needed columns
- Use indexes effectively

### Application Level

1. **Caching:**
```php
// Config caching
php artisan config:cache

// Route caching
php artisan route:cache

// View caching
php artisan view:cache
```

2. **Session:**
- Use Redis/Memcached for production

3. **Queuing:**
- Heavy processes in queue
- Email sending
- Report generation

## Scalability Considerations

### Horizontal Scaling

```
                Load Balancer
                     │
        ┌────────────┼────────────┐
        │            │            │
   App Server 1  App Server 2  App Server 3
        │            │            │
        └────────────┼────────────┘
                     │
              Database Cluster
              (Master-Slave)
```

### Vertical Scaling

- Increase server resources
- Optimize queries
- Add database indexes
- Use caching layers

## Technology Stack Summary

### Backend
- **Framework:** Laravel 10.x
- **Language:** PHP 8.1+
- **Database:** MySQL 8.0 / MariaDB 10.x
- **Authentication:** Laravel Fortify
- **API:** Laravel Sanctum (ready for future use)

### Frontend
- **Template:** AdminLTE 3
- **CSS Framework:** Bootstrap 4
- **JavaScript:** jQuery 3.x
- **UI Components:**
  - DataTables (interactive tables)
  - Select2 (enhanced dropdowns)
  - SweetAlert2 (alerts)

### Additional Libraries
- **Excel:** Maatwebsite Excel
- **PDF:** DomPDF
- **QR Code:** Simple QRCode
- **Charts:** (Future: Chart.js)

## Deployment Architecture

### Development

```
Local Machine
├── PHP Built-in Server
├── MySQL Local
└── Local File Storage
```

### Staging

```
Staging Server
├── Nginx + PHP-FPM
├── MySQL
└── Local Storage
```

### Production

```
Production Server
├── Nginx + PHP-FPM (Load Balanced)
├── MySQL Cluster (Master-Slave)
├── Redis (Cache & Session)
├── File Storage (NFS/S3)
└── Backup System
```

## API Architecture (Future)

For future mobile app or third-party integration:

```
Mobile App / Third-party
        │
        │ HTTP/HTTPS + JSON
        │
    API Gateway
        │
   Sanctum Auth
        │
  API Controllers
        │
  Same Models & Business Logic
        │
     Database
```

## Monitoring & Logging

### Application Logs
- Location: `storage/logs/laravel.log`
- Levels: emergency, alert, critical, error, warning, notice, info, debug

### Database Logs
- Slow query log
- Error log

### Web Server Logs
- Access log
- Error log

## Backup Strategy

```
Daily:
├── Database dump
└── Uploaded files backup

Weekly:
├── Full application backup
└── Config backup

Monthly:
└── Archive to external storage
```

## System Requirements

### Minimum Requirements
- CPU: 2 cores
- RAM: 4GB
- Disk: 20GB SSD
- PHP: 8.1+
- MySQL: 5.7+

### Recommended (Production)
- CPU: 4+ cores
- RAM: 8GB+
- Disk: 50GB+ SSD
- PHP: 8.2+
- MySQL: 8.0+
- Redis: 6.x+

## Future Architecture Enhancements

### Microservices (Long-term)

```
API Gateway
    │
    ├── User Service
    ├── Transaction Service
    ├── Report Service
    └── Export Service
```

### Cloud Migration

- AWS RDS for database
- S3 for file storage
- CloudFront for CDN
- ElastiCache for Redis

### Real-time Features

- WebSocket support
- Real-time notifications
- Live report updates

