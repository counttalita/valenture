@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6" x-data="learnerProgress()" x-init="init()">
    <h1 class="text-2xl font-bold mb-6">Learner Progress Dashboard</h1>
    <div class="grid gap-6">
        <!-- Learners List -->
        <template x-if="learners.length === 0">
            <div class="text-gray-500">No learners found.</div>
        </template>
        <template x-for="learner in learners" :key="learner.id">
    <div class="bg-white rounded-2xl shadow-lg p-6 flex flex-col gap-3 hover:shadow-2xl transition-shadow duration-300">
        <div class="flex items-center gap-4 mb-2">
            <div class="w-12 h-12 rounded-full flex items-center justify-center bg-gradient-to-tr from-blue-400 to-indigo-500 text-white text-xl font-bold shadow-md">
                <span x-text="(learner.firstname.charAt(0) + learner.lastname.charAt(0)).toUpperCase()"></span>
            </div>
            <div>
                <h2 class="font-semibold text-lg text-gray-900" x-text="learner.firstname + ' ' + learner.lastname"></h2>
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
</div>

<!-- Alpine.js logic -->
<script>
function learnerProgress() {
    return {
        learners: [],
        async init() {
            const res = await fetch('/api/learners');
            this.learners = await res.json();
        }
    }
}
</script>
@endsection
