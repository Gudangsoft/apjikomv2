@extends('layouts.member')

@section('title', 'Request Update & Masukan')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Request Update & Masukan</h2>
        <p class="text-gray-600 dark:text-gray-400 mt-1">Kirim request update fitur atau masukan untuk sistem</p>
    </div>

    <!-- Create New Request Button -->
    <div class="mb-6">
        <button onclick="openRequestModal()" class="bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700 flex items-center space-x-2 shadow-lg transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            <span>Buat Request Baru</span>
        </button>
    </div>

    <!-- Request List -->
    <div class="space-y-4">
        @forelse($updateRequests as $request)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 hover:shadow-lg transition">
                <div class="flex justify-between items-start mb-4">
                    <div class="flex-1">
                        <div class="flex items-center space-x-3 mb-2">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $request->title }}</h3>
                            <span class="px-3 py-1 text-xs font-semibold rounded-full
                                {{ $request->priority === 'urgent' ? 'bg-red-100 text-red-800' : '' }}
                                {{ $request->priority === 'high' ? 'bg-orange-100 text-orange-800' : '' }}
                                {{ $request->priority === 'medium' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $request->priority === 'low' ? 'bg-gray-100 text-gray-800' : '' }}">
                                {{ ucfirst($request->priority) }}
                            </span>
                            <span class="px-3 py-1 text-xs font-semibold rounded-full
                                {{ $request->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $request->status === 'in_progress' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $request->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $request->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                                {{ ucfirst(str_replace('_', ' ', $request->status)) }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                            📅 {{ $request->created_at->format('d M Y H:i') }}
                        </p>
                        <p class="text-gray-700 dark:text-gray-300 mb-3">{{ $request->description }}</p>
                        
                        @if($request->admin_notes)
                            <div class="bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-400 p-3 mt-3">
                                <p class="text-sm font-semibold text-blue-800 dark:text-blue-300 mb-1">📝 Catatan Admin:</p>
                                <p class="text-sm text-blue-700 dark:text-blue-400">{{ $request->admin_notes }}</p>
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Status Timeline -->
                @if($request->status !== 'pending')
                <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex items-center text-sm">
                        <div class="flex items-center {{ $request->status === 'pending' ? 'text-yellow-600' : 'text-green-600' }}">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span>Dikirim</span>
                        </div>
                        
                        <div class="flex-1 h-0.5 mx-2 {{ $request->status !== 'pending' ? 'bg-green-400' : 'bg-gray-300' }}"></div>
                        
                        <div class="flex items-center {{ $request->status === 'in_progress' || $request->status === 'completed' ? 'text-green-600' : 'text-gray-400' }}">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span>Dalam Proses</span>
                        </div>
                        
                        <div class="flex-1 h-0.5 mx-2 {{ $request->status === 'completed' ? 'bg-green-400' : 'bg-gray-300' }}"></div>
                        
                        <div class="flex items-center {{ $request->status === 'completed' ? 'text-green-600' : ($request->status === 'rejected' ? 'text-red-600' : 'text-gray-400') }}">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span>{{ $request->status === 'completed' ? 'Selesai' : ($request->status === 'rejected' ? 'Ditolak' : 'Selesai') }}</span>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        @empty
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-12 text-center">
                <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">Belum ada request</h3>
                <p class="mt-2 text-gray-500 dark:text-gray-400">Klik tombol "Buat Request Baru" untuk mengirim request atau masukan.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($updateRequests->hasPages())
        <div class="mt-6">
            {{ $updateRequests->links() }}
        </div>
    @endif
</div>

<!-- Create Request Modal -->
<div id="requestModal" class="fixed z-50 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeRequestModal()"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form action="{{ route('member.update-requests.store') }}" method="POST">
                @csrf
                <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Buat Request Update / Masukan Baru</h3>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Judul Request <span class="text-red-500">*</span></label>
                        <input type="text" name="title" required
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:ring-2 focus:ring-purple-500"
                               placeholder="Contoh: Tambah fitur export PDF">
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Deskripsi <span class="text-red-500">*</span></label>
                        <textarea name="description" rows="5" required
                                  class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:ring-2 focus:ring-purple-500"
                                  placeholder="Jelaskan detail request atau masukan Anda..."></textarea>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Prioritas <span class="text-red-500">*</span></label>
                        <select name="priority" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:ring-2 focus:ring-purple-500">
                            <option value="">Pilih Prioritas</option>
                            <option value="low">Low - Tidak mendesak</option>
                            <option value="medium" selected>Medium - Cukup penting</option>
                            <option value="high">High - Penting</option>
                            <option value="urgent">Urgent - Sangat mendesak</option>
                        </select>
                    </div>

                    <div class="bg-purple-50 dark:bg-purple-900/20 border-l-4 border-purple-400 p-3 text-sm text-purple-700 dark:text-purple-300">
                        <p class="font-semibold mb-1">💡 Tips:</p>
                        <ul class="list-disc list-inside space-y-1">
                            <li>Jelaskan request sejelas mungkin</li>
                            <li>Sebutkan fitur atau halaman yang dimaksud</li>
                            <li>Berikan contoh atau screenshot jika memungkinkan</li>
                        </ul>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-purple-600 text-base font-medium text-white hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Kirim Request
                    </button>
                    <button type="button" onclick="closeRequestModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-800 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openRequestModal() {
    document.getElementById('requestModal').classList.remove('hidden');
}

function closeRequestModal() {
    document.getElementById('requestModal').classList.add('hidden');
}
</script>
@endsection
