@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Blockchain Explorer</h4>
                    <span class="badge bg-{{ $isValid ? 'success' : 'danger' }}">
                        {{ $isValid ? 'Valid Chain' : 'Invalid Chain' }}
                    </span>
                </div>
            </div>
            
            <div class="card-body">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    This blockchain contains {{ $blocks->count() }} blocks. 
                    Each vote is recorded as a new block in the chain.
                </div>
                
                @foreach($blocks as $block)
                <div class="card mb-3 block-card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Block #{{ $block->id }}</h5>
                        <small class="text-muted">{{ $block->formatted_date }}</small>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <h6>Previous Hash:</h6>
                                <div class="p-2 bg-light rounded">
                                    <code class="d-block text-truncate">{{ $block->previous_hash }}</code>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h6>Current Hash:</h6>
                                <div class="p-2 bg-light rounded">
                                    <code class="d-block text-truncate">{{ $block->hash }}</code>
                                </div>
                            </div>
                        </div>
                        
                        <h6>Block Data:</h6>
                        <div class="p-3 bg-light rounded">
                            <pre class="mb-0">{{ json_encode($block->data, JSON_PRETTY_PRINT) }}</pre>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection