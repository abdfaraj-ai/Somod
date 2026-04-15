@extends('frontend.layouts.app')

@section('content')
    <div id="view-market" class="view-section pb-5 active">
        <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden"
            style="background: linear-gradient(45deg, #0d6efd, #0dcaf0);">
            <div class="card-body p-4 text-white">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h2 class="fw-bold mb-1"><i class="bi bi-shop me-2"></i>السوق المركزي</h2>
                        <p class="mb-0 opacity-90">أسعار السلع وتوفرها - تحديث مباشر من المجتمع المحلي.</p>
                    </div>
                    <div class="col-md-4 text-end mt-3 mt-md-0">
                        <button class="btn btn-light text-primary fw-bold rounded-pill px-4 shadow-sm"
                            data-bs-toggle="modal" data-bs-target="#addMarketModal">
                            <i class="bi bi-plus-lg"></i> إضافة تحديث
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Categories -->
        <!-- Categories -->
        <div class="d-flex gap-2 overflow-auto pb-3 mb-3 no-scrollbar" id="market-categories">
            <a href="{{ route('frontend.market') }}"
                class="btn {{ !request('category') || request('category') == 'all' ? 'btn-dark' : 'btn-outline-secondary' }} rounded-pill px-4 text-nowrap category-btn">
                الكل
            </a>
            @foreach($categories as $category)
                <a href="{{ route('frontend.market', array_merge(request()->query(), ['category' => $category->id])) }}"
                    class="btn {{ request('category') == $category->id ? 'btn-dark' : 'btn-outline-secondary' }} rounded-pill px-4 text-nowrap category-btn">
                    @if($category->icon_path) <img src="{{ $category->icon_url }}"
                    style="height:20px;width:20px;object-fit:contain" class="me-1"> @endif
                    {{ $category->name }}
                </a>
            @endforeach
        </div>

        <!-- Search -->
        <!-- Search -->
        <form action="{{ route('frontend.market') }}" method="GET"
            class="input-group mb-4 shadow-sm rounded-pill overflow-hidden bg-white">
            <span class="input-group-text bg-white border-0 ps-3"><i class="bi bi-search text-muted"></i></span>
            @if(request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
            @endif
            <input type="text" name="search" value="{{ request('search') }}" class="form-control border-0 shadow-none ps-0"
                placeholder="ابحث عن سلعة (طحين، غاز، خيام...)">
        </form>

        <!-- Items Grid -->
        <!-- Items Grid -->
        <div class="row g-3" id="market-grid">
            @include('frontend.market._grid')
        </div>


    </div>

    <!-- Market Add Modal -->
    <div class="modal fade" id="addMarketModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow-lg">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">إضافة تحديث للسوق</h5>
                    <button type="button" class="btn-close ms-0 me-auto" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="marketForm" onsubmit="submitMarketItem(event)">
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold">اسم السلعة / الخدمة</label>
                            <input type="text" class="form-control bg-light border-0" id="m-name" required
                                placeholder="مثال: ربطة خبز، شحن جوال">
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <label class="form-label text-muted small fw-bold">السعر (شيكل)</label>
                                <input type="number" class="form-control bg-light border-0" id="m-price"
                                    placeholder="مثال: 10">
                            </div>
                            <div class="col-6">
                                <label class="form-label text-muted small fw-bold">الفئة</label>
                                <select class="form-select bg-light border-0" id="m-type">
                                    <option value="food">مواد غذائية</option>
                                    <option value="energy">طاقة ووقود</option>
                                    <option value="medical">صحة وأدوية</option>
                                    <option value="services">خدمات</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold">حالة التوفر</label>
                            <select class="form-select bg-light border-0" id="m-status">
                                <option value="available">متوفر بكثرة</option>
                                <option value="scarce">شحيح / قليل</option>
                                <option value="out">غير متوفر</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold">المكان / الملاحظات</label>
                            <input type="text" class="form-control bg-light border-0" id="m-location" required
                                placeholder="مثال: سوق النصيرات - بسطة أبو محمد">
                        </div>
                        <button type="submit" class="btn btn-primary w-100 fw-bold rounded-pill py-2">نشر التحديث</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Function to fetch and update grid
            function fetchMarketData(url) {
                const grid = document.getElementById('market-grid');
                grid.style.opacity = '0.5';

                fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                    .then(response => response.text())
                    .then(html => {
                        grid.innerHTML = html;
                        grid.style.opacity = '1';
                        // Update URL history without refresh
                        window.history.pushState(null, '', url);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        grid.style.opacity = '1';
                    });
            }

            // Handle Category Clicks
            document.querySelectorAll('.category-btn').forEach(btn => {
                btn.addEventListener('click', function (e) {
                    e.preventDefault();

                    // Update active state
                    document.querySelectorAll('.category-btn').forEach(b => {
                        b.classList.remove('btn-dark');
                        b.classList.add('btn-outline-secondary');
                    });
                    this.classList.remove('btn-outline-secondary');
                    this.classList.add('btn-dark');

                    fetchMarketData(this.href);
                });
            });

            // Handle Search Form
            const searchForm = document.querySelector(`form[action="{{ route('frontend.market') }}"]`);
            if (searchForm) {
                searchForm.addEventListener('submit', function (e) {
                    e.preventDefault();
                    const url = new URL(this.action);
                    const params = new URLSearchParams(new FormData(this));
                    url.search = params.toString();
                    fetchMarketData(url.toString());
                });
            }

            // Handle Pagination Clicks (Delegation)
            document.getElementById('market-grid').addEventListener('click', function (e) {
                const link = e.target.closest('.pagination a');
                if (link) {
                    e.preventDefault();
                    fetchMarketData(link.href);
                }
            });
        });
    </script>
@endpush