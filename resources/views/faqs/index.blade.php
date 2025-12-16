@extends('layouts.main')

@section('title', 'FAQ')

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-16">
    <div class="container mx-auto px-4">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Frequently Asked Questions</h1>
            <p class="text-xl text-blue-100">Temukan jawaban atas pertanyaan yang sering diajukan</p>
        </div>
    </div>
</div>

<!-- FAQ Content -->
<div class="container mx-auto px-4 py-12">
    <!-- Search Box -->
    <div class="max-w-2xl mx-auto mb-8">
        <div class="relative">
            <input type="text" id="faqSearch" placeholder="Cari pertanyaan..." 
                class="w-full px-6 py-4 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent shadow-sm">
            <svg class="w-5 h-5 absolute right-6 top-1/2 transform -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>
    </div>

    <!-- Category Tabs -->
    <div class="flex flex-wrap justify-center gap-3 mb-8">
        <button class="category-tab active px-6 py-2 rounded-full bg-blue-600 text-white font-medium transition hover:bg-blue-700" data-category="all">
            Semua
        </button>
        <button class="category-tab px-6 py-2 rounded-full bg-gray-200 text-gray-700 font-medium transition hover:bg-gray-300" data-category="general">
            Umum
        </button>
        <button class="category-tab px-6 py-2 rounded-full bg-gray-200 text-gray-700 font-medium transition hover:bg-gray-300" data-category="membership">
            Keanggotaan
        </button>
        <button class="category-tab px-6 py-2 rounded-full bg-gray-200 text-gray-700 font-medium transition hover:bg-gray-300" data-category="payment">
            Pembayaran
        </button>
        <button class="category-tab px-6 py-2 rounded-full bg-gray-200 text-gray-700 font-medium transition hover:bg-gray-300" data-category="event">
            Event
        </button>
        <button class="category-tab px-6 py-2 rounded-full bg-gray-200 text-gray-700 font-medium transition hover:bg-gray-300" data-category="technical">
            Teknis
        </button>
    </div>

    <!-- FAQ Accordion -->
    <div class="max-w-4xl mx-auto">
        @php
            $categories = [
                'general' => 'Pertanyaan Umum',
                'membership' => 'Keanggotaan',
                'payment' => 'Pembayaran',
                'event' => 'Event',
                'technical' => 'Teknis'
            ];
        @endphp

        @foreach($categories as $categoryKey => $categoryName)
            @php
                $categoryFaqs = $faqs->where('category', $categoryKey);
            @endphp
            
            @if($categoryFaqs->isNotEmpty())
                <div class="faq-category mb-8" data-category="{{ $categoryKey }}">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                        <span class="w-2 h-8 bg-blue-600 rounded mr-3"></span>
                        {{ $categoryName }}
                    </h2>
                    
                    <div class="space-y-3">
                        @foreach($categoryFaqs as $faq)
                            <div class="faq-item bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden" data-question="{{ strtolower($faq->question) }}" data-answer="{{ strtolower($faq->answer) }}">
                                <button class="faq-question w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 transition">
                                    <span class="font-semibold text-gray-800 pr-4">{{ $faq->question }}</span>
                                    <svg class="w-5 h-5 text-blue-600 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                <div class="faq-answer hidden px-6 pb-4 pt-2">
                                    <div class="text-gray-600 leading-relaxed border-t border-gray-100 pt-4">
                                        {!! nl2br(e($faq->answer)) !!}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach

        <!-- No Results Message -->
        <div id="noResults" class="hidden text-center py-12">
            <svg class="w-24 h-24 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            <p class="text-gray-500 text-lg">Tidak ada pertanyaan yang cocok dengan pencarian Anda</p>
        </div>
    </div>

    <!-- Contact Section -->
    <div class="max-w-4xl mx-auto mt-12 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-8 text-center">
        <h3 class="text-2xl font-bold text-gray-800 mb-3">Tidak Menemukan Jawaban?</h3>
        <p class="text-gray-600 mb-6">Hubungi kami dan tim kami akan dengan senang hati membantu Anda</p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="mailto:info@apjikom.or.id" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition shadow-md">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                Email Kami
            </a>
            <a href="tel:+62123456789" class="inline-flex items-center px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition shadow-md">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                </svg>
                Hubungi Kami
            </a>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // FAQ Accordion Toggle
    const faqQuestions = document.querySelectorAll('.faq-question');
    faqQuestions.forEach(question => {
        question.addEventListener('click', function() {
            const faqItem = this.closest('.faq-item');
            const answer = faqItem.querySelector('.faq-answer');
            const icon = this.querySelector('svg');
            
            // Close all other FAQs
            document.querySelectorAll('.faq-item').forEach(item => {
                if (item !== faqItem) {
                    item.querySelector('.faq-answer').classList.add('hidden');
                    item.querySelector('.faq-question svg').style.transform = 'rotate(0deg)';
                }
            });
            
            // Toggle current FAQ
            answer.classList.toggle('hidden');
            if (answer.classList.contains('hidden')) {
                icon.style.transform = 'rotate(0deg)';
            } else {
                icon.style.transform = 'rotate(180deg)';
            }
        });
    });

    // Category Filter
    const categoryTabs = document.querySelectorAll('.category-tab');
    const faqCategories = document.querySelectorAll('.faq-category');
    
    categoryTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const category = this.dataset.category;
            
            // Update active tab
            categoryTabs.forEach(t => {
                t.classList.remove('active', 'bg-blue-600', 'text-white');
                t.classList.add('bg-gray-200', 'text-gray-700');
            });
            this.classList.add('active', 'bg-blue-600', 'text-white');
            this.classList.remove('bg-gray-200', 'text-gray-700');
            
            // Filter categories
            if (category === 'all') {
                faqCategories.forEach(cat => cat.style.display = 'block');
            } else {
                faqCategories.forEach(cat => {
                    if (cat.dataset.category === category) {
                        cat.style.display = 'block';
                    } else {
                        cat.style.display = 'none';
                    }
                });
            }
            
            // Reset search
            document.getElementById('faqSearch').value = '';
            showAllFaqs();
        });
    });

    // Search Functionality
    const searchInput = document.getElementById('faqSearch');
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const faqItems = document.querySelectorAll('.faq-item');
        let visibleCount = 0;
        
        faqItems.forEach(item => {
            const question = item.dataset.question;
            const answer = item.dataset.answer;
            
            if (question.includes(searchTerm) || answer.includes(searchTerm)) {
                item.style.display = 'block';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });
        
        // Show/hide no results message
        const noResults = document.getElementById('noResults');
        if (visibleCount === 0 && searchTerm !== '') {
            noResults.classList.remove('hidden');
            faqCategories.forEach(cat => cat.style.display = 'none');
        } else {
            noResults.classList.add('hidden');
            if (searchTerm === '') {
                showAllFaqs();
            }
        }
    });
    
    function showAllFaqs() {
        document.querySelectorAll('.faq-item').forEach(item => {
            item.style.display = 'block';
        });
        document.getElementById('noResults').classList.add('hidden');
    }
});
</script>
</body>
</html>
