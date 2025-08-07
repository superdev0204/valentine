@extends('layouts.app')

@section('title', 'School Management')

@section('content')
<div class="row justify-content-center">
    <div class="col-12">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-gradient-danger text-white d-flex justify-content-between align-items-center py-3">
                <div class="d-flex align-items-center">
                    <i class="bi bi-building display-6 me-3"></i>
                    <div>
                        <h4 class="mb-0 fw-bold">School Management</h4>
                        <small class="opacity-75">Manage participating schools and organizations</small>
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
                                    <i class="bi bi-building me-1"></i>Organization
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
                                    <i class="bi bi-box me-1"></i>Quantities
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
                            @forelse ($schools as $school)
                                <tr class="border-bottom">
                                    <td class="text-center">
                                        <span class="badge bg-secondary rounded-pill">{{ $school->id }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <div class="fw-semibold text-dark">{{ $school->organization_name }}</div>
                                            <small class="text-primary">{{ $school->participation }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <div class="fw-semibold">{{ $school->contact_person_name }}</div>
                                            <small class="text-muted">{{ $school->how_to_address }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-envelope text-muted me-1"></i>
                                                <span class="fw-semibold">{{ $school->email }}</span>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-telephone text-muted me-1"></i>
                                                <span class="text-muted">{{ $school->phone }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <small class="text-muted">{{ $school->street }}</small>
                                            <small class="text-muted">{{ $school->city }}, {{ $school->state }} {{ $school->zip }}</small>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex flex-column align-items-center">
                                            <span class="badge bg-primary">{{ $school->envelope_quantity }} Envelopes</span>
                                            <span class="badge bg-info">{{ $school->instructions_cards }} Cards</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary fs-6 px-3 py-2">{{ $school->box_style }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <small class="text-muted">L: {{ $school->length }} × W: {{ $school->width }} × H: {{ $school->height }}</small>
                                            <small class="text-success fw-semibold">{{ $school->length * $school->width * $school->height }} cm³</small>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-warning text-dark">{{ $school->empty_box }}</span>
                                    </td>
                                    <td>
                                        <span class="fw-semibold text-info">{{ $school->weight }}g</span>
                                    </td>
                                    <td>
                                        @if($school->prefilled_link)
                                            <a href="{{ $school->prefilled_link }}" target="_blank" class="text-decoration-none">
                                                <i class="bi bi-box-arrow-up-right me-1"></i>Open Form
                                            </a>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex flex-column align-items-center">
                                            @if($school->standing_order)
                                                <span class="badge bg-success">
                                                    <i class="bi bi-check-circle me-1"></i>Standing Order
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">
                                                    <i class="bi bi-x-circle me-1"></i>No Standing Order
                                                </span>
                                            @endif
                                            @if($school->update_status)
                                                <span class="badge bg-warning text-dark mt-1">
                                                    <i class="bi bi-envelope-check me-1"></i>Updated
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="sticky-action-col bg-light text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.schools.edit', $school) }}" class="btn btn-outline-primary btn-sm" title="Edit School">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <form action="{{ route('admin.schools.delete', $school) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this school? This action cannot be undone.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm" title="Delete School">
                                                    <i class="bi bi-trash3"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="13" class="text-center py-5">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="bi bi-building display-1 text-muted mb-3"></i>
                                            <h5 class="text-muted mb-3">No schools found</h5>
                                            <p class="text-muted mb-4">Start by adding your first participating school or organization.</p>
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
            @if($schools->count() > 0)
                <div class="card-footer bg-light text-center py-3">
                    <div class="row">
                        <div class="col-md-4">
                            <small class="text-muted">
                                <i class="bi bi-building me-1"></i>
                                Total Schools: {{ $schools->count() }}
                            </small>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted">
                                <i class="bi bi-check-circle me-1"></i>
                                Standing Orders: {{ $schools->where('standing_order', true)->count() }}
                            </small>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted">
                                <i class="bi bi-envelope-check me-1"></i>
                                Updated: {{ $schools->where('update_status', true)->count() }}
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
        <h5 class="modal-title" id="importModalLabel">Import Schools from Google Spreadsheet</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to import school data from the Google Spreadsheet? This will fetch and update the schools list.</p>
      </div>
      <div class="modal-footer">
        <form action="{{ route('admin.schools.import') }}" method="POST">
          @csrf
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger">Yes, Import</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection 