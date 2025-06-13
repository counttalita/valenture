@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6" x-data="learnerProgress()" x-init="init()">
    <h1 class="text-2xl font-bold mb-6">Learner Progress Dashboard</h1>
    <div class="grid gap-6">
        <!-- Learners List -->
        <template x-if="learners && learners.length === 0">
    <div class="flex flex-col items-center justify-center py-16">
        <svg class="h-16 w-16 text-gray-300 mb-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2a4 4 0 014-4h3a4 4 0 014 4v2M9 7a4 4 0 118 0 4 4 0 01-8 0z" /></svg>
        <div class="text-gray-500 text-lg font-semibold">No learners found.</div>
        <div class="text-gray-400 text-sm mt-1">Try adjusting your filters or check back later.</div>
    </div>
</template>
        <template x-for="learner in learners" :key="learner.id">
    <div class="bg-white rounded-2xl shadow-lg p-6 flex flex-col gap-3 hover:shadow-2xl transition-shadow duration-300">
        <div class="flex items-center gap-4 mb-2">
            <div class="w-12 h-12 rounded-full flex items-center justify-center bg-gradient-to-tr from-blue-400 to-indigo-500 text-white text-xl font-bold shadow-md">
                <span x-text="
    ((learner.firstname && learner.firstname.length > 0 ? learner.firstname[0] : '?') +
    (learner.lastname && learner.lastname.length > 0 ? learner.lastname[0] : '?')).toUpperCase()"></span>
            </div>
            <div>
                <h2 class="font-semibold text-lg text-gray-900" x-text="(learner.firstname ?? '') + ' ' + (learner.lastname ?? '')"></h2>
                <span class="text-xs text-gray-500" x-text="'Learner #' + learner.id"></span>
            </div>
        </div>
        <div class="ml-2 mt-2">
            <template x-if="learner.courses.length === 0">
                <div class="text-gray-400 text-sm">No courses enrolled.</div>
            </template>
            <template x-for="course in learner.courses" :key="course.id">
                <div class="mb-2">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-800 font-medium" x-text="course.name"></span>
                        <span class="text-xs text-gray-500 font-mono" x-text="(course.pivot.progress ?? 0) + '%' "></span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5 mt-1">
                        <div class="bg-gradient-to-r from-blue-400 to-indigo-500 h-2.5 rounded-full transition-all duration-300" :style="'width: ' + (course.pivot.progress ?? 0) + '%'" role="progressbar" :aria-valuenow="course.pivot.progress ?? 0" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </template>
        </div>
    </div>
</template>
    </div>
    <!-- Pagination Controls -->
    <div class="flex justify-center items-center mt-8" x-show="totalPages > 1">
        <button @click="goToPage(currentPage - 1)" :disabled="currentPage === 1 || loading" class="px-3 py-1 mx-1 rounded bg-gray-200 text-gray-700 font-semibold hover:bg-gray-300 disabled:opacity-50">Prev</button>
        <template x-for="page in Array.from({length: totalPages}, (_, i) => i + 1)" :key="page">
            <button @click="goToPage(page)" :class="{'bg-blue-500 text-white': currentPage === page, 'bg-gray-200 text-gray-700': currentPage !== page}" class="px-3 py-1 mx-1 rounded font-semibold hover:bg-blue-100 disabled:opacity-50" :disabled="loading" x-text="page"></button>
        </template>
        <button @click="goToPage(currentPage + 1)" :disabled="currentPage === totalPages || loading" class="px-3 py-1 mx-1 rounded bg-gray-200 text-gray-700 font-semibold hover:bg-gray-300 disabled:opacity-50">Next</button>
    </div>
    <!-- Loading Spinner -->
    <div class="flex justify-center mt-4" x-show="loading">
        <svg class="animate-spin h-8 w-8 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
        </svg>
    </div>
</div>

<!-- Alpine.js logic -->
<script>
function learnerProgress() {
    return {
        learners: [],
        courses: [],
        selectedCourseId: '',
        currentPage: 1,
        totalPages: 1,
        perPage: 10,
        loading: false,
        async fetchCourses() {
            const res = await fetch('/api/courses');
            this.courses = await res.json();
        },
        async fetchLearners(page = 1) {
            this.loading = true;
            let url = `/api/learners?page=${page}&per_page=${this.perPage}`;
            if (this.selectedCourseId) {
                url += `&course_id=${this.selectedCourseId}`;
            }
            const res = await fetch(url);
            const data = await res.json();
            if (Array.isArray(data)) {
                this.learners = data;
                this.currentPage = 1;
                this.totalPages = 1;
            } else {
                this.learners = data.data ?? [];
                this.currentPage = data.current_page ?? 1;
                this.totalPages = data.last_page ?? 1;
            }
            this.loading = false;
        },
        applyCourseFilter() {
            this.currentPage = 1;
            this.fetchLearners();
        },
        clearCourseFilter() {
            this.selectedCourseId = '';
            this.currentPage = 1;
            this.fetchLearners();
        },
        init() {
            this.fetchCourses();
            this.fetchLearners();
        },
        goToPage(page) {
            if (page < 1 || page > this.totalPages) return;
            this.fetchLearners(page);
        }
    }
}
</script>
@endsection
