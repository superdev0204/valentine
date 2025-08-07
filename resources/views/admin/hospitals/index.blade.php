@extends('layouts.app')

@section('title', 'Hospital Management')

@section('content')
<div class="row justify-content-center">
    <div class="col-12">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-gradient-danger text-white d-flex justify-content-between align-items-center py-3">
                <div class="d-flex align-items-center">
                    <i class="bi bi-heart-pulse display-6 me-3"></i>
                    <div>
                        <h4 class="mb-0 fw-bold">Hospital Management</h4>
                        <small class="opacity-75">Manage participating hospitals and healthcare organizations</small>
                    </div>
                </div>
                <button type="button" class="btn btn-light btn-lg shadow-sm" data-bs-toggle="modal" data-bs-target="#importModal">
                    <i class="bi bi-upload me-2"></i> Import
                </button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-danger">
                            <tr>
                                <th scope="col" class="text-center" style="width: 60px;">
                                    <i class="bi bi-hash"></i>
                                </th>
                                <th scope="col" style="min-width: 250px;">
                                    <i class="bi bi-heart-pulse me-1"></i>Organization Name
                                </th>
                                <th scope="col" style="min-width: 250px;">
                                    <i class="bi bi-building me-1"></i>Organization Type
                                </th>
                                <th scope="col" style="min-width: 250px;">
                                    <i class="bi bi-person me-1"></i>Contact Person
                                </th>
                                <th scope="col" style="min-width: 250px;">
                                    <i class="bi bi-envelope me-1"></i>Contact Info
                                </th>
                                <th scope="col" style="min-width: 250px;">
                                    <i class="bi bi-geo-alt me-1"></i>Address
                                </th>
                                <th scope="col" class="text-center" style="min-width: 200px;">
                                    <i class="bi bi-heart me-1"></i>Valentine Cards
                                </th>
                                <th scope="col" style="min-width: 200px;">
                                    <i class="bi bi-tag me-1"></i>Box Style
                                </th>
                                <th scope="col" style="min-width: 200px;">
                                    <i class="bi bi-arrows-angle-expand me-1"></i>Dimensions
                                </th>
                                <th scope="col" style="min-width: 200px;">
                                    <i class="bi bi-box me-1"></i>Empty Box
                                </th>
                                <th scope="col" style="min-width: 200px;">
                                    <i class="bi bi-weight me-1"></i>Weight
                                </th>
                                <th scope="col" style="min-width: 200px;">
                                    <i class="bi bi-link-45deg me-1"></i>Prefilled Link
                                </th>
                                <th scope="col" class="text-center" style="min-width: 200px;">
                                    <i class="bi bi-toggle-on me-1"></i>Status
                                </th>
                                <th scope="col" class="sticky-action-col text-center" style="z-index:3; min-width: 120px;">
                                    <i class="bi bi-gear me-1"></i>Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($hospitals as $hospital)
                                <tr class="border-bottom">
                                    <td class="text-center">
                                        <span class="badge bg-secondary rounded-pill">{{ $hospital->id }}</span>
                                    </td>
                                    <td>
                                        <div class="fw-semibold text-dark">{{ $hospital->organization_name }}</div>
                                        <small class="text-primary">{{ $hospital->valentine_opt_in }}</small>
                                    </td>
                                    <td>
                                        <div class="fw-semibold text-dark">{{ $hospital->organization_type }}</div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <div class="fw-semibold">{{ $hospital->contact_person_name }}</div>
                                            <small class="text-muted">{{ $hospital->how_to_address }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-envelope text-muted me-1"></i>
                                                <span class="fw-semibold">{{ $hospital->email }}</span>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-telephone text-muted me-1"></i>
                                                <span class="text-muted">{{ $hospital->phone }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <small class="text-muted">{{ $hospital->street }}</small>
                                            <small class="text-muted">{{ $hospital->city }}, {{ $hospital->state }} {{ $hospital->zip }}</small>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex flex-column align-items-center">
                                            <span class="badge bg-danger">{{ $hospital->valentine_card_count }} Valentine Cards</span>
                                            <span class="badge bg-info">{{ $hospital->extra_staff_cards }} Staff Cards</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary fs-6 px-3 py-2">{{ $hospital->box_style }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <small class="text-muted">L: {{ $hospital->length }} × W: {{ $hospital->width }} × H: {{ $hospital->height }}</small>
                                            <small class="text-success fw-semibold">{{ $hospital->length * $hospital->width * $hospital->height }} cm³</small>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-warning text-dark">{{ $hospital->empty_box }}</span>
                                    </td>
                                    <td>
                                        <span class="fw-semibold text-info">{{ $hospital->weight }}g</span>
                                    </td>
                                    <td>
                                        @if($hospital->prefilled_link)
                                            <a href="{{ $hospital->prefilled_link }}" target="_blank" class="text-decoration-none">
                                                <i class="bi bi-box-arrow-up-right me-1"></i>Open Form
                                            </a>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex flex-column align-items-center">
                                            @if($hospital->standing_order)
                                                <span class="badge bg-success">
                                                    <i class="bi bi-check-circle me-1"></i>Standing Order
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">
                                                    <i class="bi bi-x-circle me-1"></i>No Standing Order
                                                </span>
                                            @endif
                                            @if($hospital->update_status)
                                                <span class="badge bg-warning text-dark mt-1">
                                                    <i class="bi bi-envelope-check me-1"></i>Updated
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="sticky-action-col bg-light text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.hospitals.edit', $hospital) }}" class="btn btn-outline-primary btn-sm" title="Edit Hospital">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <form action="{{ route('admin.hospitals.delete', $hospital) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this hospital? This action cannot be undone.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm" title="Delete Hospital">
                                                    <i class="bi bi-trash3"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="14" class="text-center py-5">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="bi bi-heart-pulse display-1 text-muted mb-3"></i>
                                            <h5 class="text-muted mb-3">No hospitals found</h5>
                                            <p class="text-muted mb-4">Start by adding your first participating hospital or healthcare organization.</p>
                                            <a href="#" class="btn btn-danger btn-lg shadow-sm" data-bs-toggle="modal" data-bs-target="#importModal">
                                                <i class="bi bi-upload me-2"></i>Import
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($hospitals->count() > 0)
                <div class="card-footer bg-light text-center py-3">
                    <div class="row">
                        <div class="col-md-4">
                            <small class="text-muted">
                                <i class="bi bi-heart-pulse me-1"></i>
                                Total Hospitals: {{ $hospitals->count() }}
                            </small>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted">
                                <i class="bi bi-check-circle me-1"></i>
                                Standing Orders: {{ $hospitals->where('standing_order', true)->count() }}
                            </small>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted">
                                <i class="bi bi-envelope-check me-1"></i>
                                Updated: {{ $hospitals->where('updated_status', true)->count() }}
                            </small>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .bg-gradient-danger {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
    }
    .table > :not(caption) > * > * {
        padding: 1rem 0.75rem;
    }
    .btn-group .btn {
        border-radius: 0.375rem !important;
        margin: 0 2px;
    }
    thead th {
        position: sticky;
        top: 0;
        background-color: #f8d7da; /* match .table-danger */
        z-index: 3;
    }
    .sticky-action-col {
        position: sticky;
        right: 0;
        z-index: 2; /* ensure it's above other cells */
        background: inherit; /* or use bg-light/bg-white */
    }
</style>

<!-- Import Confirmation Modal -->
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="importModalLabel">Import Hospitals from Google Spreadsheet</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to import hospital data from the Google Spreadsheet? This will fetch and update the hospitals list.</p>
      </div>
      <div class="modal-footer">
        <form action="{{ route('admin.hospitals.import') }}" method="POST">
          @csrf
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger">Yes, Import</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection 