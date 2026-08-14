@forelse ($data as $info)
    <div class="col-lg-4 col-md-6 list-orphan-element">
        <div class="kanaf-card h-100 bg-white shadow-sm">
            <div class="position-relative overflow-hidden">
                {{-- فحص الصورة مع خاصية onerror في حال كان الملف غير موجود --}}
                <img src="{{ $info->personal_photo_path ? asset('Uploads/orphans/' . $info->personal_photo_path) : asset('Uploads/orphans/default.png') }}"
                    onerror="this.onerror=null;this.src='{{ asset('Uploads/orphans/default.png') }}';" alt="Orphan Image"
                    class="card-img-top w-100" style="height: 250px; object-fit: cover;" referrerpolicy="no-referrer">

                <span
                    class="badge position-absolute top-0 right-0 bg-primary-green px-3 py-2 fw-semibold rounded-3 text-white m-3"
                    style="right: 14px; left: auto; z-index: 5;">
                    {{ $info->country ?? 'غير محدد' }} - {{ $info->city ?? 'غير محدد' }}
                </span>

                <span
                    class="badge position-absolute top-0 left-0 px-3 py-2 fw-semibold rounded-3 text-white m-3 bg-primary-green"
                    style="left: 14px; right: auto; z-index: 5;">
                    {{ $info->status ?? 'بانتظار الكفالة' }}
                </span>
            </div>

            <div class="card-body p-4">
                <div class="mb-2 d-flex align-items-center gap-1">
                    <i class="bi bi-star-fill text-secondary-gold" style="font-size: 0.85rem;"></i>
                    <i class="bi bi-star-fill text-secondary-gold" style="font-size: 0.85rem;"></i>
                    <i class="bi bi-star-fill text-secondary-gold" style="font-size: 0.85rem;"></i>
                    <i class="bi bi-star-fill text-secondary-gold" style="font-size: 0.85rem;"></i>
                    <i class="bi bi-star-fill text-secondary-gold" style="font-size: 0.85rem;"></i>
                </div>

                <h5 class="fw-black text-dark mb-2">{{ $info->first_name ?? $info->name }}</h5>

                <div class="d-flex flex-wrap gap-1 mb-3">
                    @if ($info->is_double_orphan)
                        <span
                            class="badge bg-danger-subtle text-danger border border-danger-subtle px-2.5 py-1 rounded-pill"
                            style="font-size: 0.72rem; font-weight: 700;">
                            يتيم الأبوين
                        </span>
                    @endif

                    @if ($info->is_sole_breadwinner)
                        <span class="badge bg-dark-subtle text-dark border border-dark-subtle px-2.5 py-1 rounded-pill"
                            style="font-size: 0.72rem; font-weight: 700;">
                            ناجي وحيد
                        </span>
                    @endif

                    @if ($info->is_critically_needy)
                        <span
                            class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-2.5 py-1 rounded-pill"
                            style="font-size: 0.72rem; font-weight: 700;">
                            أشد حاجة
                        </span>
                    @endif

                    @if ($info->is_war_injured)
                        <span class="badge bg-danger text-white px-2.5 py-1 rounded-pill"
                            style="font-size: 0.72rem; font-weight: 700;">
                            جريح حرب
                        </span>
                    @endif

                    @if ($info->has_chronic_disease)
                        <span
                            class="badge bg-info-subtle text-info-emphasis border border-info-subtle px-2.5 py-1 rounded-pill"
                            style="font-size: 0.72rem; font-weight: 700;">
                            مرض مزمن
                        </span>
                    @endif
                </div>

                <div class="d-flex gap-3 text-muted text-small mb-3" style="font-size: 0.85rem; font-weight: 600;">
                    <span><i class="bi bi-calendar3 text-primary-green me-1"></i>العمر: {{ $info->age ?? '-' }}
                        سنوات</span>
                    <span><i class="bi bi-shield-heart text-primary-green me-1"></i>الحالة:
                        {{ $info->health_status ?? 'جيدة' }}</span>
                </div>

                <div class="mb-3 text-muted text-small" style="font-size: 0.85rem; font-weight: 600;">
                    <i class="bi bi-book text-primary-green me-1"></i> التعليم:
                    <span class="fw-semibold text-dark">المرحلة {{ $info->education_level ?? 'الابتدائية' }}</span>
                </div>

                <p class="text-muted text-small small lh-base mb-4"
                    style="height: 72px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical;">
                    {{ $info->story ?? 'لا توجد تفاصيل إضافية متاحة حالياً.' }}
                </p>

                <div class="mb-4">
                    <div class="d-flex justify-content-between text-small mb-1"
                        style="font-size: 0.82rem; font-weight: 700;">
                        <span class="text-muted">درجة اكتمال الكفالة</span>
                        <span class="fw-semibold text-success">0%</span>
                    </div>
                    <div class="progress"
                        style="height: 6px; background-color: var(--light-gray); border-radius: 999px; overflow: hidden;">
                        <div class="progress-bar" role="progressbar"
                            style="width: 0%; background-color: var(--secondary-gold);" aria-valuenow="0"
                            aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>

                <div class="border-top pt-3 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted d-block text-small mb-1"
                            style="font-size: 0.75rem; font-weight: 700;">مبلغ الكفالة</span>
                        <span class="fs-4 fw-black text-primary-green">$ {{ $info->required_amount ?? 50 }}</span>
                        <span class="text-muted text-small" style="font-size: 0.8rem;">/شهرياً</span>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('orphans_details', $info->id) }}" class="btn btn-primary">التفاصيل</a>
                        <a href="{{ route('step1', $info->id) }}"
                            class="btn btn-secondary btn-sm px-3 fw-bold rounded-pill">اكفل</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@empty
    {{-- يتم التحكم بعرض الـ Empty State عبر الجافاسكريبت أو يُترك فارغاً --}}
@endforelse
