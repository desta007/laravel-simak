# Changelog - SIMAK

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.0] - 2024-12-05

### Added - Initial Release

#### Master Data Management
- Master Cabang (Branch Management)
- Master Proyek (Project Management)
- Master Kode Bukti (Transaction Code Management)
- Master Group Account (Account Group Management)
- Master Kode Perkiraan (Chart of Accounts)
- Master Pejabat (Officer Data)

#### User Management
- User CRUD operations
- Role-based access control (3 user groups)
  - Admin (Full access)
  - Cabang Manager (Limited access)
  - Project User (Transaction focus)
- User permission management
- User-project assignment
- Password reset functionality

#### Transaction Management
- Journal transaction entry with multi-detail (debit/credit)
- Auto-generate transaction number
- Transaction document upload support
- Transaction search and filter
- Transaction edit and delete
- Transaction locking by period
- Set opening balance (Saldo Awal)
- Monthly data processing
- Year-end closing process

#### Reporting
- General Ledger
- Subsidiary Book (Buku Tambahan)
- Balance Sheet (Neraca)
  - Assets (Current, Fixed, Intangible, etc.)
  - Liabilities (Short-term, Long-term)
  - Equity
- Income Statement (Laba Rugi)
  - Revenue
  - Expenses
  - Net Income/Loss
- Project Financial Summary (Resume Keuangan Proyek)

#### Export Functionality
- Export to Excel format
- Export to PDF format
- Reports supported:
  - Balance Sheet
  - Income Statement
  - General Ledger
  - Project Financial Summary

#### Quality Management
- Quality Manual (Pedoman Mutu)
  - Document management
  - QR Code generation for documents
  - Version control
- Quality Records (Catatan Mutu)
  - Record tracking
  - Status management
  - Document attachment

#### UI/UX
- AdminLTE 3 dashboard theme
- Responsive design
- Interactive DataTables with server-side processing
- Select2 dropdown enhancement
- SweetAlert2 for user-friendly alerts
- Modal-based forms
- AJAX-powered searches

#### Security
- Laravel Fortify authentication
- CSRF protection
- Password hashing
- Session management
- Role-based menu access control

#### Technical Features
- Multi-branch support
- Multi-project support
- Double-entry bookkeeping system
- Automatic balance validation
- Period locking mechanism
- Audit trail through transaction documents

### Database Structure
- 16 main tables
- Proper foreign key relationships
- Indexes for performance
- Seeders for initial data

### API Endpoints
- RESTful resource routes for all modules
- AJAX endpoints for dynamic data
- DataTables server-side processing
- Modal content endpoints

## Migration History

### 2024-03-02
- Created group_users table
- Created user_permissions table
- Created cabangs table
- Created proyeks table
- Created user_proyeks table

### 2024-03-05
- Created kode_buktis table

### 2024-03-06
- Created group_accounts table
- Created kode_perkiraans table

### 2024-03-12
- Created transaksis table
- Created transaksi_details table

### 2024-03-19
- Created pedoman_mutus table
- Created catatan_mutus table

### 2024-03-26
- Created kunci_transaksis table

### 2024-03-28
- Created saldo_akuns table

### 2024-10-09
- Created pejabats table

## Dependencies

### PHP Packages
- laravel/framework: ^10.10
- laravel/fortify: ^1.20
- laravel/sanctum: ^3.3
- yajra/laravel-datatables-oracle: ^10.11
- maatwebsite/excel: ^3.1
- barryvdh/laravel-dompdf: ^2.1
- simplesoftwareio/simple-qrcode: ^4.2
- realrashid/sweet-alert: ^7.1

### Frontend Dependencies
- AdminLTE 3.x
- Bootstrap 4.x
- jQuery 3.x
- DataTables
- Select2
- SweetAlert2

## Known Issues

### Version 1.0.0
- None reported

## Planned Features

### Version 1.1.0 (Upcoming)
- [ ] Multi-currency support
- [ ] Budget management module
- [ ] Cash flow report
- [ ] Trial balance report
- [ ] API authentication with Sanctum tokens
- [ ] Mobile responsive improvements
- [ ] Batch transaction import from Excel
- [ ] Transaction approval workflow
- [ ] Email notifications
- [ ] Activity log/audit trail

### Version 1.2.0 (Future)
- [ ] Dashboard widgets and analytics
- [ ] Chart visualization for reports
- [ ] Automated recurring transactions
- [ ] Bank reconciliation module
- [ ] Fixed asset management
- [ ] Inventory integration
- [ ] Multi-language support
- [ ] Dark mode theme
- [ ] Advanced search filters
- [ ] Custom report builder

## Upgrade Guide

### From Development to 1.0.0
This is the initial release, no upgrade needed.

## Breaking Changes

### Version 1.0.0
- None (Initial Release)

## Security Updates

### Version 1.0.0
- Implemented CSRF protection
- Password hashing with bcrypt
- SQL injection protection via Eloquent ORM
- XSS protection via Blade templating
- Rate limiting for login attempts

## Performance Improvements

### Version 1.0.0
- Server-side DataTables processing
- Eager loading for database relations
- Database indexes on frequently queried columns
- Query optimization for reports
- Caching configuration for production

## Bug Fixes

### Version 1.0.0
- None (Initial Release)

## Documentation

### Version 1.0.0
- Complete installation guide
- User manual
- API documentation
- Database schema documentation
- Development guide
- Troubleshooting guide

## Contributors

### Version 1.0.0
- Development Team
- QA Team
- Documentation Team

## Support

For issues, questions, or contributions, please contact the development team.

---

## Version Format

Version format: `MAJOR.MINOR.PATCH`

- **MAJOR**: Incompatible API changes
- **MINOR**: Add functionality (backwards-compatible)
- **PATCH**: Bug fixes (backwards-compatible)

## Release Notes Template

```markdown
## [X.Y.Z] - YYYY-MM-DD

### Added
- New features

### Changed
- Changes in existing functionality

### Deprecated
- Soon-to-be removed features

### Removed
- Removed features

### Fixed
- Bug fixes

### Security
- Security fixes
```

