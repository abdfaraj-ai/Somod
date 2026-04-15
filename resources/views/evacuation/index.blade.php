@extends('layouts.app')

@section('title', 'خريطة الإخلاء - منصة صمود')

@section('content')
<div class="container py-4" dir="ltr">
    <!-- Header -->
    <div class="card border-0 shadow-sm mb-4 rounded-4 overflow-hidden"dir="ltr">
        <div class="card-body p-0">
            <div class="row g-0">
                <div class="col-md-8 p-4">
                    <h2 class="fw-bold text-dark"><i class="bi bi-map-fill text-danger me-2"></i>خريطة الإخلاء</h2>
                    <p class="text-muted mb-0">تحديثات فورية حول حالة المناطق الأمنية وأوامر الإخلاء.</p>
                </div>
                <div class="col-md-4 bg-light d-flex align-items-center justify-content-center p-3">
                    <i class="bi bi-houses-fill text-muted opacity-25 display-1"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4" dir="ltr">
        <!-- Stats Panel -->
        <div class="col-lg-3">
            <!-- Search Block -->
                    <div class="card shadow-sm border-0 mb-4 rounded-4">
                        <div class="card-header bg-white fw-bold py-3 border-bottom">
                            <i class="bi bi-search me-2 text-dark"></i> فحص حالة البلوك
                        </div>
                <div class="card-body">
                    <form action="{{ route('evacuation.search') }}" method="POST">
                        @csrf
                        <label class="form-label small text-muted">أدخل رقم البلوك</label>
                        <div class="input-group mb-3">
                            <input type="text" name="block_number" class="form-control" placeholder="مثال: 2301, A15">
                            <button class="btn btn-primary px-4" type="submit">فحص</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="row g-3">
                <div class="col-12">
                    <div class="card bg-success text-white border-0 shadow-sm">
                        <div class="card-body text-center py-3">
                            <i class="bi bi-shield-check display-4 mb-2 opacity-75"></i>
                            <h3 class="fw-bold">{{ $stats['safe'] }}</h3>
                            <p class="mb-0">منطقة آمنة</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-6">
                    <div class="card bg-warning text-dark border-0 shadow-sm">
                        <div class="card-body text-center py-3">
                            <i class="bi bi-exclamation-triangle fs-2 mb-2"></i>
                            <h5 class="fw-bold">{{ $stats['warning'] }}</h5>
                            <small>تحذير</small>
                        </div>
                    </div>
                </div>
                
                <div class="col-6">
                    <div class="card bg-danger text-white border-0 shadow-sm">
                        <div class="card-body text-center py-3">
                            <i class="bi bi-exclamation-circle fs-2 mb-2"></i>
                            <h5 class="fw-bold">{{ $stats['danger'] }}</h5>
                            <small>خطر</small>
                        </div>
                    </div>
                </div>
                
                <div class="col-12">
                    <div class="card bg-dark text-white border-0 shadow-sm">
                        <div class="card-body text-center py-3">
                            <i class="bi bi-people-fill fs-2 mb-2"></i>
                            <h5 class="fw-bold">{{ $stats['evacuation'] }}</h5>
                            <small>إخلاء فوري</small>
                        </div>
                    </div>
                </div>
            </div>

            
        </div>

        <!-- Interactive Map Grid -->
        <div class="col-lg-9">
           

            <!-- Map Grid -->
            <div class="card shadow border-0 overflow-hidden rounded-4" style="height: 600px;">
                <div class="card-body p-0 position-relative bg-white h-100 d-flex flex-column">
                    <div class="bg-dark text-white p-2 small text-center d-flex align-items-center justify-content-center gap-2">
                        <i class="bi bi-hand-index-thumb"></i> انقر على المربعات لمعرفة التفاصيل
                    </div>
                    
                    <!-- Map Container -->
                    <div class="overflow-auto flex-grow-1 p-3 bg-light">
                        <div class="map-grid-container" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(80px, 1fr)); gap: 10px;">
                            @foreach($blocks as $block)
                            <a href="{{ route('evacuation.show', $block->id) }}" 
                               class="map-block text-decoration-none">
                                <div class="map-cell rounded-2 text-center p-3 shadow-sm border position-relative"
                                     style="background-color: {{ $block->status == 'safe' ? '#d1e7dd' : ($block->status == 'warning' ? '#fff3cd' : ($block->status == 'danger' ? '#f8d7da' : '#212529')) }};
                                            color: {{ $block->status == 'safe' ? '#0f5132' : ($block->status == 'warning' ? '#664d03' : ($block->status == 'danger' ? '#842029' : '#ffffff')) }};
                                            border: 2px solid {{ $block->status == 'safe' ? '#badbcc' : ($block->status == 'warning' ? '#ffecb5' : ($block->status == 'danger' ? '#f5c2c7' : '#495057')) }};">
                                    
                                    @if($block->has_shelter)
                                    <i class="bi bi-house-heart position-absolute" style="top: 5px; left: 5px; font-size: 0.8rem;"></i>
                                    @endif
                                    
                                    @if($block->has_medical)
                                    <i class="bi bi-heart-pulse position-absolute" style="top: 5px; right: 5px; font-size: 0.8rem;"></i>
                                    @endif
                                    
                                    <div class="block-number fw-bold mb-1">{{ $block->block_number }}</div>
                                    <div class="block-status small">
                                        <i class="bi {{ $block->status_icon }}"></i>
                                        {{ $block->status_arabic }}
                                    </div>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Map Legend -->
                    <div class="position-absolute bottom-0 end-0 m-3 p-3 bg-white rounded-3 shadow border" style="z-index: 10; font-size: 0.85rem;">
                        <h6 class="fw-bold mb-2 small">مفتاح الخريطة</h6>
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <div style="width: 20px; height: 20px; background-color: #d1e7dd; border: 1px solid #badbcc;" class="rounded"></div>
                            <small>آمن</small>
                        </div>
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <div style="width: 20px; height: 20px; background-color: #fff3cd; border: 1px solid #ffecb5;" class="rounded"></div>
                            <small>تحذير</small>
                        </div>
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <div style="width: 20px; height: 20px; background-color: #f8d7da; border: 1px solid #f5c2c7;" class="rounded"></div>
                            <small>خطر</small>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <div style="width: 20px; height: 20px; background-color: #212529; border: 1px solid #495057;" class="rounded"></div>
                            <small>إخلاء</small>
                        </div>
                        
                        <hr class="my-2">
                        
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <i class="bi bi-house-heart text-primary"></i>
                            <small>ملجأ</small>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-heart-pulse text-danger"></i>
                            <small>خدمات طبية</small>
                        </div>
                    </div>
                </div>
            </div>
            

                
<br>

            <!-- Alert Bar -->
            @if($alerts->count() > 0)
            <div class="card shadow-sm border-0 rounded-4 overflow-hidden" >
                        <div class="card-header bg-danger text-white fw-bold py-3"dir="ltr">
                        <h6 class="fw-bold mb-1">تنبيهات عاجلة</h6>
                        </div>
                        <div class="row g-2" >
                            @foreach($alerts as $alert)
                            <div class="col-md-6"style="border:0.0002em solid;">
                                <div class="bg-white bg-opacity-25 p-2 rounded-2">
                                    <small class="fw-bold">بلوك {{ $alert->block_number }}</small>
                                    <small class="d-block">{{ $alert->area }}</small>
                                    <span class="badge bg-{{ $alert->status_color }}">
                                        {{ $alert->status_arabic }}
                                    </span>
                                    <small class="d-block">{{ $alert->description }}</small>
                                </div>
                            </div>
                            @endforeach
                        </div>
                                   
            </div>
            @endif
            <br>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .map-block:hover .map-cell {
        transform: scale(1.05);
        transition: transform 0.2s;
    }
    
    .map-cell {
        min-height: 80px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        transition: all 0.3s;
    }
    
    .block-number {
        font-size: 1.1rem;
    }
    
    .block-status {
        font-size: 0.8rem;
    }
</style>
@endpush